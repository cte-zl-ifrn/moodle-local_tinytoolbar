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
 * Library functions for tool_tinycustomizer.
 *
 * @package    tool_tinycustomizer
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Hook: editor_tiny_get_config_data
 *
 * Called by Moodle's TinyMCE integration layer to collect configuration
 * overrides from installed plugins. Returns an array that will be merged
 * into the TinyMCE init options.
 *
 * @return array TinyMCE configuration options to merge.
 */
function tool_tinycustomizer_editor_tiny_get_config_data(): array {
    return \tool_tinycustomizer\toolbar_config::tiny_get_config_data();
}
