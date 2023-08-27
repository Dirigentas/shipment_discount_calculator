<?php

declare(strict_types=1);

// hand made autoloader
require __DIR__ . '/../autoloader/autoloader.php';

use ShipmentDiscount\App; 

// Starts the webpage
echo App::start();

?>