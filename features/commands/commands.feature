Feature: Check best score page
  In order to check shown score result of users on page
  As an user
  I need to be able to

  Background:
    Given there is a file named "john"

  Scenario: List 2 files in a directory
    And there is a file named "hammond"
    When I run "dir"
    Then I should see "john" in the output
    And I should see "hammond" in the output

  Scenario: List 1 file and 1 directory
    And there is a dir named "ingen"
    When I run "dir"
    Then I should see "john" in the output
    And I should see "ingen" in the output