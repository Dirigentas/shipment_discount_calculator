<?php

declare(strict_types=1);

namespace Dirigentas\VintedShipmentDiscount;

use Dirigentas\VintedShipmentDiscount\InputProcessing;

class FileReader
{
    /**
     * Reads data from 'input.txt' file and sends it to data verification class.
     * 
     * @param string $fileName The name of the file to read from. The file should be located in the './../public/' directory.
     * @return array An array containing the verified data from the file. The data is verified using the InputProcessing::dataVerification() method.
     */
    public static function getFileData(string $fileName)
    {
        $input = file_get_contents('./public/' . $fileName);
    
        $input = explode("\r\n", $input);

        return InputProcessing::dataVerification($input);
    }
}

?>