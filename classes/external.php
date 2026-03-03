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
 * External functions for tool_tinytoolbar.
 *
 * @package    tool_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_tinytoolbar;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

use external_api;
use external_function_parameters;
use external_value;
use external_single_structure;
use external_multiple_structure;
use context_system;

/**
 * External API class for tool_tinytoolbar.
 */
class external extends external_api {

    // -------------------------------------------------------------------------
    // get_config
    // -------------------------------------------------------------------------

    /**
     * Parameters for get_config.
     *
     * @return external_function_parameters
     */
    public static function get_config_parameters(): external_function_parameters {
        return new external_function_parameters([]);
    }

    /**
     * Returns the current TinyMCE toolbar configuration.
     *
     * @return array
     */
    public static function get_config(): array {
        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        $config = toolbar_config::get_active_config();
        $toolbarjson = get_config('tool_tinytoolbar', 'toolbar_json');
        $activepreset = get_config('tool_tinytoolbar', 'active_preset') ?: toolbar_config::PRESET_CLASSIC;
        $enabled = (bool) get_config('tool_tinytoolbar', 'enable_plugin');

        return [
            'enabled'       => $enabled,
            'active_preset' => (string) $activepreset,
            'toolbar_json'  => (string) $toolbarjson,
            'config_json'   => json_encode($config),
        ];
    }

    /**
     * Returns description of get_config result.
     *
     * @return external_single_structure
     */
    public static function get_config_returns(): external_single_structure {
        return new external_single_structure([
            'enabled'       => new external_value(PARAM_BOOL, 'Whether the plugin is enabled'),
            'active_preset' => new external_value(PARAM_ALPHANUMEXT, 'Active preset name'),
            'toolbar_json'  => new external_value(PARAM_RAW, 'Raw toolbar JSON'),
            'config_json'   => new external_value(PARAM_RAW, 'Resolved config JSON'),
        ]);
    }

    // -------------------------------------------------------------------------
    // save_config
    // -------------------------------------------------------------------------

    /**
     * Parameters for save_config.
     *
     * @return external_function_parameters
     */
    public static function save_config_parameters(): external_function_parameters {
        return new external_function_parameters([
            'enabled'       => new external_value(PARAM_BOOL, 'Enable or disable the plugin'),
            'active_preset' => new external_value(PARAM_ALPHANUMEXT, 'Preset name', VALUE_DEFAULT, 'classic'),
            'toolbar_json'  => new external_value(PARAM_RAW, 'Custom toolbar JSON', VALUE_DEFAULT, ''),
        ]);
    }

    /**
     * Saves the TinyMCE toolbar configuration.
     *
     * @param  bool   $enabled       Whether to enable the plugin.
     * @param  string $activepreset  Preset name.
     * @param  string $toolbarjson   Custom JSON (used when preset is "custom").
     * @return array  Result with success status.
     */
    public static function save_config(bool $enabled, string $activepreset = 'classic', string $toolbarjson = ''): array {
        $params = self::validate_parameters(self::save_config_parameters(), [
            'enabled'       => $enabled,
            'active_preset' => $activepreset,
            'toolbar_json'  => $toolbarjson,
        ]);

        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        // Validate preset name.
        if (!in_array($params['active_preset'], toolbar_config::get_preset_names())) {
            return ['success' => false, 'message' => get_string('error:invalidpreset', 'tool_tinytoolbar')];
        }

        // Validate custom JSON when needed.
        if ($params['active_preset'] === toolbar_config::PRESET_CUSTOM && !empty($params['toolbar_json'])) {
            if (!toolbar_config::validate_json($params['toolbar_json'])) {
                return ['success' => false, 'message' => get_string('invalidjson', 'tool_tinytoolbar')];
            }
        }

        set_config('enable_plugin', (int) $params['enabled'], 'tool_tinytoolbar');
        set_config('active_preset', $params['active_preset'], 'tool_tinytoolbar');
        set_config('toolbar_json', $params['toolbar_json'], 'tool_tinytoolbar');

        return ['success' => true, 'message' => get_string('configsaved', 'tool_tinytoolbar')];
    }

    /**
     * Returns description of save_config result.
     *
     * @return external_single_structure
     */
    public static function save_config_returns(): external_single_structure {
        return new external_single_structure([
            'success' => new external_value(PARAM_BOOL, 'Whether save was successful'),
            'message' => new external_value(PARAM_TEXT, 'Status message'),
        ]);
    }

    // -------------------------------------------------------------------------
    // get_presets
    // -------------------------------------------------------------------------

    /**
     * Parameters for get_presets.
     *
     * @return external_function_parameters
     */
    public static function get_presets_parameters(): external_function_parameters {
        return new external_function_parameters([]);
    }

    /**
     * Returns all available toolbar presets.
     *
     * @return array
     */
    public static function get_presets(): array {
        $context = context_system::instance();
        self::validate_context($context);
        require_capability('moodle/site:config', $context);

        $presets = toolbar_config::get_presets();
        $result = [];
        foreach ($presets as $name => $json) {
            $result[] = [
                'name'  => $name,
                'label' => get_string('preset_' . $name, 'tool_tinytoolbar'),
                'json'  => $json,
            ];
        }
        // Add the "custom" entry without a JSON payload.
        $result[] = [
            'name'  => toolbar_config::PRESET_CUSTOM,
            'label' => get_string('preset_custom', 'tool_tinytoolbar'),
            'json'  => '',
        ];

        return $result;
    }

    /**
     * Returns description of get_presets result.
     *
     * @return external_multiple_structure
     */
    public static function get_presets_returns(): external_multiple_structure {
        return new external_multiple_structure(
            new external_single_structure([
                'name'  => new external_value(PARAM_ALPHANUMEXT, 'Preset identifier'),
                'label' => new external_value(PARAM_TEXT, 'Human-readable label'),
                'json'  => new external_value(PARAM_RAW, 'Toolbar JSON configuration'),
            ])
        );
    }
}
