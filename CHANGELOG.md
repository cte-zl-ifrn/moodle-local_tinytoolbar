# Changelog

All notable changes to **local_tinytoolbar** are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)  
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

_Nothing yet._

---

## [1.0.0] – 2024-12-01

### Added

- Initial release of **Tiny Toolbar Configurator** for Moodle 4.5+.
- Visual drag-and-drop toolbar builder in the admin interface.
- Live TinyMCE preview via embedded iframe.
- Five built-in toolbar presets:
  - **Minimal** – undo/redo, bold, italic.
  - **Boost Classic** – format selector, alignment, lists, link.
  - **Full** – all standard TinyMCE buttons plus media, table, code.
  - **Accessibility** – reduced set with a11y options enabled.
  - **Custom** – free-form JSON configuration.
- Real-time JSON validation with inline status indicator.
- AMD modules (`admin.js`, `preview.js`, `index.js`) following Moodle standards.
- AJAX web services (`local_tinytoolbar_get_config`, `local_tinytoolbar_save_config`, `local_tinytoolbar_get_presets`).
- `toolbar_config::tiny_get_config_data()` hook for TinyMCE integration.
- Language files for **English (en)** and **Portuguese Brazil (pt_BR)**.
- Privacy API implementation (`null_provider` – no personal data stored).
- PHPUnit test suite (`toolbar_config_test.php`).
- Behat feature (`tinytoolbar_admin.feature`).
- GitHub Actions workflows:
  - `moodle-plugin-ci.yml` – continuous integration (PHP 8.1/8.2/8.3).
  - `release.yml` – automatic ZIP generation on tagged releases.
- Bootstrap 5 compatible styles (`styles.css`).
- Plugin icon (`pix/toolbar.svg`).
- Documentation: `README.md`, `SECURITY.md`, `CONTRIBUTING.md`, `CHANGELOG.md`.

---

[Unreleased]: https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/releases/tag/v1.0.0
