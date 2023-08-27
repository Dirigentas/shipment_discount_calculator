<?php

declare(strict_types=1);

namespace ShipmentDiscount\Controllers;

use ShipmentDiscount\FileReader;
use ShipmentDiscount\App;

class ShipmentDiscountController
{
    /** 
     * Redirects to FileReader class to get data from 'input.txt' and returns view file
     * @return string view method, from view directory, file named 'output'
     */
    public function index(): string
    {
        $data = FileReader::getFileData('input.txt');

        return App::view('output', $data);
    }
}

?>