Feature: Authentication
  In order to pass registration
  As an user
  I need to be able to register


@javascript
Scenario: Registration and redirect
    Given I am on "/manager/users"
    When I follow "Login"
    When I follow "Registration"
    And I fill in email field with "rick@gmail.com"
    And I fill in username field with "Rick"
    And I fill in password field with "13"
    And I fill in repeat password field with "13"
    And I fill in first name field with "Bianka"
    And I press registration button
    Then the url should match "/ru|en/register/check-email"
    And I should see text matching "(Welcome! Now let's do some magic...)|(Пользователь успешно создан.)"
  #ToDo check enable acount