Feature: Authentication
  In order to gain access to the management area
  As an admin user
  I need to be able to login and logout

 @javascript
  Scenario: Add score with ajax form
    Given I am on "/score"
    When I press "show_add_score_form"
    And I fill in "score_form_name" with "Miley"
    And I fill in "score_form_real_name" with "Miley Sirus"
    And I fill in "score_form_score" with "1300"
    And I press "Add user"
    And I wait for the modal to load
    Then I should see "Success"

  Scenario:
    Given the following products exists:
      | name | is published |
      | Foo  | yes          |
      | Foo1 | no           |
    Then the "Foo" row should have a check mark