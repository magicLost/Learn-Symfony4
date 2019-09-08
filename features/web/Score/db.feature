Feature: Authentication
  In order to gain access to the management area
  As an admin user
  I need to be able to login and logout

  @fixtures @javascript
  Scenario: Add score with ajax form
    Given I am on "/score"
    Then I should see "Best score table"