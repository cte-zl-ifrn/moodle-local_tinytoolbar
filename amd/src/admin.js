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
 * AMD module: tool_tinycustomizer/admin
 *
 * Visual toolbar configurator – handles the drag-and-drop builder, preset
 * selection, live JSON validation and AJAX save on the admin config page.
 *
 * @module     tool_tinycustomizer/admin
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Ajax from 'core/ajax';
import Notification from 'core/notification';
import {get_string as getString} from 'core/str';
import * as Preview from './preview';

/** CSS selector constants */
const SELECTORS = {
    PRESET_SELECT:    '#id_active_preset',
    JSON_EDITOR:      '#id_toolbar_json',
    SAVE_BTN:         '#tinycustomizer-save',
    RESET_BTN:        '#tinycustomizer-reset',
    PREVIEW_FRAME:    '#tinycustomizer-preview-frame',
    TOOLBAR_BUILDER:  '#tinycustomizer-builder',
    AVAILABLE_ITEMS:  '#tinycustomizer-available',
    JSON_STATUS:      '#tinycustomizer-json-status',
    ENABLE_TOGGLE:    '#id_enable_plugin',
    TOGGLE_MODE_BTN:  '#tinycustomizer-toggle-mode',
    VISUAL_PANEL:     '#tinycustomizer-visual-panel',
    JSON_PANEL:       '#tinycustomizer-json-panel',
};

let presets = {};
let currentMode = 'json'; // 'json' | 'visual'

/**
 * Initialise the admin interface.  Called once by PHP via $PAGE->requires->js_call_amd.
 */
export const init = async() => {
    try {
        await loadPresets();
        bindEvents();
        validateJson();
    } catch (e) {
        Notification.exception(e);
    }
};

/**
 * Load all available presets via AJAX and cache them locally.
 */
const loadPresets = async() => {
    const result = await Ajax.call([{
        methodname: 'tool_tinycustomizer_get_presets',
        args: {},
    }])[0];

    result.forEach(preset => {
        presets[preset.name] = preset.json;
    });
};

/**
 * Attach DOM event listeners.
 */
const bindEvents = () => {
    const presetSelect  = document.querySelector(SELECTORS.PRESET_SELECT);
    const jsonEditor    = document.querySelector(SELECTORS.JSON_EDITOR);
    const saveBtn       = document.querySelector(SELECTORS.SAVE_BTN);
    const resetBtn      = document.querySelector(SELECTORS.RESET_BTN);
    const toggleModeBtn = document.querySelector(SELECTORS.TOGGLE_MODE_BTN);

    if (presetSelect) {
        presetSelect.addEventListener('change', onPresetChange);
    }

    if (jsonEditor) {
        jsonEditor.addEventListener('input', onJsonChange);
    }

    if (saveBtn) {
        saveBtn.addEventListener('click', onSave);
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', onReset);
    }

    if (toggleModeBtn) {
        toggleModeBtn.addEventListener('click', toggleEditorMode);
    }

    initDragAndDrop();
};

/**
 * Handle preset selection change – populate JSON editor with preset value.
 *
 * @param {Event} e Change event.
 */
const onPresetChange = (e) => {
    const selected = e.target.value;
    const jsonEditor = document.querySelector(SELECTORS.JSON_EDITOR);

    if (selected !== 'custom' && presets[selected]) {
        if (jsonEditor) {
            jsonEditor.value = JSON.stringify(JSON.parse(presets[selected]), null, 2);
        }
    } else if (selected === 'custom' && jsonEditor && !jsonEditor.value.trim()) {
        jsonEditor.value = JSON.stringify({toolbar: '', menubar: true}, null, 2);
    }

    validateJson();
    updatePreview();
};

/**
 * Validate the JSON editor content and show inline status.
 */
const onJsonChange = () => {
    validateJson();
    updatePreview();
};

/**
 * Validate JSON and update the status indicator element.
 *
 * @return {boolean} True when the JSON is valid.
 */
const validateJson = () => {
    const jsonEditor = document.querySelector(SELECTORS.JSON_EDITOR);
    const statusEl   = document.querySelector(SELECTORS.JSON_STATUS);

    if (!jsonEditor) {
        return true;
    }

    const value = jsonEditor.value.trim();
    if (!value) {
        setStatus(statusEl, '', '');
        return true;
    }

    try {
        JSON.parse(value);
        setStatus(statusEl, 'valid', '✔');
        return true;
    } catch {
        setStatus(statusEl, 'invalid', '✘');
        return false;
    }
};

/**
 * Set the JSON status indicator.
 *
 * @param {Element|null} el     Status element.
 * @param {string}       state  CSS modifier ('valid' | 'invalid' | '').
 * @param {string}       icon   Unicode icon to display.
 */
const setStatus = (el, state, icon) => {
    if (!el) {
        return;
    }
    el.className = `tinycustomizer-json-status ${state ? 'is-' + state : ''}`;
    el.textContent = icon;
};

/**
 * Save configuration via AJAX.
 *
 * @param {Event} e Click event.
 */
const onSave = async(e) => {
    e.preventDefault();

    if (!validateJson()) {
        const msg = await getString('invalidjson', 'tool_tinycustomizer');
        Notification.addNotification({message: msg, type: 'error'});
        return;
    }

    const presetSelect = document.querySelector(SELECTORS.PRESET_SELECT);
    const jsonEditor   = document.querySelector(SELECTORS.JSON_EDITOR);
    const enableToggle = document.querySelector(SELECTORS.ENABLE_TOGGLE);

    try {
        const result = await Ajax.call([{
            methodname: 'tool_tinycustomizer_save_config',
            args: {
                enabled:       enableToggle ? enableToggle.checked : false,
                active_preset: presetSelect ? presetSelect.value : 'classic',
                toolbar_json:  jsonEditor ? jsonEditor.value : '',
            },
        }])[0];

        const type = result.success ? 'success' : 'error';
        Notification.addNotification({message: result.message, type});
    } catch (err) {
        Notification.exception(err);
    }
};

/**
 * Reset form to default (Classic) preset.
 *
 * @param {Event} e Click event.
 */
const onReset = async(e) => {
    e.preventDefault();

    const presetSelect = document.querySelector(SELECTORS.PRESET_SELECT);
    const jsonEditor   = document.querySelector(SELECTORS.JSON_EDITOR);

    if (presetSelect) {
        presetSelect.value = 'classic';
    }
    if (jsonEditor && presets.classic) {
        jsonEditor.value = JSON.stringify(JSON.parse(presets.classic), null, 2);
    }

    validateJson();
    updatePreview();
};

/**
 * Toggle between JSON and Visual (drag-and-drop) editor modes.
 */
const toggleEditorMode = async() => {
    const visualPanel = document.querySelector(SELECTORS.VISUAL_PANEL);
    const jsonPanel   = document.querySelector(SELECTORS.JSON_PANEL);
    const btn         = document.querySelector(SELECTORS.TOGGLE_MODE_BTN);

    if (!visualPanel || !jsonPanel) {
        return;
    }

    currentMode = currentMode === 'json' ? 'visual' : 'json';

    if (currentMode === 'visual') {
        jsonPanel.classList.add('d-none');
        visualPanel.classList.remove('d-none');
        syncVisualFromJson();
        if (btn) {
            btn.textContent = await getString('jsoneditor', 'tool_tinycustomizer');
        }
    } else {
        visualPanel.classList.add('d-none');
        jsonPanel.classList.remove('d-none');
        syncJsonFromVisual();
        if (btn) {
            btn.textContent = await getString('visualeditor', 'tool_tinycustomizer');
        }
    }
};

/**
 * Trigger a live preview update in the embedded iframe.
 */
const updatePreview = () => {
    const jsonEditor = document.querySelector(SELECTORS.JSON_EDITOR);
    if (jsonEditor) {
        Preview.update(jsonEditor.value);
    }
};

// ---------------------------------------------------------------------------
// Drag-and-drop builder
// ---------------------------------------------------------------------------

/**
 * Initialise the drag-and-drop toolbar builder area.
 */
const initDragAndDrop = () => {
    const builder = document.querySelector(SELECTORS.TOOLBAR_BUILDER);
    const available = document.querySelector(SELECTORS.AVAILABLE_ITEMS);

    if (!builder || !available) {
        return;
    }

    enableDragSource(available);
    enableDropTarget(builder);
    enableDropTarget(available);
};

/**
 * Add drag event listeners to all draggable children of a container.
 *
 * @param {Element} container Parent element.
 */
const enableDragSource = (container) => {
    container.querySelectorAll('[draggable]').forEach(item => {
        item.addEventListener('dragstart', onDragStart);
        item.addEventListener('dragend', onDragEnd);
    });
};

/**
 * Add drop event listeners to a container.
 *
 * @param {Element} container Drop target element.
 */
const enableDropTarget = (container) => {
    container.addEventListener('dragover', onDragOver);
    container.addEventListener('drop', onDrop);
};

let draggedItem = null;

const onDragStart = (e) => {
    draggedItem = e.currentTarget;
    e.currentTarget.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', e.currentTarget.dataset.button || '');
};

const onDragEnd = (e) => {
    e.currentTarget.classList.remove('dragging');
    draggedItem = null;
};

const onDragOver = (e) => {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
};

const onDrop = (e) => {
    e.preventDefault();
    if (!draggedItem) {
        return;
    }
    const target = e.currentTarget;
    // Clone if dragging FROM available panel INTO builder.
    if (target.id === 'tinycustomizer-builder' && draggedItem.parentElement.id === 'tinycustomizer-available') {
        const clone = draggedItem.cloneNode(true);
        enableDragSource(clone.parentElement || target);
        target.appendChild(clone);
        clone.addEventListener('dragstart', onDragStart);
        clone.addEventListener('dragend', onDragEnd);
    } else if (target.contains(draggedItem)) {
        // Reorder within same container.
        const after = getDragAfterElement(target, e.clientY);
        if (after == null) {
            target.appendChild(draggedItem);
        } else {
            target.insertBefore(draggedItem, after);
        }
    }

    syncJsonFromVisual();
};

/**
 * Find the element after the cursor Y position for reordering.
 *
 * @param  {Element} container Drop target container.
 * @param  {number}  y         Mouse Y coordinate.
 * @return {Element|null}
 */
const getDragAfterElement = (container, y) => {
    const draggableElements = [...container.querySelectorAll('[draggable]:not(.dragging)')];
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
            return {offset, element: child};
        }
        return closest;
    }, {offset: Number.NEGATIVE_INFINITY}).element || null;
};

/**
 * Read visual builder state and update the JSON editor.
 */
const syncJsonFromVisual = () => {
    const builder    = document.querySelector(SELECTORS.TOOLBAR_BUILDER);
    const jsonEditor = document.querySelector(SELECTORS.JSON_EDITOR);

    if (!builder || !jsonEditor) {
        return;
    }

    const items = [...builder.querySelectorAll('[data-button]')].map(el => el.dataset.button);
    const toolbar = items.join(' ');

    let currentConfig = {};
    try {
        currentConfig = JSON.parse(jsonEditor.value) || {};
    } catch {
        // Use empty config on parse error.
    }
    currentConfig.toolbar = toolbar;
    jsonEditor.value = JSON.stringify(currentConfig, null, 2);
    validateJson();
};

/**
 * Populate the visual builder from the current JSON editor content.
 */
const syncVisualFromJson = () => {
    const builder    = document.querySelector(SELECTORS.TOOLBAR_BUILDER);
    const jsonEditor = document.querySelector(SELECTORS.JSON_EDITOR);

    if (!builder || !jsonEditor) {
        return;
    }

    let config = {};
    try {
        config = JSON.parse(jsonEditor.value) || {};
    } catch {
        return;
    }

    builder.innerHTML = '';
    const toolbar = config.toolbar || '';
    toolbar.split(/\s+/).forEach(btn => {
        if (!btn) {
            return;
        }
        const el = document.createElement('span');
        el.className = 'tinycustomizer-btn badge bg-secondary me-1 mb-1';
        el.setAttribute('draggable', 'true');
        el.dataset.button = btn;
        el.textContent = btn === '|' ? '|' : btn;
        el.addEventListener('dragstart', onDragStart);
        el.addEventListener('dragend', onDragEnd);
        builder.appendChild(el);
    });
};
