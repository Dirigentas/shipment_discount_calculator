<?php

/**
 * This file is the entry point for the ShipmentDiscount application.
 *
 * PHP version 8.2
 *
 * @author  Aras
 * @license http://opensource.org/licenses/MIT MIT License
 * @link    private repository
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Aras\ShipmentDiscount\Control;

/**
 * Starts the solution.
 */
(new Control())->executeAllClasses();
