<?php

declare(strict_types=1);

namespace ShipmentDiscount;

class InputProcessing
{
    /**
     * Verifies if transactions data format is correct
     * 
     * @param 
     * @return
     */
    public static function dataVerification(array $input): array
    { 
        // Regular expression to match valid ISO 8601 date format (YYYY-MM-DD)
        $isoPattern = "/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";

        $output = [];

        foreach ($input as $transaction) {

            $splitUpTransaction = explode(' ', $transaction);

            if (
                count($splitUpTransaction) == 3 &&
                preg_match($isoPattern, $splitUpTransaction[0])
            ) {
                echo 'Ilgis/data' . $transaction . '<br>';
                if (
                    $splitUpTransaction[1] == 'S' ||
                    $splitUpTransaction[1] == 'M' ||
                    $splitUpTransaction[1] == 'L'
                ) {
                    echo 'dydis' . $transaction . '<br>';
                    echo 'Hmmmm ' . $splitUpTransaction[2] . '<br>';
                    if (
                        $splitUpTransaction[2] == 'MR' ||
                        $splitUpTransaction[2] == 'LP'
                    ) {
                        echo 'kurjeris' . $transaction . '<br>';
                        $output[] = $transaction;
                    } else {
                        $output[] = $transaction . ' Ignored';
                    }
                } else {
                    $output[] = $transaction . ' Ignored';
                }
            } else {
                $output[] = $transaction . ' Ignored';
            }
        }

        return [$input, $output];
    }
}

?>