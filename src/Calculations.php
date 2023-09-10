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
     * Applies a discount to the chosen package size.
     *
     * @param array[] $output   The array of transactions to be processed.
     * @param array[] $couriers Contains the courier and package size information.
     *
     * @return array[] Array of transactions with the S package discount applied.
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

        foreach ($output as $key => &$transaction) {
            if (in_array('Ignored', $transaction)) {
                continue;
            }

            foreach ($couriers as $courier => $prices) {
                if ($courier === $transaction[2]) {
                    foreach ($prices as $size => $price) {
                        if ($size === $transaction[1]) {
                            if ($transaction[1] === $packageSizeForRule) {
                                $transaction[3] = $lowestPrice;
                                $transaction[4] = $price - $lowestPrice;
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
     * @param array[] $output       The array of transactions to be processed.
     * @param array[] $couriers Contains the courier and package size information.
     *
     * @return array[] Array of transactions with the L package discount applied.
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
            if (in_array('Ignored', $transaction)) {
                continue;
            }

            if (
                $transaction[2] === $providerForRule
                && $transaction[1] === $packageSizeForRule
            ) {
                if (!in_array(date('Y n', strtotime($transaction[0])), $oneFreeCounter)) {
                    $oneFreeCounter[] = date('Y n', strtotime($transaction[0]));
                    $freeTransactionNoCounter = 0;
                }

                $freeTransactionNoCounter += 1;

                if ($freeTransactionNoCounter === $freeTransactionNo) {
                    $transaction[3] = 0;

                    $transaction[4] = $couriers[$providerForRule][$packageSizeForRule];
                }
            }
        }
        return $output;
    }

    /**
     * Applies monthly limits to discounts for a given set of transactions.
     *
     * @param array[] $output The array of transactions to be processed.
     *
     * @return array[] Returns an array of transactions with the limited discounts.
     */
    public static function limitsDiscounts(array $output): array
    {
        // Control panel, can modify the $monthlyDiscountLimit variable.
        $monthlyDiscountLimit = 10;

        foreach ($output as $key => &$transaction) {
            if (
                in_array('Ignored', $transaction)
                || $transaction[4] == 0
            ) {
                continue;
            }

            // not a good practise to place '@', but I did it to lower the amount of code
            @$totalMonthsDiscount[date('Y n', strtotime($transaction[0]))] += $transaction[4];

            if ($totalMonthsDiscount[date('Y n', strtotime($transaction[0]))] > $monthlyDiscountLimit) {
                $transaction[3] += $totalMonthsDiscount[date('Y n', strtotime($transaction[0]))]
                - $monthlyDiscountLimit;

                $transaction[4] -= $totalMonthsDiscount[date('Y n', strtotime($transaction[0]))]
                - $monthlyDiscountLimit;
            }
        }
        return $output;
    }
}
