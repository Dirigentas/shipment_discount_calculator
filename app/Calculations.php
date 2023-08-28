<?php

declare(strict_types=1);

namespace ShipmentDiscount;

class Calculations
{
    /**
     * 
     * 
     * @param
     * @return
     */
    public static function lowestPrice(array $output, array $controlPanel): array
    {         
        $lowestSprice = INF;
        $lowestScourier;

        foreach ($controlPanel as $key => $value) {
            if ($value['S'] < $lowestSprice) {
                $lowestSprice = $value['S'];
                $lowestScourier = $key;
            }
        }
        // foreach ($output as $key => &$value) {
        //     if (
        //         !str_contains($value, 'Ignored') &&
        //         explode(' ', $value)[1] === 'S'
        //     ) {
        //         $value = $value . $lowestSprice;
        //     }
        // }
        foreach ($output as $key => &$transaction) {

            if (str_contains($transaction, 'Ignored')) {
                continue;
            }

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

            $splitTransaction = explode(' ', $transaction);

            foreach ($controlPanel as $courier => $prices) {
                if ($courier === trim($splitTransaction[2])) {
                    foreach ($prices as $size => $price) {
                        if ($size === $splitTransaction[1]) {
                            $transaction .= ' ' . number_format($price, 2);
                        }
                    }
                }
            }
        }
        return $output;
    }
}

?>