<?php

/**
 * File purpose is to make data validation.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount;

/**
 * Class DataValidation mekes all required data validations.
 */
class DataValidation
{
     /**
      * Verifies the input data and returns an array of verified output.
      *
      * @param array $input    An array of transactions.
      * @param array[] $couriersDetails An array containing the settings for couriers,package sizes, prices.
      * @param array $inputDataStructure Array of input data names.
      *
      * @return array An array of checked and ignored transactions.
      */
    public static function dataVerification(array $input, array $couriersDetails, array $inputDataStructure): array
    {
        // Regular expression to match valid ISO 8601 date format (YYYY-MM-DD)
        $isoPattern = "/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";

        foreach ($input as &$transaction) {
            if (count($transaction) != count($inputDataStructure)) {
                $transaction[] = 'Ignored';
                continue;
            }

            $transaction = array_combine($inputDataStructure, $transaction);
            
            if (
                !(preg_match($isoPattern, $transaction['transactionDate'])
                && in_array($transaction['transactionSize'], array_keys($couriersDetails[array_key_first($couriersDetails)]))
                && in_array(trim($transaction['transactionCourier']), array_keys($couriersDetails)))
            ) {
                $transaction[] = 'Ignored';
            }
        }
        return $input;
    }

    /**
     * Adds base prices to all transactions.
     *
     * @param array[] $output An array of array transactions.
     * @param array[] $couriersDetails An array containing the settings for couriers,package sizes, prices.
     *
     * @return array[] An array of array transactions with added base prices.
     */
    public static function addShipmentPrices(array $output, array $couriersDetails): array
    {
        foreach ($output as $key => &$transaction) {
            if (in_array('Ignored', $transaction)) {
                continue;
            }

            foreach ($couriersDetails as $courier => $prices) {
                if ($courier === $transaction['transactionCourier']) {
                    foreach ($prices as $size => $price) {
                        if ($size === $transaction['transactionSize']) {
                            $transaction['transactionPrice'] = $price;
                            $transaction['transactionDiscount'] = 0;
                        }
                    }
                }
            }
        }
        return $output;
    }
}
