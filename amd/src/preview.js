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
 * AMD module: local_tinytoolbar/preview
 *
 * Manages the live-preview iframe shown alongside the visual toolbar builder.
 * It listens for configuration changes and reloads the iframe src accordingly.
 *
 * @module     local_tinytoolbar/preview
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Config from 'core/config';

const PREVIEW_SELECTOR = '#tinytoolbar-preview-frame';
const DEBOUNCE_MS = 600;

let debounceTimer = null;

/**
 * Update the preview iframe with new JSON configuration.
 *
 * @param {string} configJson JSON string with TinyMCE configuration.
 */
export const update = (configJson) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => applyPreview(configJson), DEBOUNCE_MS);
};

/**
 * Apply the configuration to the preview iframe.
 *
 * @param {string} configJson JSON configuration string.
 */
const applyPreview = (configJson) => {
    const frame = document.querySelector(PREVIEW_SELECTOR);
    if (!frame) {
        return;
    }

    let encoded = '';
    try {
        // Validate JSON before sending.
        JSON.parse(configJson);
        encoded = encodeURIComponent(configJson);
    } catch {
        return; // Do not update preview on invalid JSON.
    }

    const baseUrl = `${Config.wwwroot}/local/tinytoolbar/admin/preview.php`;
    frame.src = `${baseUrl}?config=${encoded}`;
};
