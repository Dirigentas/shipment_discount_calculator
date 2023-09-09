<?php

declare(strict_types=1);

namespace Aras\ShipmentDiscountTests;

use PHPUnit\Framework\TestCase;
use Aras\ShipmentDiscount\Calculations;

/**
 * Test case for the Calculations class
 */
final class CalculationsTest extends TestCase
{
    /**
     * Test the matchLowestProviderPrice method of the Calculations class
     */
    public function testMatchLowestProviderPrice(): void
    {
        $result = Calculations::matchLowestProviderPrice([
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
            '2015-02-01 S MR 1.5 0.5',
            '2015-02-02 S MR 1.5 0.5',
            '2015-02-03 L LP 6.9 0',
            '2015-02-05 S LP 1.5 0',
            '2015-02-06 S MR 1.5 0.5',
            '2015-02-06 L LP 6.9 0',
            '2015-02-07 L MR 4 0',
            '2015-02-08 M MR 3 0',
            '2015-02-09 L LP 6.9 0',
            '2015-02-10 L LP 6.9 0',
            '2015-02-10 S MR 1.5 0.5',
            '2015-02-10 S MR 1.5 0.5',
            '2015-02-11 L LP 6.9 0',
            '2015-02-12 M MR 3 0',
            '2015-02-13 M LP 4.9 0',
            '2015-02-15 S MR 1.5 0.5',
            '2015-02-17 L LP 6.9 0',
            '2015-02-17 S MR 1.5 0.5',
            '2015-02-24 L LP 6.9 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.5 0.5'
        ], $result);
    }

    /**
     * Test the freeOncePerMonth method of the Calculations class
     */
    public function testFreeOncePerMonth(): void
    {
        $result = Calculations::freeOncePerMonth([
            '2015-02-01 S MR 1.5 0.5',
            '2015-02-02 S MR 1.5 0.5',
            '2015-02-03 L LP 6.9 0',
            '2015-02-05 S LP 1.5 0',
            '2015-02-06 S MR 1.5 0.5',
            '2015-02-06 L LP 6.9 0',
            '2015-02-07 L MR 4 0',
            '2015-02-08 M MR 3 0',
            '2015-02-09 L LP 6.9 0',
            '2015-02-10 L LP 6.9 0',
            '2015-02-10 S MR 1.5 0.5',
            '2015-02-10 S MR 1.5 0.5',
            '2015-02-11 L LP 6.9 0',
            '2015-02-12 M MR 3 0',
            '2015-02-13 M LP 4.9 0',
            '2015-02-15 S MR 1.5 0.5',
            '2015-02-17 L LP 6.9 0',
            '2015-02-17 S MR 1.5 0.5',
            '2015-02-24 L LP 6.9 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.5 0.5'
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
            '2015-02-17 S MR 1.5 0.5',
            '2015-02-24 L LP 6.9 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.5 0.5'
        ], $result);
    }

    /**
     * Test the limitsDiscounts method of the Calculations class
     */
    public function testLimitsDiscounts(): void
    {
        $result = Calculations::limitsDiscounts([
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
            '2015-02-17 S MR 1.5 0.5',
            '2015-02-24 L LP 6.9 0',
            '2015-02-29 CUSPS Ignored',
            '2015-03-01 S MR 1.5 0.5'
        ]);
        $this->assertEquals([
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
        ], $result);
    }
}
