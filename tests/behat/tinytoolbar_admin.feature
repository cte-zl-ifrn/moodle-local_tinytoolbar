@local @local_tinytoolbar
Feature: Administer TinyMCE toolbar configuration
  In order to customise the TinyMCE editor toolbar
  As an administrator
  I need to be able to select presets and save custom JSON configuration

  Background:
    Given I log in as "admin"

  @javascript
  Scenario: Administrator can access the toolbar configurator settings page
    When I navigate to "Plugins > Local plugins > Tiny Toolbar Configurator" in site administration
    Then I should see "Toolbar Settings"

  @javascript
  Scenario: Administrator can enable the plugin
    Given I navigate to "Plugins > Local plugins > Tiny Toolbar Configurator" in site administration
    When I set the field "Enable Tiny Toolbar Configurator" to "1"
    And I press "Save changes"
    Then I should see "Changes saved"

  @javascript
  Scenario: Administrator can select a preset
    Given I navigate to "Plugins > Local plugins > Tiny Toolbar Configurator" in site administration
    When I set the field "Active preset" to "Minimal"
    And I press "Save changes"
    Then I should see "Changes saved"

  @javascript
  Scenario: Administrator can access the visual configurator page
    When I navigate to "/local/tinytoolbar/admin/config_form.php"
    Then I should see "Configure Toolbar"
    And I should see "Save changes"
    And I should see "Reset to default"
