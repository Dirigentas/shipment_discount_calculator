<?php

/**
 * File purpose is to calculate discounts on shipments.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount;

/**
 * Class Calculations contains methods for calculating discounts on shipments.
 */
class Calculations
{
    /**
     * Adds all prices and applies a discount to the chosen package size.
     *
     * @param array $output       The array of transactions to be processed.
     * @param array $couriers Contains the courier and package size information.
     *
     * @return array Array of transactions with the S package discount applied.
     */
    public static function matchLowestProviderPrice(array $output, array $couriers): array
    {
        // Control panel, can modify the $packageSizeForRule variable.
        $packageSizeForRule = 'S';

        // Finds the lowest price from chosen package size
        $lowestPrice = INF;
        foreach ($couriers as $courier => $price) {
            if ($price[$packageSizeForRule] < $lowestPrice) {
                $lowestPrice = $price[$packageSizeForRule];
            }
        }

        // Adds all prices and chosen size package discounts
        foreach ($output as $key => &$transaction) {
            if (str_contains($transaction, 'Ignored')) {
                continue;
            }

            $splitTransaction = explode(' ', $transaction);

            foreach ($couriers as $courier => $prices) {
                if ($courier === trim($splitTransaction[2])) {
                    foreach ($prices as $size => $price) {
                        if ($size === $splitTransaction[1]) {
                            if ($splitTransaction[1] === $packageSizeForRule) {
                                $transaction .= ' ' . $lowestPrice . ' ' . $price - $lowestPrice;
                            } else {
                                $transaction .= ' ' . $price . ' ' . 0;
                            }
                        }
                    }
                }
            }
        }
        return $output;
    }

    /**
     * Applies a free shipment once per month to the chosen provider, size.
     *
     * @param array $output       The array of transactions to be processed.
     * @param array $couriers Contains the courier and package size information.
     *
     * @return array Array of transactions with the L package discount applied.
     */
    public static function freeOncePerMonth(array $output, array $couriers): array
    {
        // Control panel, can modify all variables.
        $freeTransactionNo = 3;
        $packageSizeForRule = 'L';
        $providerForRule = 'LP';

        // Variables used for calculations
        $freeTransactionNoCounter = 0;
        $oneFreeCounter = [];

        foreach ($output as &$transaction) {
            if (str_contains($transaction, 'Ignored')) {
                continue;
            }

            $splitTransaction = explode(' ', $transaction);

            if (
                trim($splitTransaction[2]) === $providerForRule
                && trim($splitTransaction[1]) === $packageSizeForRule
            ) {
                if (!in_array(date('Y n', strtotime($splitTransaction[0])), $oneFreeCounter)) {
                    $oneFreeCounter[] = date('Y n', strtotime($splitTransaction[0]));
                    $freeTransactionNoCounter = 0;
                }

                $freeTransactionNoCounter += 1;

                if ($freeTransactionNoCounter === $freeTransactionNo) {
                    $splitTransaction[3] = 0;

                    $splitTransaction[4] = $couriers[$providerForRule][$packageSizeForRule];

                    $transaction = implode(' ', $splitTransaction);
                }
            }
        }
        return $output;
    }

    /**
     * Applies monthly limits to discounts for a given set of transactions.
     *
     * @param array $output The array of transactions to be processed.
     *
     * @return array Returns an array of transactions with the limited discounts.
     */
    public static function limitsDiscounts(array $output): array
    {
        // Control panel, can modify the $monthlyDiscountLimit variable.
        $monthlyDiscountLimit = 10;

        foreach ($output as $key => &$transaction) {
            $splitTransaction = explode(' ', $transaction);

            if (
                str_contains($transaction, 'Ignored')
                || $splitTransaction[4] == 0
            ) {
                continue;
            }

            // not a good practise to place '@', but I did it to lower the amount of code
            @$totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] += $splitTransaction[4];

            if ($totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))] > $monthlyDiscountLimit) {
                $splitTransaction[3] += $totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))]
                - $monthlyDiscountLimit;

                $splitTransaction[4] -= $totalMonthsDiscount[date('Y n', strtotime($splitTransaction[0]))]
                - $monthlyDiscountLimit;

                $transaction = implode(' ', $splitTransaction);
            }
        }
        return $output;
    }
}
