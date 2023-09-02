<?php

declare(strict_types=1);

namespace Aras\VintedShipmentDiscount;

use Aras\VintedShipmentDiscount\DataValidation;

class FileReader
{
    /**
     * Reads data from a file, processes it and puts output to STDOUT.
     *
     * @param string $fileName The name of the file to read data from.
     *
     * @return void
     */
    public static function getFileData(string $fileName): void
    {    
        $input = explode("\r\n", file_get_contents('./public/' . $fileName));

        $output = implode("\r\n", DataValidation::dataVerification($input));
    
        $stdout = fopen('php://stdout', 'w');

        fwrite($stdout, $output);

        fclose($stdout);
    }
}

?>
