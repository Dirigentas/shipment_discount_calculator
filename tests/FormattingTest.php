<?php

declare(strict_types=1);

namespace Aras\ShipmentDiscountTests;

use PHPUnit\Framework\TestCase;
use Aras\ShipmentDiscount\Formatting;

/**
 * Test case for the Formatting class
 */
final class FormattingTest extends TestCase
{
    /**
     * Test the formatShipmentPrice method of the Formatting class
     */
    public function testFormatShipmentPrice(): void
    {
        $result = Formatting::formatShipmentPrice([
            '2015-02-01 S MR 1.5 0.5',
            '2015-02-02 S MR 1.5 0.5',
            '2015-02-03 L LP 6.9 0',
            '2015-02-05 S LP 1.5 0',
            '2015-02-06 S MR 1.5 0.5',
            '2015-02-06 L LP 6.9 0',
            '2015-02-07 L MR 4 0',
            '2015-02-08 M MR 3 0',
            '2015-02-09 L LP 0 6.9',
            '2015-02-10 L LP 6.9 0',
            '2015-02-10 S MR 1.5 0.5',
            '2015-02-10 S MR 1.5 0.5',
            '2015-02-11 L LP 6.9 0',
            '2015-02-12 M MR 3 0',
            '2015-02-13 M LP 4.9 0',
            '2015-02-15 S MR 1.5 0.5',
            '2015-02-17 L LP 6.9 0',
            '2015-02-17 S MR 1.9 0.1',
            '2015-02-24 L LP 6.9 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.5 0.5'
        ]);
        $this->assertEquals([
            '2015-02-01 S MR 1.50 0.5',
            '2015-02-02 S MR 1.50 0.5',
            '2015-02-03 L LP 6.90 0',
            '2015-02-05 S LP 1.50 0',
            '2015-02-06 S MR 1.50 0.5',
            '2015-02-06 L LP 6.90 0',
            '2015-02-07 L MR 4.00 0',
            '2015-02-08 M MR 3.00 0',
            '2015-02-09 L LP 0.00 6.9',
            '2015-02-10 L LP 6.90 0',
            '2015-02-10 S MR 1.50 0.5',
            '2015-02-10 S MR 1.50 0.5',
            '2015-02-11 L LP 6.90 0',
            '2015-02-12 M MR 3.00 0',
            '2015-02-13 M LP 4.90 0',
            '2015-02-15 S MR 1.50 0.5',
            '2015-02-17 L LP 6.90 0',
            '2015-02-17 S MR 1.90 0.1',
            '2015-02-24 L LP 6.90 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.5'
        ], $result);
    }

    /**
     * Test the formatShipmentDiscount method of the Formatting class
     */
    public function testFormatShipmentDiscount(): void
    {
        $result = Formatting::formatShipmentDiscount([
            '2015-02-01 S MR 1.50 0.5',
            '2015-02-02 S MR 1.50 0.5',
            '2015-02-03 L LP 6.90 0',
            '2015-02-05 S LP 1.50 0',
            '2015-02-06 S MR 1.50 0.5',
            '2015-02-06 L LP 6.90 0',
            '2015-02-07 L MR 4.00 0',
            '2015-02-08 M MR 3.00 0',
            '2015-02-09 L LP 0.00 6.9',
            '2015-02-10 L LP 6.90 0',
            '2015-02-10 S MR 1.50 0.5',
            '2015-02-10 S MR 1.50 0.5',
            '2015-02-11 L LP 6.90 0',
            '2015-02-12 M MR 3.00 0',
            '2015-02-13 M LP 4.90 0',
            '2015-02-15 S MR 1.50 0.5',
            '2015-02-17 L LP 6.90 0',
            '2015-02-17 S MR 1.90 0.1',
            '2015-02-24 L LP 6.90 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.50 0.5'
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
