<?php

/**
 * File purpose is to format output appropriately.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount;

/**
 * Class Formatting is responsible for formatting given numbers.
 */
class Formatting
{
    /**
     * Reads data from a file and formats shipment prices.
     *
     * @param array[] $output Array with unformated shipment prices.
     *
     * @return array[] Array of transactions with formatted shipment prices.
     */
    public static function formatShipmentPrice(array $output): array
    {
        foreach ($output as &$transaction) {
            if (in_array('Ignored', $transaction)) {
                continue;
            }

            $transaction['transactionPrice'] = number_format($transaction['transactionPrice'], 2);
        }
        return $output;
    }

    /**
     * Reads data from a file and formats discounts.
     *
     * @param array[] $output Array with unformated discounts.
     *
     * @return array[] Array of transactions with formatted discounts.
     */
    public static function formatShipmentDiscount(array $output): array
    {
        foreach ($output as &$transaction) {
            if (in_array('Ignored', $transaction)) {
                continue;
            }

            if ($transaction['transactionDiscount'] == 0) {
                $transaction['transactionDiscount'] = '-';
            } else {
                $transaction['transactionDiscount'] = number_format($transaction['transactionDiscount'], 2);
            }
        }
        return $output;
    }
}
