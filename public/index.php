<?php

/**
 * This file is the entry point for the ShipmentDiscount application.
 *
 * PHP version 8.2
 *
 * @category ShipmentDiscount
 * @package  ShipmentDiscount
 * @author   Aras
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     private repository
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// use Dirigentas\VintedShipmentDiscount\App;
use Dirigentas\VintedShipmentDiscount\Controllers\ShipmentDiscountController;
use Dirigentas\VintedShipmentDiscount\FileReader;

/**
 * Start the ShipmentDiscount application.
 */
// echo App::start();
// echo '<pre>';
(new ShipmentDiscountController)->index();
// FileReader::getFileData('input.txt')

?>
