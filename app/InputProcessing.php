<?php

declare(strict_types=1);

namespace ShipmentDiscount;

class InputProcessing
{
    /**
     * Verifies if transactions data format is correct: date format, size, courier
     * 
     * @param array $input Data from 'input.txt' file
     * @return array[] $arrayOfArrays An array of 'input' and 'output' arrays
     */
    public static function dataVerification(array $input): array
    { 
        // Regular expression to match valid ISO 8601 date format (YYYY-MM-DD)
        $isoPattern = "/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";

        // Control panel: all possible sizes and couriers, add new or modify existing ones 
        $sizes = ['S', 'M', 'L'];        
        $couriers = ['MR', 'LP'];


        $output = [];

        foreach ($input as $transaction) {

            $splitUpTransaction = explode(' ', $transaction);

            if (
                count($splitUpTransaction) == 3 &&
                preg_match($isoPattern, $splitUpTransaction[0])
            ) {
                if (
                    in_array(trim($splitUpTransaction[1]), $sizes)
                ) {
                    if (
                        in_array(trim($splitUpTransaction[2]), $couriers)
                    ) {
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

        return [$input, $output];
    }
}

?>