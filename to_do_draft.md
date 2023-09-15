# Backend Homework Assignment

Code Philosophy
We strive to write clean and simple code, covered with unit tests, and easy to maintain. We also put a high value on consistency and following language code style. We expect to see the same values conveyed in the problem solution. However, please note that the provided style guide is for Ruby. If the code is written in other language, we expect it to follow the style conventions of the chosen language.

# Requirements

We recommend picking your favorite programming language. No constraints here. We want you to show us what you're able to do with the tools you already know well.
Your solution should match the philosophy described above.
Using additional libraries is prohibited. That constraint is not applied for unit tests and build.
There should be an easy way to start the solution and tests. (in Ruby case, it could be something like: "rake run input.txt", "rake test")
A short documentation of design decisions and assumptions can be provided in the code itself.
Make sure your input data is loaded from a file (default name 'input.txt' is assumed)
Make sure your solution outputs data to the screen (STDOUT) in a format described below
Your design should be flexible enough to allow adding new rules and modifying existing ones easily
Problem

Each item, depending on its size gets an appropriate package size assigned to it:

S - Small, a popular option to ship jewelry
M - Medium - clothes and similar items
L - Large - mostly shoes
Shipping price depends on package size and a provider:

Provider Package Size Price
LP S 1.50 €
LP M 4.90 €
LP L 6.90 €
MR S 2 €
MR M 3 €
MR L 4 €
Usually, the shipping price is covered by the buyer, but sometimes, in order to promote one or another provider, we cover part of the shipping price.

Your task is to create a shipment discount calculation module.

First, you have to implement such rules:

All S shipments should always match the lowest S package price among the providers.
The third L shipment via LP should be free, but only once a calendar month.
Accumulated discounts cannot exceed 10 € in a calendar month. If there are not enough funds to fully cover a discount this calendar month, it should be covered partially.
Your design should be flexible enough to allow adding new rules and modifying existing ones easily.

Member's transactions are listed in a file 'input.txt', each line containing: date (without hours, in ISO format), package size code, and carrier code, separated with whitespace:

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
Your program should output transactions and append reduced shipment price and a shipment discount (or '-' if there is none). The program should append 'Ignored' word if the line format is wrong or carrier/sizes are unrecognized.

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
Evaluation Criteria
Your solution will be evaluated based on how well all requirements are implemented.

# E:

-   \+ naudoti composer, nes jis nera tik autoloader, composerio sitam projekte tau reiks kaip autoloaderio, package manager ir build irankio (scripts)
-   \+ STDOUT, išvesti duomenis į terminalo langą, ne į HTML, reikia keisti: nereiks routerio, view, uzteks echo (arba file_put..., arba fwrite i php://output), nereiks jokių views, css irgi nebeliks
-   \+ struktūra: įvesti vientisumo į struktūrą, app pasirinko laravel, o SRC yra nusistovėjusi praktika, app visai galiu panaikinti, autoload greiciausiai iskeliaus i siuksledeze, del composer. bet jei liktu, turetu keliau i pagrindini source kataloga
-   \+ įsirašyti php unit per composer, ir paskui parašyti test ir programos paleidimą per script, kad būtų easy
-   \+ php code sniffer, jis tau padetu laikytis PSR-2 ir PSR-12 kodo stiliaus standartu ir ištaisytų stiliaus klaidas
-   \+ O ir D principai

-   On Windows, the end-of-line symbol for text files is typically a carriage return followed by a line feed (CRLF), represented as \r\n. Git can change that, check git config file for that.

-   visad pasitikrinti galutinį kodą jau tą kurį siųsiu, nes gali būti ir daugiau tokių nesamonių, kaip .txt failo pakeitimas pačio git.

# Areas for Improvement (from company)

-   Code Architecture:

    -   \+ There's an evident mix between parsing data and applying business logic, which can make modifications and debugging challenging. Parsing shipments into structured objects within the FileReader would be a more efficient approach. (perduoti skaiciavimams arejus, o ne stringus)
    -   \+ The Calculations class appears to be a "god object", taking on multiple responsibilities. This makes the code prone to becoming complex and hard to maintain as more rules are added. Modularizing rules into separate objects can provide clarity and extensibility.

-   Code Cleanliness:

    -   \+ Direct access to list items without saving them into variables first can lead to potential confusion and errors.
    -   \+ The nested if statements can make the logic hard to follow. Flattening or breaking these down can enhance code readability.

-   \+ Naming Convention: Proper and descriptive variable naming is crucial for code maintainability. Names like controlPanel do not provide clarity about the variable's purpose or content.

-   Single Responsibility Principle:

    -   \+ The method _executeAndWriteToStdout_ combines both execution and writing logic. Splitting these responsibilities into separate methods or classes would make the code more manageable.
    -   \+ Rules being responsible for multiple tasks, such as calculating discounts and formatting the output, can lead to potential issues down the line.
    -   \+ The method _matchLowestProviderPrice_ combines both adding prices and calculating discounts.
