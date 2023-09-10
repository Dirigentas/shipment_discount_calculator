<?php

/**
 * File purpose is to read file data.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount;

/**
 * Class FileReader reads data from the file.
 */
class FileReader
{
    /**
     * Reads data from a file and processes it.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return array Array of transactions from input.txt.
     */
    public static function getFileData(string $fileName): array
    {
        $input = explode("\r\n", file_get_contents('./public/' . $fileName));

        return $input;
    }

    /**
     * Explodes transactions from strings to arrays.
     *
     * @param array $input An array of string transactions.
     *
     * @return array[] An array of array transactions.
     */
    public static function makeTransactionArray(array $input): array
    {
        foreach ($input as &$transaction) {
            $transaction = explode(' ', $transaction);
        }
        return $input;
    }
}
