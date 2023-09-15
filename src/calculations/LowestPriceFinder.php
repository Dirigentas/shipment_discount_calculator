<?php

/**
 * File purpose is to calculate discounts on shipments.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount\calculations;

/**
 * Class LowestPriceFinder contains methods for calculating discount on shipments.
 */
class LowestPriceFinder
{
    /**
     * Applies a discount to the chosen package size.
     *
     * @param array[] $output   The array of transactions to be processed.
     * @param array[] $couriersDetails Contains the courier and package size information.
     *
     * @return array[] Array of transactions with the S package discount applied.
     */
    public static function matchLowestProviderPrice(array $output, array $couriersDetails): array
    {
        // Control panel, can modify the $packageSizeForRule variable.
        $packageSizeForRule = 'S';

        // Finds the lowest price from chosen package size
        $lowestPrice = INF;
        foreach ($couriersDetails as $courier => $price) {
            if ($price[$packageSizeForRule] < $lowestPrice) {
                $lowestPrice = $price[$packageSizeForRule];
            }
        }

        foreach ($output as $key => &$transaction) {
            if (in_array('Ignored', $transaction)) {
                continue;
            }

            foreach ($couriersDetails as $courier => $prices) {
                foreach ($prices as $size => $price) {
                    if (
                        $courier === $transaction['transactionCourier']
                        && $size === $transaction['transactionSize']
                        && $transaction['transactionSize'] === $packageSizeForRule
                    ) {
                        $transaction['transactionPrice'] = $lowestPrice;
                        $transaction['transactionDiscount'] = $price - $lowestPrice;
                    }
                }
            }
        }
        return $output;
    }
}
