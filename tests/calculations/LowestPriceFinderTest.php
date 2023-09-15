<?php

declare(strict_types=1);

namespace Aras\ShipmentDiscountTests;

use PHPUnit\Framework\TestCase;
use Aras\ShipmentDiscount\calculations\LowestPriceFinder;

/**
 * Test case for the LowestPriceFinder class
 */
final class LowestPriceFinderTest extends TestCase
{
    /**
     * Test the matchLowestProviderPrice method of the LowestPriceFinder class
     */
    public function testMatchLowestProviderPrice(): void
    {
        $result = LowestPriceFinder::matchLowestProviderPrice([
            ['transactionDate' => '2015-02-01', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-02', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-03', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-05', 'transactionSize' => 'S', 'transactionCourier' => 'LP', 'transactionPrice' => 1.5, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-06', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-06', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-07', 'transactionSize' => 'L', 'transactionCourier' => 'MR', 'transactionPrice' => 4, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-08', 'transactionSize' => 'M', 'transactionCourier' => 'MR', 'transactionPrice' => 3, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-09', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-10', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-10', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-10', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-11', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-12', 'transactionSize' => 'M', 'transactionCourier' => 'MR', 'transactionPrice' => 3, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-13', 'transactionSize' => 'M', 'transactionCourier' => 'LP', 'transactionPrice' => 4.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-15', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-17', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-17', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-24', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['2015-02-29', 'CUSPS', 'Ignored'],
            ['transactionDate' => '2015-03-01', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 2, 'transactionDiscount' => 0]
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
            ['transactionDate' => '2015-02-01', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-02', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-03', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-05', 'transactionSize' => 'S', 'transactionCourier' => 'LP', 'transactionPrice' => 1.5, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-06', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-06', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-07', 'transactionSize' => 'L', 'transactionCourier' => 'MR', 'transactionPrice' => 4, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-08', 'transactionSize' => 'M', 'transactionCourier' => 'MR', 'transactionPrice' => 3, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-09', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-10', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-10', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-10', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-11', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-12', 'transactionSize' => 'M', 'transactionCourier' => 'MR', 'transactionPrice' => 3, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-13', 'transactionSize' => 'M', 'transactionCourier' => 'LP', 'transactionPrice' => 4.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-15', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-17', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['transactionDate' => '2015-02-17', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5],
            ['transactionDate' => '2015-02-24', 'transactionSize' => 'L', 'transactionCourier' => 'LP', 'transactionPrice' => 6.9, 'transactionDiscount' => 0],
            ['2015-02-29', 'CUSPS', 'Ignored'],
            ['transactionDate' => '2015-03-01', 'transactionSize' => 'S', 'transactionCourier' => 'MR', 'transactionPrice' => 1.5, 'transactionDiscount' => 0.5]
        ], $result);
    }
}
