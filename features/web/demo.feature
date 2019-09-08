Feature: Search box on user page
  In order to find user
  As an admin
  I need to be able to search for user

  #@javascript
  Scenario:
    Given I am on the homepage
    And I am logged in as an admim
    And I wait for the modal to load
    When I click on manager link
    When I click on users link
    Then I should see "Marquis"

