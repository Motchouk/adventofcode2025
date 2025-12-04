Feature:
    In order to verify the logic behind my algorithms for day 4 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day4/1/day4test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""

    Scenario: Check part2
        When I request "/day4/2/day4test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""
