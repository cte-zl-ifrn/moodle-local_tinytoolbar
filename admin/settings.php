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
 * Admin settings page for tool_tinycustomizer.
 *
 * @package    tool_tinycustomizer
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'tool_tinycustomizer',
        new lang_string('pluginname', 'tool_tinycustomizer')
    );

    $ADMIN->add('tools', $settings);

    // Enable/disable toggle.
    $settings->add(new admin_setting_configcheckbox(
        'tool_tinycustomizer/enable_plugin',
        new lang_string('enable_plugin', 'tool_tinycustomizer'),
        new lang_string('enable_plugin_desc', 'tool_tinycustomizer'),
        0
    ));

    // Active preset selector.
    $presetoptions = [
        'minimal'       => new lang_string('preset_minimal', 'tool_tinycustomizer'),
        'classic'       => new lang_string('preset_classic', 'tool_tinycustomizer'),
        'full'          => new lang_string('preset_full', 'tool_tinycustomizer'),
        'accessibility' => new lang_string('preset_accessibility', 'tool_tinycustomizer'),
        'custom'        => new lang_string('preset_custom', 'tool_tinycustomizer'),
    ];

    $settings->add(new admin_setting_configselect(
        'tool_tinycustomizer/active_preset',
        new lang_string('active_preset', 'tool_tinycustomizer'),
        new lang_string('active_preset_desc', 'tool_tinycustomizer'),
        'classic',
        $presetoptions
    ));

    // Custom JSON textarea.
    $settings->add(new admin_setting_configtextarea(
        'tool_tinycustomizer/toolbar_json',
        new lang_string('toolbar_json', 'tool_tinycustomizer'),
        new lang_string('toolbar_json_desc', 'tool_tinycustomizer'),
        ''
    ));

    // Link to the full visual configurator.
    $configurl = new moodle_url('/admin/tool/tinycustomizer/admin/config_form.php');
    $settings->add(new admin_setting_heading(
        'tool_tinycustomizer/visualconfig_heading',
        new lang_string('configuretoolbar', 'tool_tinycustomizer'),
        html_writer::link($configurl, new lang_string('configuretoolbar', 'tool_tinycustomizer'),
            ['class' => 'btn btn-primary'])
    ));
}
