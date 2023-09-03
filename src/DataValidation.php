<?php

/**
 * File purpose is to make data validation.
 */

declare(strict_types=1);

namespace Aras\VintedShipmentDiscount;

/**
 * Class DataValidation mekes all required data validations.
 */
class DataValidation
{
     /**
      * Verifies the input data and returns an array of verified output.
      *
      * @param array $input        An array of transactions.
      * @param array $controlPanel An array containing the settings for couriers,package sizes, prices.
      *
      * @return array An array of checked and ignored transactions.
      */
    public static function dataVerification(array $input, array $controlPanel): array
    {
        // Regular expression to match valid ISO 8601 date format (YYYY-MM-DD)
        $isoPattern = "/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";

        $output = [];

        foreach ($input as $transaction) {
            $splitUpTransaction = explode(' ', $transaction);

            if (
                count($splitUpTransaction) == 3
                && preg_match($isoPattern, $splitUpTransaction[0])
                && in_array($splitUpTransaction[1], array_keys($controlPanel[array_key_first($controlPanel)]))
                && in_array(trim($splitUpTransaction[2]), array_keys($controlPanel))
            ) {
                $output[] = $transaction;
            } else {
                $output[] = $transaction . ' Ignored';
            }
        }

        return $output;
    }
}
