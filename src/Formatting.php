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
     * @param array $output Array with unformated shipment prices.
     *
     * @return array Array of transactions with formatted shipment prices.
     */
    public static function formatShipmentPrice(array $output): array
    {
        foreach ($output as &$transaction) {
            $splitTransaction = explode(' ', $transaction);

            if (count($splitTransaction) != 5) {
                continue;
            }

            $splitTransaction[3] = number_format((float) $splitTransaction[3], 2);

            $transaction = implode(' ', $splitTransaction);
        }
        return $output;
    }

    /**
     * Reads data from a file and formats discounts.
     *
     * @param array $output Array with unformated discounts.
     *
     * @return array Array of transactions with formatted discounts.
     */
    public static function formatShipmentDiscount(array $output): array
    {
        foreach ($output as &$transaction) {
            $splitTransaction = explode(' ', $transaction);

            if (count($splitTransaction) != 5) {
                continue;
            }

            if ($splitTransaction[4] == 0) {
                $splitTransaction[4] = '-';
            } else {
                $splitTransaction[4] = number_format((float) $splitTransaction[4], 2);
            }
            $transaction = implode(' ', $splitTransaction);
        }
        return $output;
    }
}
