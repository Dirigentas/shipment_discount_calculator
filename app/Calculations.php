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

            foreach (array_keys($controlPanel) as $courier) {
                if ($courier === trim($splitTransaction[2])) {
                    echo $courier . '<br>';
                    foreach (array_keys($courier) as $size) {
                        if ($size === $splitTransaction[1]) {
                            echo $transaction . '<br>';
                        }
                    }
                }
            }
        }
        return $output;
    }
}

?>