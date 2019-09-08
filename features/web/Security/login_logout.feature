Feature: Authentication
  In order to gain access to the management area
  As an admin user
  I need to be able to login and logout

 @javascript
  Scenario: Loggin with email
    Given there is an admin user "admin" with password "admin" ahd with email "admin@mail.ru"
    And I am on "/"
    When I follow "Login"
    And I fill in "username" with "admin@mail.ru"
    And I fill in "password" with "admin"
    And I press "_submit"
    Then I should be on "/"
    And I should see "Logout"

 @javascript
  Scenario: Loggin with name and redirect
    Given I am on "/manager/users"
    When I follow "Login"
    And I fill in "username" with "Sia"
    And I fill in "password" with "13"
    And I press "_submit"
    Then I should be on "/manager/users"
    And I should see "Logout"


  @javascript
  Scenario: Logout redirect
    Given I am logged in as an user
    And I am on "/manager/users"
    When I follow "Logout"
    Then I should be on "/manager/users"
    And I should see "Login"