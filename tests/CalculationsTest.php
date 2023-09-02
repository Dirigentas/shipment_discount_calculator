<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Aras\VintedShipmentDiscount\Calculations;

/**
 * Test case for the Calculations class
 */
final class CalculationsTest extends TestCase
{
    /**
     * Test the numberFormat method of the Calculations class
     */
    public function testNumberFormat(): void
    {
        $result = Calculations::numberFormat(0);
        $this->assertEquals('-', $result);

        $result = Calculations::numberFormat(1);
        $this->assertEquals(1.00, $result);
    }

    /**
     * Test the sPackageDiscount method of the Calculations class
     */
    public function testSPackageDiscount(): void
    {
        $result = Calculations::sPackageDiscount([
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
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR'
        ], [
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
        ]);
        $this->assertEquals([
            '2015-02-01 S MR 1.50 0.50',
            '2015-02-02 S MR 1.50 0.50',
            '2015-02-03 L LP 6.90 -',
            '2015-02-05 S LP 1.50 -',
            '2015-02-06 S MR 1.50 0.50',
            '2015-02-06 L LP 6.90 -',
            '2015-02-07 L MR 4.00 -',
            '2015-02-08 M MR 3.00 -',
            '2015-02-09 L LP 6.90 -',
            '2015-02-10 L LP 6.90 -',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-11 L LP 6.90 -',
            '2015-02-12 M MR 3.00 -',
            '2015-02-13 M LP 4.90 -',
            '2015-02-15 S MR 1.50 0.50',
            '2015-02-17 L LP 6.90 -',
            '2015-02-17 S MR 1.50 0.50',
            '2015-02-24 L LP 6.90 -',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.50'
        ], $result);
    }

    /**
     * Test the lPackageDiscount method of the Calculations class
     */
    public function testLPackageDiscount(): void
    {
        $result = Calculations::lPackageDiscount([
            '2015-02-01 S MR 1.50 0.50',
            '2015-02-02 S MR 1.50 0.50',
            '2015-02-03 L LP 6.90 -',
            '2015-02-05 S LP 1.50 -',
            '2015-02-06 S MR 1.50 0.50',
            '2015-02-06 L LP 6.90 -',
            '2015-02-07 L MR 4.00 -',
            '2015-02-08 M MR 3.00 -',
            '2015-02-09 L LP 6.90 -',
            '2015-02-10 L LP 6.90 -',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-11 L LP 6.90 -',
            '2015-02-12 M MR 3.00 -',
            '2015-02-13 M LP 4.90 -',
            '2015-02-15 S MR 1.50 0.50',
            '2015-02-17 L LP 6.90 -',
            '2015-02-17 S MR 1.50 0.50',
            '2015-02-24 L LP 6.90 -',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.50'
        ], [
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
        ]);
        $this->assertEquals([
            '2015-02-01 S MR 1.50 0.50',
            '2015-02-02 S MR 1.50 0.50',
            '2015-02-03 L LP 6.90 -',
            '2015-02-05 S LP 1.50 -',
            '2015-02-06 S MR 1.50 0.50',
            '2015-02-06 L LP 6.90 -',
            '2015-02-07 L MR 4.00 -',
            '2015-02-08 M MR 3.00 -',
            '2015-02-09 L LP 0.00 6.90',
            '2015-02-10 L LP 6.90 -',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-11 L LP 6.90 -',
            '2015-02-12 M MR 3.00 -',
            '2015-02-13 M LP 4.90 -',
            '2015-02-15 S MR 1.50 0.50',
            '2015-02-17 L LP 6.90 -',
            '2015-02-17 S MR 1.50 0.50',
            '2015-02-24 L LP 6.90 -',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.50'
        ], $result);
    }

    /**
     * Test the limitsDiscounts method of the Calculations class
     */
    public function testLimitsDiscounts(): void
    {
        $result = Calculations::limitsDiscounts([
            '2015-02-01 S MR 1.50 0.50',
            '2015-02-02 S MR 1.50 0.50',
            '2015-02-03 L LP 6.90 -',
            '2015-02-05 S LP 1.50 -',
            '2015-02-06 S MR 1.50 0.50',
            '2015-02-06 L LP 6.90 -',
            '2015-02-07 L MR 4.00 -',
            '2015-02-08 M MR 3.00 -',
            '2015-02-09 L LP 0.00 6.90',
            '2015-02-10 L LP 6.90 -',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-11 L LP 6.90 -',
            '2015-02-12 M MR 3.00 -',
            '2015-02-13 M LP 4.90 -',
            '2015-02-15 S MR 1.50 0.50',
            '2015-02-17 L LP 6.90 -',
            '2015-02-17 S MR 1.50 0.50',
            '2015-02-24 L LP 6.90 -',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.50'
        ]);
        $this->assertEquals([
            '2015-02-01 S MR 1.50 0.50',
            '2015-02-02 S MR 1.50 0.50',
            '2015-02-03 L LP 6.90 -',
            '2015-02-05 S LP 1.50 -',
            '2015-02-06 S MR 1.50 0.50',
            '2015-02-06 L LP 6.90 -',
            '2015-02-07 L MR 4.00 -',
            '2015-02-08 M MR 3.00 -',
            '2015-02-09 L LP 0.00 6.90',
            '2015-02-10 L LP 6.90 -',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-10 S MR 1.50 0.50',
            '2015-02-11 L LP 6.90 -',
            '2015-02-12 M MR 3.00 -',
            '2015-02-13 M LP 4.90 -',
            '2015-02-15 S MR 1.50 0.50',
            '2015-02-17 L LP 6.90 -',
            '2015-02-17 S MR 1.90 0.10',
            '2015-02-24 L LP 6.90 -',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.50'
        ], $result);
    }
}

?>
