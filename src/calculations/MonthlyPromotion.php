<?php

/**
 * File purpose is to calculate discounts on shipments.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount\calculations;

/**
 * Class Calculations contains methods for calculating discounts on shipments.
 */
class MonthlyPromotion
{
    /**
     * Applies a free shipment once per month to the chosen provider, size.
     *
     * @param array[] $output       The array of transactions to be processed.
     * @param array[] $couriersDetails Contains the courier and package size information.
     *
     * @return array[] Array of transactions with the L package discount applied.
     */
    public static function freeOncePerMonth(array $output, array $couriersDetails): array
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
                $transaction['transactionCourier'] === $providerForRule
                && $transaction['transactionSize'] === $packageSizeForRule
            ) {
                if (!in_array(date('Y n', strtotime($transaction['transactionDate'])), $oneFreeCounter)) {
                    $oneFreeCounter[] = date('Y n', strtotime($transaction['transactionDate']));
                    $freeTransactionNoCounter = 0;
                }

                $freeTransactionNoCounter += 1;

                if ($freeTransactionNoCounter === $freeTransactionNo) {
                    $transaction['transactionPrice'] = 0;

                    $transaction['transactionDiscount'] = $couriersDetails[$providerForRule][$packageSizeForRule];
                }
            }
        }
        return $output;
    }
}
