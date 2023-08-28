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
        
        $ArrayS = [];
        $lowestSprice = INF;
        $lowestScourier;

        foreach ($controlPanel as $key => $value) {
            if ($value['S'] < $lowestSprice) {
                $lowestSprice = $value['S'];
                $lowestScourier = $key;
            }
        }

        foreach ($output as $key => &$value) {
            if (explode(' ', $value)[1] === 'S') {
                $value = $value . $lowestSprice;
            }
        }

        return $output;
    }
}

?>