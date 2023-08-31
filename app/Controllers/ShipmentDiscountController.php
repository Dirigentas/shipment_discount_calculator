<?php

declare(strict_types=1);

namespace ShipmentDiscount\Controllers;

use ShipmentDiscount\FileReader;
use ShipmentDiscount\App;

class ShipmentDiscountController
{
    /**
     * Returns a view of the main page with data from the 'input.txt' file.
     *
     * @return string The rendered view of the main page with data from the 'input.txt' file. The data is read using the FileReader::getFileData() method and passed to the App::view() method to render the view.
     */
    public function index(): string
    {
        $data = FileReader::getFileData('input.txt');

        return App::view('main', $data);
    }
}

?>