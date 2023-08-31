<?php

declare(strict_types=1);

namespace ShipmentDiscount;

use ShipmentDiscount\Calculations;

class InputProcessing
{
     /**
     * Verifies the input data and returns an array containing the verified output: date format, size, courier
     *
     * @param array $input An array of strings representing transactions. Each transaction format should be in according to $controlPanel structure.
     * @return array[] An array containing two elements: the original input array and an array of verified transactions. Transactions that do not match the expected format or contain invalid values are appended with "Ignored".
     */
    public static function dataVerification(array $input): array
    { 
        // Regular expression to match valid ISO 8601 date format (YYYY-MM-DD)
        $isoPattern = "/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";

        // Control panel: all possible sizes, couriers and prices; add new or modify existing ones
        $controlPanel = [
            'LP' => [
                'S' => 1.5,
                'M' => 4.9,
                'L' => 6.9
            ],
            'MR' => [
                'S' => 2,
                'M' => 3,
                'L' => 4
            ]
        ];

        $output = [];

        foreach ($input as $transaction) {

            $splitUpTransaction = explode(' ', $transaction);

            if (
                count($splitUpTransaction) == 3 &&
                preg_match($isoPattern, $splitUpTransaction[0])
            ) {
                if (in_array($splitUpTransaction[1], array_keys($controlPanel[array_key_first($controlPanel)]))) {
                    if (in_array(trim($splitUpTransaction[2]), array_keys($controlPanel))) {
                        $output[] = $transaction;
                    } else {
                        $output[] = $transaction . 'Ignored';
                    }
                } else {
                    $output[] = $transaction . 'Ignored';
                }
            } else {
                $output[] = $transaction . 'Ignored';
            }
        }
        $output = Calculations::sPackageDiscount($output, $controlPanel);

        return [$input, $output];
    }
}

?>