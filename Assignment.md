# Backend Homework Assignment

Requirements
----------------------------

* We recommend picking your favorite programming language. No constraints here. We want you to show us what you're able to do with the tools you already know well.
* Using additional libraries is prohibited. That constraint is not applied for unit tests and build.
* There should be an easy way to start the solution and tests. (in Ruby case, it could be something like: "rake run input.txt", "rake test")
* A short documentation of design decisions and assumptions can be provided in the code itself.
* Make sure your input data is loaded from a file (default name 'input.txt' is assumed)
* Make sure your solution outputs data to the screen (STDOUT) in a format described below
* Your design should be flexible enough to allow adding new rules and modifying existing ones easily

Problem
----------------------------
Naturally, when something is purchased, it has to be shipped and we provide various shipping options to its members across the globe. In France, it is allowed to ship via either 'Mondial Relay' (MR in short) or 'La Poste' (LP). While 'La Poste' provides usual courier delivery services, 'Mondial Relay' allows you to drop and pick up a shipment at a so-called drop-off point, thus being less convenient, but cheaper for larger packages.

Each item, depending on its size gets an appropriate package size assigned to it:

  * S - Small, a popular option to ship jewelry
  * M - Medium - clothes and similar items
  * L - Large - mostly shoes

Shipping price depends on package size and a provider:

| Provider     | Package Size | Price  |
|--------------|--------------|--------|
| LP           | S            | 1.50 € |
| LP           | M            | 4.90 € |
| LP           | L            | 6.90 € |
| MR           | S            | 2 €    |
| MR           | M            | 3 €    |
| MR           | L            | 4 €    |

Usually, the shipping price is covered by the buyer, but sometimes, in order to promote one or another provider, we cover part of the shipping price.

**Your task is to create a shipment discount calculation module.**

First, you have to implement such rules:
  * All S shipments should always match the lowest S package price among the providers.
  * The third L shipment via LP should be free, but only once a calendar month.
  * Accumulated discounts cannot exceed 10 € in a calendar month. If there are not enough funds to fully
  cover a discount this calendar month, it should be covered partially.

**Your design should be flexible enough to allow adding new rules and modifying existing ones easily.**

Member's transactions are listed in a file 'input.txt', each line containing: date (without hours, in ISO format), package size code, and carrier code, separated with whitespace:
```
2015-02-01 S MR
2015-02-02 S MR
2015-02-03 L LP
2015-02-05 S LP
2015-02-06 S MR
2015-02-06 L LP
2015-02-07 L MR
2015-02-08 M MR
2015-02-09 L LP
2015-02-10 L LP
2015-02-10 S MR
2015-02-10 S MR
2015-02-11 L LP
2015-02-12 M MR
2015-02-13 M LP
2015-02-15 S MR
2015-02-17 L LP
2015-02-17 S MR
2015-02-24 L LP
2015-02-29 CUSPS
2015-03-01 S MR
```
Your program should output transactions and append reduced shipment price and a shipment discount (or '-' if there is none). The program should append 'Ignored' word if the line format is wrong or carrier/sizes are unrecognized.
```
2015-02-01 S MR 1.50 0.50
2015-02-02 S MR 1.50 0.50
2015-02-03 L LP 6.90 -
2015-02-05 S LP 1.50 -
2015-02-06 S MR 1.50 0.50
2015-02-06 L LP 6.90 -
2015-02-07 L MR 4.00 -
2015-02-08 M MR 3.00 -
2015-02-09 L LP 0.00 6.90
2015-02-10 L LP 6.90 -
2015-02-10 S MR 1.50 0.50
2015-02-10 S MR 1.50 0.50
2015-02-11 L LP 6.90 -
2015-02-12 M MR 3.00 -
2015-02-13 M LP 4.90 -
2015-02-15 S MR 1.50 0.50
2015-02-17 L LP 6.90 -
2015-02-17 S MR 1.90 0.10
2015-02-24 L LP 6.90 -
2015-02-29 CUSPS Ignored
2015-03-01 S MR 1.50 0.50
```

Evaluation Criteria
----------------------------
* Your solution will be evaluated based on how well all requirements are implemented.
