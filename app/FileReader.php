<?php

declare(strict_types=1);

namespace ShipmentDiscount;

use ShipmentDiscount\InputProcessing;

class FileReader
{
    /**
     * Get data from 'input.txt' file and then place data to array
     * @param string of the file name
     * @return array of transactions
     */
    public static function getFileData(string $fileName): array
    {
        $input = file_get_contents('./../public/' . $fileName);

        $input = explode("\n", $input);

        return InputProcessing::dataVerification($input);
    }
}

?>