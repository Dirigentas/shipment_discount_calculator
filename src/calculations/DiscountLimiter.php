<?php

/**
 * File purpose is to calculate discounts on shipments.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount\calculations;

/**
 * Class Calculations contains methods for calculating discounts on shipments.
 */
class DiscountLimiter
{
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
                || $transaction['transactionDiscount'] == 0
            ) {
                continue;
            }

            // not a good practise to place '@', but I did it to lower the amount of code
            @$totalMonthsDiscount[date('Y n', strtotime($transaction['transactionDate']))] += $transaction['transactionDiscount'];

            if ($totalMonthsDiscount[date('Y n', strtotime($transaction['transactionDate']))] > $monthlyDiscountLimit) {
                $transaction['transactionPrice'] += $totalMonthsDiscount[date('Y n', strtotime($transaction['transactionDate']))] - $monthlyDiscountLimit;

                $transaction['transactionPrice'] = round($transaction['transactionPrice'], 2);
                
                $transaction['transactionDiscount'] -= $totalMonthsDiscount[date('Y n', strtotime($transaction['transactionDate']))] - $monthlyDiscountLimit;
                
                $transaction['transactionDiscount'] = round($transaction['transactionDiscount'], 2);
            }
        }
        return $output;
    }
}
