Feature: Locale
  In order to gain access to the management area
  As an admin user
  I need to be able to login and logout

  @javascript
  Scenario: Change locale
    Given I am on "/"
    Then I should see "ru"
    And I should see "Добро пожаловать"
    When I select "en" from "locale_select"
    Then I should see "en"
    And I should see "Welcome to"
    And print last response

