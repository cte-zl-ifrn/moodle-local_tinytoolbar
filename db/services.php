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
 * Web services for local_tinytoolbar.
 *
 * @package    local_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'local_tinytoolbar_get_config' => [
        'classname'     => 'local_tinytoolbar\external',
        'methodname'    => 'get_config',
        'description'   => 'Get the current TinyMCE toolbar configuration.',
        'type'          => 'read',
        'ajax'          => true,
        'capabilities'  => 'moodle/site:config',
    ],
    'local_tinytoolbar_save_config' => [
        'classname'     => 'local_tinytoolbar\external',
        'methodname'    => 'save_config',
        'description'   => 'Save the TinyMCE toolbar configuration.',
        'type'          => 'write',
        'ajax'          => true,
        'capabilities'  => 'moodle/site:config',
    ],
    'local_tinytoolbar_get_presets' => [
        'classname'     => 'local_tinytoolbar\external',
        'methodname'    => 'get_presets',
        'description'   => 'Get all available toolbar presets.',
        'type'          => 'read',
        'ajax'          => true,
        'capabilities'  => 'moodle/site:config',
    ],
];
