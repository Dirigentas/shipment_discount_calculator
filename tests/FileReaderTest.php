<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aras\VintedShipmentDiscount\FileReader;

/**
 * Test case for the FileReader class
 */
final class FileReaderTest extends TestCase
{
    /**
     * Test the getFileData method of the FileReader class
     */
    public function testGetFileData(): void
    {
        $result = FileReader::getFileData('input.txt');
        $this->assertEquals([
            '2015-02-01 S MR',
            '2015-02-02 S MR',
            '2015-02-03 L LP',
            '2015-02-05 S LP',
            '2015-02-06 S MR',
            '2015-02-06 L LP',
            '2015-02-07 L MR',
            '2015-02-08 M MR',
            '2015-02-09 L LP',
            '2015-02-10 L LP',
            '2015-02-10 S MR',
            '2015-02-10 S MR',
            '2015-02-11 L LP',
            '2015-02-12 M MR',
            '2015-02-13 M LP',
            '2015-02-15 S MR',
            '2015-02-17 L LP',
            '2015-02-17 S MR',
            '2015-02-24 L LP',
            '2015-02-29 CUSPS',
            '2015-03-01 S MR'
        ], $result);
    }
}

?>
