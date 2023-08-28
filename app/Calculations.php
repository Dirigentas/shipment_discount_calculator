<?php

declare(strict_types=1);

namespace ShipmentDiscount;

class Calculations
{
    private static function numberFormat (float $number)
    {
        if ($number == 0) {
            return '-';
        } else {
            return number_format($number, 2);
        }
    }

    /**
     * 
     * 
     * @param
     * @return
     */
    public static function sPackageDiscount(array $output, array $controlPanel): array
    {         
        $lowestSprice = INF;
        $lowestScourier = '';

        foreach ($controlPanel as $key => $value) {
            if ($value['S'] < $lowestSprice) {
                $lowestSprice = $value['S'];
                $lowestScourier = $key;
            }
        }
        
        foreach ($output as $key => &$transaction) {

            if (str_contains($transaction, 'Ignored')) {
                continue;
            }

            $splitTransaction = explode(' ', $transaction);

            foreach ($controlPanel as $courier => $prices) {
                if ($courier === trim($splitTransaction[2])) {
                    foreach ($prices as $size => $price) {
                        if ($size === $splitTransaction[1]) {
                            if ($splitTransaction[1] === 'S') {
                                $transaction .= ' ' . self::numberFormat($lowestSprice) . ' ' . self::numberFormat($price - $lowestSprice);
                            } else {
                                $transaction .= ' ' . self::numberFormat($price) . ' -';
                            }
                        }
                    }
                }
            }            
        }
        return self::lPackageDiscount($output, $controlPanel);
    }

    /**
     * 
     */
    private static function lPackageDiscount (array $output, array $controlPanel): array
    {
        $everyThirdCounter = 0;
        $oneFreeCounter = [];

        foreach ($output as $key => &$transaction) {

            if (str_contains($transaction, 'Ignored')) {
                continue;
            }

            $splitTransaction = explode(' ', $transaction);
            
            if (
                trim($splitTransaction[2]) === 'LP' &&
                trim($splitTransaction[1]) === 'L'
            ) {
                $everyThirdCounter += 1;

                if ($everyThirdCounter % 3 === 0) {
                    if (!in_array(date('Y n', strtotime($splitTransaction[0])), $oneFreeCounter)) {

                        $splitTransaction[3] = number_format(0, 2);

                        $splitTransaction[4] = number_format($controlPanel['LP']['L'], 2);

                        $oneFreeCounter[] = date('Y n', strtotime($splitTransaction[0]));

                        $transaction = implode(' ', $splitTransaction);
                    }
                }
            }
        }    
        return self::totalDiscouns($output, $controlPanel);
    }
    
    /**
     * 
     */
    private static function totalDiscouns(array $output, array $controlPanel): array
    {
            // $controlPanel = [
        //     'LP' => [
        //         'S' => 1.5,
        //         'M' => 4.9,
        //         'L' => 6.9
        //     ],
        //     'MR' => [
        //         'S' => 2,
        //         'M' => 3,
        //         'L' => 4
        //     ]
        // ];

        foreach ($output as $key => &$transaction) {
            
            $splitTransaction = explode(' ', $transaction);

            if (
                str_contains($transaction, 'Ignored') ||
                $splitTransaction[4] === '-'
            ) {
                continue;
            }

            // I know that it's a not a good practise to place '@', but I did it to lower the amount of code
            @$totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] += $splitTransaction[4];
            print_r($totalMonthsDiscount);
            echo '<br>';

        }

        return $output;
    }
}

?>