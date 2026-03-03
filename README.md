# local_tinytoolbar – Tiny Toolbar Configurator

[![Moodle Plugin CI](https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/actions/workflows/moodle-plugin-ci.yml/badge.svg)](https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/actions/workflows/moodle-plugin-ci.yml)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![Moodle 4.5+](https://img.shields.io/badge/Moodle-4.5%2B-orange)](https://moodle.org)

> A Moodle **local plugin** that lets administrators configure the **TinyMCE editor toolbar and menus** through a visual, drag-and-drop admin interface — no code changes required.

---

## ✨ Features

| Feature | Description |
|---|---|
| 🎛️ Visual toolbar builder | Drag-and-drop buttons to build your toolbar |
| 📋 5 built-in presets | Minimal, Classic, Full, Accessibility, Custom |
| 🔄 Live JSON preview | Real-time validation and iframe preview |
| 🌍 i18n | English and Portuguese (pt_BR) |
| 🔒 Privacy API | No personal data stored |
| 🚀 GitHub Actions | Automatic ZIP on every tagged release |
| ✅ CI pipeline | PHP lint, CodeSniffer, PHPUnit, Behat |

---

## 📋 Requirements

- **Moodle** 4.5 or higher (requires `2024042200`)
- **PHP** 8.1, 8.2, or 8.3
- TinyMCE editor enabled in Moodle

---

## 📦 Installation

### Option A – Install from GitHub Release ZIP (recommended)

1. Download the latest ZIP from the [Releases page](https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/releases).
2. In Moodle: **Site administration → Plugins → Install plugins**.
3. Upload the ZIP and follow the on-screen wizard.
4. After installation, the plugin is ready under  
   **Site administration → Plugins → Local plugins → Tiny Toolbar Configurator**.

### Option B – Manual install via Git

```bash
cd /path/to/moodle/local
git clone https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar.git tinytoolbar
```

Then visit **Site administration → Notifications** to run the database upgrade.

---

## ⚙️ Configuration

### Quick start (< 30 seconds)

1. Go to **Site administration → Plugins → Local plugins → Tiny Toolbar Configurator**.
2. Tick **Enable Tiny Toolbar Configurator**.
3. Choose a **preset** from the dropdown.
4. Click **Save changes**.

That's it — TinyMCE now uses your selected toolbar.

### Visual configurator

For full control, click the **Configure Toolbar** button on the settings page or navigate directly to:

```
/local/tinytoolbar/admin/config_form.php
```

From here you can:
- Switch between **JSON editor** and **visual drag-and-drop builder**.
- See a **live preview** of the toolbar in the right-hand iframe.
- Apply any of the 5 presets instantly.
- Write raw JSON for maximum flexibility.

---

## 🎨 Presets

| Preset | Description | Buttons |
|---|---|---|
| **Minimal** | Bare essentials | `undo redo \| bold italic` |
| **Boost Classic** | Moodle default-like | Format, bold/italic, align, lists, link |
| **Full** | Everything enabled | All standard TinyMCE buttons + media, table, code |
| **Accessibility** | Screen-reader friendly | Reduced set + a11y options |
| **Custom** | Your own JSON | You define it |

### Custom JSON format

```json
{
  "toolbar": "undo redo | bold italic | link image",
  "menubar": "file edit view insert format",
  "plugins": "link image lists"
}
```

---

## 🛠️ Developer notes

### Build AMD modules

```bash
npm install
npx grunt amd
```

### Run PHPUnit tests

```bash
vendor/bin/phpunit --testsuite local_tinytoolbar_testsuite
```

### Run Behat tests

```bash
php admin/tool/behat/cli/init.php
vendor/bin/behat --config /path/to/behat.yml --tags @local_tinytoolbar
```

---

## 📁 File structure

```
local/tinytoolbar/
├── version.php              # Plugin metadata
├── db/
│   ├── install.xml          # Database schema
│   └── services.php         # Web services
├── lang/
│   ├── en/                  # English strings
│   └── pt_br/               # Portuguese (Brazil) strings
├── classes/
│   ├── toolbar_config.php   # Core logic + TinyMCE hook
│   ├── external.php         # AJAX/REST API
│   └── privacy/provider.php # Privacy API
├── admin/
│   ├── settings.php         # Admin settings page
│   ├── config_form.php      # Visual configurator page
│   └── preview.php          # Live preview iframe
├── amd/src/
│   ├── admin.js             # Drag-and-drop builder AMD module
│   ├── preview.js           # Live preview AMD module
│   └── index.js             # Module re-exports
├── templates/
│   └── config.mustache      # Configurator page template
├── tests/
│   ├── toolbar_config_test.php
│   └── behat/tinytoolbar_admin.feature
├── pix/toolbar.svg          # Plugin icon
├── styles.css               # Plugin styles
└── .github/workflows/       # CI + release automation
```

---

## 🤝 Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## 🔒 Security

See [SECURITY.md](SECURITY.md) for vulnerability reporting instructions.

## 📜 Changelog

See [CHANGELOG.md](CHANGELOG.md) for release history.

## 📄 License

This plugin is licensed under the [GNU General Public License v3.0](LICENSE).
