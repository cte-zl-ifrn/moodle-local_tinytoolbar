<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin settings page for tool_tinytoolbar.
 *
 * @package    tool_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'tool_tinytoolbar',
        new lang_string('pluginname', 'tool_tinytoolbar')
    );

    $ADMIN->add('tools', $settings);

    // Enable/disable toggle.
    $settings->add(new admin_setting_configcheckbox(
        'tool_tinytoolbar/enable_plugin',
        new lang_string('enable_plugin', 'tool_tinytoolbar'),
        new lang_string('enable_plugin_desc', 'tool_tinytoolbar'),
        0
    ));

    // Active preset selector.
    $presetoptions = [
        'minimal'       => new lang_string('preset_minimal', 'tool_tinytoolbar'),
        'classic'       => new lang_string('preset_classic', 'tool_tinytoolbar'),
        'full'          => new lang_string('preset_full', 'tool_tinytoolbar'),
        'accessibility' => new lang_string('preset_accessibility', 'tool_tinytoolbar'),
        'custom'        => new lang_string('preset_custom', 'tool_tinytoolbar'),
    ];

    $settings->add(new admin_setting_configselect(
        'tool_tinytoolbar/active_preset',
        new lang_string('active_preset', 'tool_tinytoolbar'),
        new lang_string('active_preset_desc', 'tool_tinytoolbar'),
        'classic',
        $presetoptions
    ));

    // Custom JSON textarea.
    $settings->add(new admin_setting_configtextarea(
        'tool_tinytoolbar/toolbar_json',
        new lang_string('toolbar_json', 'tool_tinytoolbar'),
        new lang_string('toolbar_json_desc', 'tool_tinytoolbar'),
        ''
    ));

    // Link to the full visual configurator.
    $configurl = new moodle_url('/admin/tool/tinytoolbar/admin/config_form.php');
    $settings->add(new admin_setting_heading(
        'tool_tinytoolbar/visualconfig_heading',
        new lang_string('configuretoolbar', 'tool_tinytoolbar'),
        html_writer::link($configurl, new lang_string('configuretoolbar', 'tool_tinytoolbar'),
            ['class' => 'btn btn-primary'])
    ));
}
