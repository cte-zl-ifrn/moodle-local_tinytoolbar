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
 * Visual toolbar configurator page for tool_tinycustomizer.
 *
 * @package    tool_tinycustomizer
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

use tool_tinycustomizer\toolbar_config;

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url('/admin/tool/tinycustomizer/admin/config_form.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('configuretoolbar', 'tool_tinycustomizer'));
$PAGE->set_heading(get_string('configuretoolbar', 'tool_tinycustomizer'));
$PAGE->set_pagelayout('admin');

// Load AMD module for the visual editor.
$PAGE->requires->js_call_amd('tool_tinycustomizer/admin', 'init', []);

// Handle form submission.
$action = optional_param('action', '', PARAM_ALPHA);

if ($action === 'save' && confirm_sesskey()) {
    $enabled      = optional_param('enable_plugin', 0, PARAM_INT);
    $activepreset = optional_param('active_preset', 'classic', PARAM_ALPHANUMEXT);
    $toolbarjson  = optional_param('toolbar_json', '', PARAM_RAW);

    // Validate preset name.
    if (!in_array($activepreset, toolbar_config::get_preset_names())) {
        redirect($PAGE->url, get_string('error:invalidpreset', 'tool_tinycustomizer'), null, \core\output\notification::NOTIFY_ERROR);
    }

    // Validate custom JSON.
    if ($activepreset === toolbar_config::PRESET_CUSTOM && !empty($toolbarjson)) {
        if (!toolbar_config::validate_json($toolbarjson)) {
            redirect($PAGE->url, get_string('invalidjson', 'tool_tinycustomizer'), null, \core\output\notification::NOTIFY_ERROR);
        }
    }

    set_config('enable_plugin', $enabled, 'tool_tinycustomizer');
    set_config('active_preset', $activepreset, 'tool_tinycustomizer');
    set_config('toolbar_json', $toolbarjson, 'tool_tinycustomizer');

    redirect($PAGE->url, get_string('configsaved', 'tool_tinycustomizer'), null, \core\output\notification::NOTIFY_SUCCESS);
}

// Build template context.
$presets = [];
foreach (toolbar_config::get_presets() as $name => $json) {
    $presets[] = [
        'name'    => $name,
        'label'   => get_string('preset_' . $name, 'tool_tinycustomizer'),
        'json'    => $json,
        'active'  => (get_config('tool_tinycustomizer', 'active_preset') === $name),
    ];
}
$presets[] = [
    'name'   => toolbar_config::PRESET_CUSTOM,
    'label'  => get_string('preset_custom', 'tool_tinycustomizer'),
    'json'   => '',
    'active' => (get_config('tool_tinycustomizer', 'active_preset') === toolbar_config::PRESET_CUSTOM),
];

$templatecontext = [
    'actionurl'        => $PAGE->url->out(false),
    'sesskey'          => sesskey(),
    'enabled'          => (bool) get_config('tool_tinycustomizer', 'enable_plugin'),
    'active_preset'    => get_config('tool_tinycustomizer', 'active_preset') ?: 'classic',
    'toolbar_json'     => get_config('tool_tinycustomizer', 'toolbar_json') ?: '',
    'presets'          => $presets,
    'previewurl'       => (new moodle_url('/admin/tool/tinycustomizer/admin/preview.php'))->out(false),
    'availablebuttons' => array_map(
        fn($b) => ['name' => $b],
        ['undo', 'redo', 'bold', 'italic', 'underline', 'strikethrough',
         'alignleft', 'aligncenter', 'alignright', 'alignjustify',
         'bullist', 'numlist', 'outdent', 'indent',
         'link', 'unlink', 'image', 'media', 'table',
         'forecolor', 'backcolor', 'removeformat', 'code', 'fullscreen',
         'formatselect', 'fontselect', 'fontsizeselect',
         'subscript', 'superscript', 'charmap', 'emoticons', 'preview', 'help']
    ),
    'str'              => [
        'configuretoolbar' => get_string('configuretoolbar', 'tool_tinycustomizer'),
        'savechanges'      => get_string('savechanges', 'tool_tinycustomizer'),
        'resettodefault'   => get_string('resettodefault', 'tool_tinycustomizer'),
        'active_preset'    => get_string('active_preset', 'tool_tinycustomizer'),
        'toolbar_json'     => get_string('toolbar_json', 'tool_tinycustomizer'),
        'previewlive'      => get_string('previewlive', 'tool_tinycustomizer'),
        'enable_plugin'    => get_string('enable_plugin', 'tool_tinycustomizer'),
        'jsoneditor'       => get_string('jsoneditor', 'tool_tinycustomizer'),
        'visualeditor'     => get_string('visualeditor', 'tool_tinycustomizer'),
    ],
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('tool_tinycustomizer/config', $templatecontext);
echo $OUTPUT->footer();
