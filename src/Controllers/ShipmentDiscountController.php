<?php

declare(strict_types=1);

namespace Dirigentas\VintedShipmentDiscount\Controllers;

use Dirigentas\VintedShipmentDiscount\FileReader;
use Dirigentas\VintedShipmentDiscount\App;

class ShipmentDiscountController
{
    /**
     * Returns a view of the main page with data from the 'input.txt' file.
     *
     * @return string The rendered view of the main page with data from the 'input.txt' file. The data is read using the FileReader::getFileData() method and passed to the App::view() method to render the view.
     */
    public function index()
    {
        
        $data = FileReader::getFileData('input.txt');

        // $input = implode(' ', $data[0]);

        // echo $input;

        // $output = implode(' ', $data[1]);
        
    
        $stdout = fopen('php://stdout', 'w');
        // fwrite($stdout, "Hello world\n");
        fwrite($stdout, $data);
        // fwrite($stdout, $output);
        fclose($stdout);

        // return $data;
    }
}

?>