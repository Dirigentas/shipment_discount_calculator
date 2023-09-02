<?php

declare(strict_types=1);

namespace Aras\VintedShipmentDiscount;

use Aras\VintedShipmentDiscount\FileReader;
use Aras\VintedShipmentDiscount\DataValidation;
use Aras\VintedShipmentDiscount\Calculations;

final class Control
{
     /**
     * @var array $controlPanel An associative array containing the control panel settings for couriers and their corresponding package sizes and prices.
     */
    private $controlPanel = [
        'LP' => [
            'S' => 1.5,
            'M' => 4.9,
            'L' => 6.9
        ],
        'MR' => [
            'S' => 2,
            'M' => 3,
            'L' => 4
        ]
    ];

    /**
     * This method reads data from an input file, performs data verification and calculations, and writes the output to stdout.
     *
     * @return void
     */
    public function executeAndWriteToStdout(): void
    {
        $input = FileReader::getFileData('input.txt');
        
        $output = DataValidation::dataVerification($input, $this->controlPanel);
        
        $output = Calculations::matchLowestProviderPrice($output, $this->controlPanel);
        
        $output = Calculations::freeOncePerMonth($output, $this->controlPanel);
        
        $output = Calculations::limitsDiscounts($output);
        
        $output = implode("\r\n", $output);
        
        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout, $output);
        fclose($stdout);
    }
}

?>
