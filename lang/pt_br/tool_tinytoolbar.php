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
 * Language strings for tool_tinytoolbar (Portuguese/Brazil).
 *
 * @package    tool_tinytoolbar
 * @copyright  2024 IFRN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Configurador da Barra de Ferramentas TinyMCE';
$string['plugindesc'] = 'Configure a barra de ferramentas e menus do editor TinyMCE por meio de uma interface administrativa visual.';

// Settings.
$string['settings'] = 'Configurações da Barra de Ferramentas';
$string['toolbar_json'] = 'Configuração da barra de ferramentas (JSON)';
$string['toolbar_json_desc'] = 'Configure a barra de ferramentas do TinyMCE usando o formato JSON. Use predefinições ou crie sua própria configuração.';
$string['active_preset'] = 'Predefinição ativa';
$string['active_preset_desc'] = 'Selecione uma predefinição pré-configurada da barra de ferramentas ou escolha "Personalizado" para usar sua própria configuração JSON.';
$string['enable_plugin'] = 'Ativar Configurador da Barra de Ferramentas TinyMCE';
$string['enable_plugin_desc'] = 'Quando ativado, este plugin substituirá a configuração padrão da barra de ferramentas do TinyMCE.';

// Presets.
$string['preset_minimal'] = 'Mínimo';
$string['preset_classic'] = 'Boost Clássico';
$string['preset_full'] = 'Completo';
$string['preset_accessibility'] = 'Acessibilidade';
$string['preset_custom'] = 'Personalizado';

// Admin interface.
$string['configuretoolbar'] = 'Configurar Barra de Ferramentas';
$string['preview'] = 'Visualização Prévia';
$string['savechanges'] = 'Salvar alterações';
$string['resettodefault'] = 'Redefinir para o padrão';
$string['previewlive'] = 'Visualização ao vivo';
$string['draganddrop'] = 'Arraste e solte itens da barra de ferramentas';
$string['availablebuttons'] = 'Botões disponíveis';
$string['toolbarrows'] = 'Linhas da barra de ferramentas';
$string['addrow'] = 'Adicionar linha';
$string['removerow'] = 'Remover linha';
$string['separator'] = 'Separador';
$string['configsaved'] = 'Configuração da barra de ferramentas salva com sucesso.';
$string['configerror'] = 'Erro ao salvar a configuração da barra de ferramentas.';
$string['invalidjson'] = 'Configuração JSON inválida.';
$string['presetapplied'] = 'Predefinição aplicada: {$a}';
$string['currentconfig'] = 'Configuração atual';
$string['jsoneditor'] = 'Editor JSON';
$string['visualeditor'] = 'Editor visual';
$string['toggleeditor'] = 'Alternar modo do editor';

// Capabilities.
$string['tinytoolbar:manage'] = 'Gerenciar configuração da barra de ferramentas TinyMCE';

// Privacy.
$string['privacy:metadata'] = 'O plugin Configurador da Barra de Ferramentas TinyMCE não armazena dados pessoais.';

// Errors.
$string['error:invalidpreset'] = 'Nome de predefinição inválido.';
$string['error:savefailed'] = 'Falha ao salvar a configuração. Por favor, tente novamente.';
$string['error:permissiondenied'] = 'Você não tem permissão para gerenciar a configuração da barra de ferramentas.';
