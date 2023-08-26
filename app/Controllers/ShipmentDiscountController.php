<?php

declare(strict_types=1);

namespace ShipmentDiscount\Controllers;

use ShipmentDiscount\FileReader;
use ShipmentDiscount\App;

class ShipmentDiscountController
{
    /** 
     * Atvaizduojami visi projekte public/files direktorijoje esantys failų pavadinimai
     * @return string view metodas
     */
    public function index(): string
    {
        $fileNames = FileReader::getFilesNames();

        return App::view('output', $fileNames);
    }
}

?>