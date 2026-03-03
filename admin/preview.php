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
 * Live preview page for tool_tinytoolbar (rendered inside an iframe).
 *
 * @package    tool_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../../config.php');

use tool_tinytoolbar\toolbar_config;

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url('/admin/tool/tinytoolbar/admin/preview.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('preview', 'tool_tinytoolbar'));
$PAGE->set_pagelayout('embedded');

$configjson = optional_param('config', '', PARAM_RAW);
$config = [];
if (!empty($configjson)) {
    $decoded = json_decode($configjson, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $config = $decoded;
    }
} else {
    $config = toolbar_config::get_active_config();
}

$toolbaroption  = isset($config['toolbar']) ? s($config['toolbar']) : '';
$menubaroption  = isset($config['menubar']) ? (is_bool($config['menubar']) ? ($config['menubar'] ? 'true' : 'false') : s($config['menubar'])) : 'true';

echo $OUTPUT->header();
?>
<div id="tinytoolbar-preview-container" class="tool-tinytoolbar-preview">
    <div id="tinytoolbar-preview-editor"></div>
</div>
<script>
    require(['core_editor/loader'], function(loader) {
        loader.getEditor('textarea').then(function(editor) {
            if (editor && editor.name === 'tiny') {
                var target = document.getElementById('tinytoolbar-preview-editor');
                var textarea = document.createElement('textarea');
                textarea.id = 'preview-textarea';
                textarea.name = 'preview';
                textarea.value = '<p>Preview TinyMCE toolbar configuration.</p>';
                target.appendChild(textarea);

                var initConfig = {
                    target: textarea,
                    toolbar: <?php echo json_encode($toolbaroption ?: null); ?>,
                    menubar: <?php echo $menubaroption; ?>,
                    height: 400,
                };

                if (typeof tinymce !== 'undefined') {
                    tinymce.init(initConfig);
                }
            }
        }).catch(function() {
            document.getElementById('tinytoolbar-preview-container').innerHTML =
                '<div class="alert alert-info">' +
                'TinyMCE preview requires a full Moodle page context with an active editor instance.' +
                '</div>';
        });
    });
</script>
<?php
echo $OUTPUT->footer();
