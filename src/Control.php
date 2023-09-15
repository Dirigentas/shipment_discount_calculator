<?php

/**
 * File purpose is to make adjustments to $couriersDetails and call all required methods.
 */

declare(strict_types=1);

namespace Aras\ShipmentDiscount;

use Aras\ShipmentDiscount\FileReader;
use Aras\ShipmentDiscount\DataValidation;
use Aras\ShipmentDiscount\Calculations;

/**
 * Class Control controls all pats of the solution.
 */
final class Control
{
     /**
      * @var array $couriersDetails An associative array containing the settings for couriers details.
      */
    private $couriersDetails = [
        'LP' => [
            'S' => 1.5,
            'M' => 4.9,
            'L' => 6.9
        ],
        'MR' => [
            'S' => 2,
            'M' => 3,
            'L' => 4
        ]
    ];

    /**
     * @var array $inputDataStructure Array of input data names.
     */
    private $inputDataStructure = ['transactionDate', 'transactionSize', 'transactionCourier'];

    /**
     * This method executes all needed classes.
     *
     * @return void
     */
    public function executeAllClasses(): void
    {
        $input = FileReader::getFileData('input.txt');

        $input = FileReader::makeTransactionArray($input);

        $output = DataValidation::dataVerification($input, $this->couriersDetails, $this->inputDataStructure);

        $output = DataValidation::addShipmentPrices($output, $this->couriersDetails);

        $output = Calculations::matchLowestProviderPrice($output, $this->couriersDetails);

        $output = Calculations::freeOncePerMonth($output, $this->couriersDetails);

        $output = Calculations::limitsDiscounts($output);

        $output = Formatting::formatShipmentPrice($output);

        $output = Formatting::formatShipmentDiscount($output);

        self::writeToStdout($output);
    }

    /**
     * This method writes the $output to stdout.
     *
     * @param $output The array of transactions with calculated discounts.
     *
     * @return void
     */
    public static function writeToStdout(array $output): void
    {
        foreach ($output as &$transaction) {
            $transaction = implode(' ', $transaction);
        }

        $output = implode("\r\n", $output);

        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout, $output);
        fclose($stdout);
    }
}
