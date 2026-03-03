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
 * Language strings for local_tinytoolbar (English).
 *
 * @package    local_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Tiny Toolbar Configurator';
$string['plugindesc'] = 'Configure the TinyMCE editor toolbar and menus via a visual administrative interface.';

// Settings.
$string['settings'] = 'Toolbar Settings';
$string['toolbar_json'] = 'Toolbar configuration (JSON)';
$string['toolbar_json_desc'] = 'Configure the TinyMCE toolbar using JSON format. Use presets or build your own configuration.';
$string['active_preset'] = 'Active preset';
$string['active_preset_desc'] = 'Select a pre-configured toolbar preset or choose "Custom" to use your own JSON configuration.';
$string['enable_plugin'] = 'Enable Tiny Toolbar Configurator';
$string['enable_plugin_desc'] = 'When enabled, this plugin will override the default TinyMCE toolbar configuration.';

// Presets.
$string['preset_minimal'] = 'Minimal';
$string['preset_classic'] = 'Boost Classic';
$string['preset_full'] = 'Full';
$string['preset_accessibility'] = 'Accessibility';
$string['preset_custom'] = 'Custom';

// Admin interface.
$string['configuretoolbar'] = 'Configure Toolbar';
$string['preview'] = 'Preview';
$string['savechanges'] = 'Save changes';
$string['resettodefault'] = 'Reset to default';
$string['previewlive'] = 'Live preview';
$string['draganddrop'] = 'Drag and drop toolbar items';
$string['availablebuttons'] = 'Available buttons';
$string['toolbarrows'] = 'Toolbar rows';
$string['addrow'] = 'Add row';
$string['removerow'] = 'Remove row';
$string['separator'] = 'Separator';
$string['configsaved'] = 'Toolbar configuration saved successfully.';
$string['configerror'] = 'Error saving toolbar configuration.';
$string['invalidjson'] = 'Invalid JSON configuration.';
$string['presetapplied'] = 'Preset applied: {$a}';
$string['currentconfig'] = 'Current configuration';
$string['jsoneditor'] = 'JSON editor';
$string['visualeditor'] = 'Visual editor';
$string['toggleeditor'] = 'Toggle editor mode';

// Capabilities.
$string['tinytoolbar:manage'] = 'Manage Tiny Toolbar configuration';

// Privacy.
$string['privacy:metadata'] = 'The Tiny Toolbar Configurator plugin does not store any personal data.';

// Errors.
$string['error:invalidpreset'] = 'Invalid preset name.';
$string['error:savefailed'] = 'Failed to save configuration. Please try again.';
$string['error:permissiondenied'] = 'You do not have permission to manage the toolbar configuration.';
