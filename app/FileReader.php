<?php

declare(strict_types=1);

namespace ShipmentDiscount;

class FileReader
{
    /**
     * Get data from 'input.txt' file and then place data to array
     * @param string of the file name
     * @return array of transactions
     */
    public static function getFileData(string $fileName): array
    {
        $data = file_get_contents('./../public/' . $fileName);

        $data = explode("\n", $data);

        return $data;
    }
}

?>