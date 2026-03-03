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
 * Admin settings page for local_tinytoolbar.
 *
 * @package    local_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_tinytoolbar',
        new lang_string('pluginname', 'local_tinytoolbar')
    );

    $ADMIN->add('localplugins', $settings);

    // Enable/disable toggle.
    $settings->add(new admin_setting_configcheckbox(
        'local_tinytoolbar/enable_plugin',
        new lang_string('enable_plugin', 'local_tinytoolbar'),
        new lang_string('enable_plugin_desc', 'local_tinytoolbar'),
        0
    ));

    // Active preset selector.
    $presetoptions = [
        'minimal'       => new lang_string('preset_minimal', 'local_tinytoolbar'),
        'classic'       => new lang_string('preset_classic', 'local_tinytoolbar'),
        'full'          => new lang_string('preset_full', 'local_tinytoolbar'),
        'accessibility' => new lang_string('preset_accessibility', 'local_tinytoolbar'),
        'custom'        => new lang_string('preset_custom', 'local_tinytoolbar'),
    ];

    $settings->add(new admin_setting_configselect(
        'local_tinytoolbar/active_preset',
        new lang_string('active_preset', 'local_tinytoolbar'),
        new lang_string('active_preset_desc', 'local_tinytoolbar'),
        'classic',
        $presetoptions
    ));

    // Custom JSON textarea.
    $settings->add(new admin_setting_configtextarea(
        'local_tinytoolbar/toolbar_json',
        new lang_string('toolbar_json', 'local_tinytoolbar'),
        new lang_string('toolbar_json_desc', 'local_tinytoolbar'),
        ''
    ));

    // Link to the full visual configurator.
    $configurl = new moodle_url('/local/tinytoolbar/admin/config_form.php');
    $settings->add(new admin_setting_heading(
        'local_tinytoolbar/visualconfig_heading',
        new lang_string('configuretoolbar', 'local_tinytoolbar'),
        html_writer::link($configurl, new lang_string('configuretoolbar', 'local_tinytoolbar'),
            ['class' => 'btn btn-primary'])
    ));
}
