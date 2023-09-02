<?php

declare(strict_types=1);

namespace Aras\VintedShipmentDiscount;

class Calculations
{
    /**
     * Formats a given number.
     *
     * @param float $number The number to be formatted.
     *
     * @return string|float Returns '-' if the number is 0, otherwise with 2 decimal places.
     */
    private static function _numberFormat(float $number): string|float
    {
        if ($number == 0) {
            return '-';
        } else {
            return number_format($number, 2);
        }
    }

    /**
     * Applies a discount to the S package for a given set of transactions.
     *
     * @param array $output       The array of transactions to be processed.
     * @param array $controlPanel Contains the courier and package size information.
     *
     * @return array Array of transactions with the S package discount applied.
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
     * Applies a discount to the L package for a given set of transactions.
     *
     * @param array $output       The array of transactions to be processed.
     * @param array $controlPanel Contains the courier and package size information.
     *
     * @return array Array of transactions with the L package discount applied.
     */
    private static function _lPackageDiscount(array $output, array $controlPanel): array
    {
        $everyThirdCounter = 0;
        $oneFreeCounter = [];

        foreach ($output as $key => &$transaction) {

            if (str_contains($transaction, 'Ignored')) {
                continue;
            }

            $splitTransaction = explode(' ', $transaction);
            
            if (trim($splitTransaction[2]) === 'LP' 
                && trim($splitTransaction[1]) === 'L'
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
        return self::limitsDiscounts($output, $controlPanel);
    }
    
    /**
     * Applies monthly limits to discounts for a given set of transactions.
     *
     * @param array $output       The array of transactions to be processed.
     * @param array $controlPanel Contains the courier and package size information.
     *
     * @return array Returns an array of transactions with the limited discounts.
     */
    private static function _limitsDiscounts(array $output, array $controlPanel): array
    {
        foreach ($output as $key => &$transaction) {
            
            $splitTransaction = explode(' ', $transaction);

            if (str_contains($transaction, 'Ignored') 
                || $splitTransaction[4] === '-'
            ) {
                continue;
            }

            // not a good practise to place '@', but I did it to lower the amount of code
            @$totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] += $splitTransaction[4];

            if ($totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] > 10) {
                
                $splitTransaction[3] += $totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] - 10;
                $splitTransaction[4] -= $totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] - 10;
                $splitTransaction[3] = number_format($splitTransaction[3], 2);
                $splitTransaction[4] = self::numberFormat($splitTransaction[4]);
                $transaction = implode(' ', $splitTransaction);
            }
        }
        return $output;
    }
}

?>
