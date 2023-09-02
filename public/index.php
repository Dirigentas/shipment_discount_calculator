<?php

/**
 * This file is the entry point for the ShipmentDiscount application.
 *
 * PHP version 8.2
 *
 * @author  Aras
 * @license http://opensource.org/licenses/MIT MIT License
 * @link     private repository
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Aras\VintedShipmentDiscount\FileReader;
use Aras\VintedShipmentDiscount\DataValidation;
use Aras\VintedShipmentDiscount\Calculations;

/**
 * Start the Shipment Discount Calculations.
 */

$input = FileReader::getFileData('input.txt');

$output = DataValidation::dataVerification($input);
        
$output = Calculations::sPackageDiscount($output[0], $output[1]);

$output = Calculations::lPackageDiscount($output[0], $output[1]);

$output = Calculations::limitsDiscounts($output);

$output = implode("\r\n", $output);

$stdout = fopen('php://stdout', 'w');
fwrite($stdout, $output);
fclose($stdout);

?>
