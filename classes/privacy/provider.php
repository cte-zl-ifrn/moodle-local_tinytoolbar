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
 * Privacy API implementation for tool_tinytoolbar.
 *
 * @package    tool_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_tinytoolbar\privacy;

use core_privacy\local\metadata\collection;

/**
 * The tool_tinytoolbar plugin does not store any personal user data.
 */
class provider implements \core_privacy\local\metadata\provider {

    /**
     * Returns metadata about this plugin's privacy practices.
     *
     * @param  collection $collection The metadata collection to add items to.
     * @return collection             The updated collection.
     */
    public static function get_metadata(collection $collection): collection {
        // This plugin stores only site-wide configuration, never personal data.
        return $collection;
    }
}
