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
 * PHPUnit tests for tool_tinycustomizer\toolbar_config.
 *
 * @package    tool_tinycustomizer
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_tinycustomizer;

use advanced_testcase;

/**
 * Unit tests for toolbar_config class.
 *
 * @covers \tool_tinycustomizer\toolbar_config
 */
class toolbar_config_test extends advanced_testcase {

    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
    }

    /**
     * Test that get_presets returns an array with the expected keys.
     */
    public function test_get_presets_returns_expected_keys(): void {
        $presets = toolbar_config::get_presets();

        $this->assertIsArray($presets);
        $this->assertArrayHasKey(toolbar_config::PRESET_MINIMAL, $presets);
        $this->assertArrayHasKey(toolbar_config::PRESET_CLASSIC, $presets);
        $this->assertArrayHasKey(toolbar_config::PRESET_FULL, $presets);
        $this->assertArrayHasKey(toolbar_config::PRESET_ACCESSIBILITY, $presets);
    }

    /**
     * Test that all preset JSON values are valid.
     */
    public function test_preset_json_is_valid(): void {
        foreach (toolbar_config::get_presets() as $name => $json) {
            $decoded = json_decode($json, true);
            $this->assertEquals(JSON_ERROR_NONE, json_last_error(), "Preset '{$name}' has invalid JSON.");
            $this->assertIsArray($decoded);
        }
    }

    /**
     * Test validate_json with valid JSON.
     */
    public function test_validate_json_valid(): void {
        $json = json_encode(['toolbar' => 'bold italic', 'menubar' => true]);
        $this->assertTrue(toolbar_config::validate_json($json));
    }

    /**
     * Test validate_json with invalid JSON.
     */
    public function test_validate_json_invalid(): void {
        $this->assertFalse(toolbar_config::validate_json('{not valid json'));
    }

    /**
     * Test validate_json with empty string.
     */
    public function test_validate_json_empty(): void {
        $this->assertFalse(toolbar_config::validate_json(''));
    }

    /**
     * Test get_active_config returns empty array when plugin is disabled.
     */
    public function test_get_active_config_disabled(): void {
        set_config('enable_plugin', 0, 'tool_tinycustomizer');
        $config = toolbar_config::get_active_config();
        $this->assertIsArray($config);
        $this->assertEmpty($config);
    }

    /**
     * Test get_active_config returns config for a built-in preset when enabled.
     */
    public function test_get_active_config_preset(): void {
        set_config('enable_plugin', 1, 'tool_tinycustomizer');
        set_config('active_preset', toolbar_config::PRESET_MINIMAL, 'tool_tinycustomizer');

        $config = toolbar_config::get_active_config();
        $this->assertIsArray($config);
        $this->assertNotEmpty($config);
        $this->assertArrayHasKey('toolbar', $config);
    }

    /**
     * Test get_active_config returns custom JSON config when preset is "custom".
     */
    public function test_get_active_config_custom(): void {
        $customJson = json_encode(['toolbar' => 'bold italic', 'menubar' => false]);
        set_config('enable_plugin', 1, 'tool_tinycustomizer');
        set_config('active_preset', toolbar_config::PRESET_CUSTOM, 'tool_tinycustomizer');
        set_config('toolbar_json', $customJson, 'tool_tinycustomizer');

        $config = toolbar_config::get_active_config();
        $this->assertIsArray($config);
        $this->assertEquals('bold italic', $config['toolbar']);
    }

    /**
     * Test get_preset_names returns all expected preset names.
     */
    public function test_get_preset_names(): void {
        $names = toolbar_config::get_preset_names();
        $this->assertContains(toolbar_config::PRESET_MINIMAL, $names);
        $this->assertContains(toolbar_config::PRESET_CLASSIC, $names);
        $this->assertContains(toolbar_config::PRESET_FULL, $names);
        $this->assertContains(toolbar_config::PRESET_ACCESSIBILITY, $names);
        $this->assertContains(toolbar_config::PRESET_CUSTOM, $names);
    }

    /**
     * Test tiny_get_config_data returns same value as get_active_config.
     */
    public function test_tiny_get_config_data(): void {
        set_config('enable_plugin', 1, 'tool_tinycustomizer');
        set_config('active_preset', toolbar_config::PRESET_CLASSIC, 'tool_tinycustomizer');

        $expected = toolbar_config::get_active_config();
        $result   = toolbar_config::tiny_get_config_data();
        $this->assertEquals($expected, $result);
    }
}
