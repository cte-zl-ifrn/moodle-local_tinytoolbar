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
 * Toolbar configuration class for tool_tinycustomizer.
 *
 * @package    tool_tinycustomizer
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_tinycustomizer;

/**
 * Manages TinyMCE toolbar configuration and integrates with the editor via hooks.
 */
class toolbar_config {

    /** @var string Default minimal toolbar preset. */
    const PRESET_MINIMAL = 'minimal';

    /** @var string Default Boost Classic toolbar preset. */
    const PRESET_CLASSIC = 'classic';

    /** @var string Full featured toolbar preset. */
    const PRESET_FULL = 'full';

    /** @var string Accessibility optimised toolbar preset. */
    const PRESET_ACCESSIBILITY = 'accessibility';

    /** @var string Custom toolbar preset (user-defined JSON). */
    const PRESET_CUSTOM = 'custom';

    /**
     * Returns the list of built-in toolbar presets.
     *
     * @return array Associative array of preset name => toolbar JSON string.
     */
    public static function get_presets(): array {
        return [
            self::PRESET_MINIMAL => json_encode([
                'toolbar' => 'undo redo | bold italic',
                'menubar' => false,
            ]),
            self::PRESET_CLASSIC => json_encode([
                'toolbar' => 'formatselect | bold italic underline | alignleft aligncenter alignright alignjustify'
                    . ' | bullist numlist outdent indent | link unlink | removeformat',
                'menubar' => 'file edit view insert format tools table help',
            ]),
            self::PRESET_FULL => json_encode([
                'toolbar' => 'undo redo | formatselect fontselect fontsizeselect'
                    . ' | bold italic underline strikethrough subscript superscript'
                    . ' | alignleft aligncenter alignright alignjustify'
                    . ' | bullist numlist outdent indent'
                    . ' | link unlink image media table'
                    . ' | forecolor backcolor | emoticons charmap'
                    . ' | code fullscreen preview | removeformat',
                'menubar' => 'file edit view insert format tools table help',
                'plugins' => 'link image media table lists charmap emoticons code fullscreen preview',
            ]),
            self::PRESET_ACCESSIBILITY => json_encode([
                'toolbar' => 'undo redo | bold italic underline'
                    . ' | alignleft aligncenter alignright'
                    . ' | bullist numlist'
                    . ' | link unlink | removeformat | help',
                'menubar' => 'edit view insert format help',
                'a11y_advanced_options' => true,
            ]),
        ];
    }

    /**
     * Returns the currently active toolbar configuration as an array.
     *
     * @return array TinyMCE configuration options array.
     */
    public static function get_active_config(): array {
        $enabled = get_config('tool_tinycustomizer', 'enable_plugin');
        if (empty($enabled)) {
            return [];
        }

        $preset = get_config('tool_tinycustomizer', 'active_preset');
        $presets = self::get_presets();

        if ($preset === self::PRESET_CUSTOM || !isset($presets[$preset])) {
            $toolbarjson = get_config('tool_tinycustomizer', 'toolbar_json');
            if (empty($toolbarjson)) {
                return [];
            }
            $config = json_decode($toolbarjson, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }
            return $config;
        }

        $config = json_decode($presets[$preset], true);
        return is_array($config) ? $config : [];
    }

    /**
     * Hook callback: tiny_get_config_data.
     *
     * Called by the TinyMCE editor subsystem in Moodle 4.5+ to gather configuration
     * from installed plugins.  Returns toolbar/menu overrides when the plugin is active.
     *
     * @return array TinyMCE configuration data to merge.
     */
    public static function tiny_get_config_data(): array {
        return self::get_active_config();
    }

    /**
     * Validates a JSON toolbar configuration string.
     *
     * @param  string $json JSON string to validate.
     * @return bool   True if valid, false otherwise.
     */
    public static function validate_json(string $json): bool {
        if (empty($json)) {
            return false;
        }
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        return is_array($data);
    }

    /**
     * Returns all valid preset names.
     *
     * @return string[]
     */
    public static function get_preset_names(): array {
        return [
            self::PRESET_MINIMAL,
            self::PRESET_CLASSIC,
            self::PRESET_FULL,
            self::PRESET_ACCESSIBILITY,
            self::PRESET_CUSTOM,
        ];
    }
}
