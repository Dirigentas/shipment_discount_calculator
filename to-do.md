# Philosophy

-   write clean and simple code
-   write clean and simple code
-   easy to maintain, laikytis PSR

# Requirements

-   PHP
-   no libraries
-   easy to start (instructions in README file)
-   short documentation of design decisions and assumptions provided in the code itself
-   Make sure your input data is loaded from a file (default name 'input.txt' is assumed)
-   Make sure your solution outputs data to the screen (STDOUT) in a format described below
-   Your design should be flexible enough to allow adding new rules and modifying existing ones easily

# Evaluation Criteria

-   Based on how well all requirements are implemented

# Problem

-   All S shipments should always match the lowest S package price among the providers.
-   The third L shipment via LP should be free, but only once a calendar month.
-   Accumulated discounts cannot exceed 10 € in a calendar month. If there are not enough funds to fully cover a discount this calendar month, it should be covered partially.
-   Your design should be flexible enough to allow adding new rules and modifying existing ones easily.
-   Your program should output transactions and append reduced shipment price and a shipment discount (or '-' if there is none). The program should append 'Ignored' word if the line format is wrong or carrier/sizes are unrecognized.
