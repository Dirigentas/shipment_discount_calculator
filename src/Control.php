<?php

/**
 * File purpose is to make adjustments to couriers and call all required methods.
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
      * @var array $couriers An associative array containing the settings for couriers.
      */
    private $couriers = [
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
     * This method executes all needed classes.
     *
     * @return void
     */
    public function executeAllClasses(): void
    {
        $input = FileReader::getFileData('input.txt');

        $output = DataValidation::dataVerification($input, $this->couriers);

        $output = Calculations::matchLowestProviderPrice($output, $this->couriers);

        $output = Calculations::freeOncePerMonth($output, $this->couriers);

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
        $output = implode("\r\n", $output);

        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout, $output);
        fclose($stdout);
    }
}
