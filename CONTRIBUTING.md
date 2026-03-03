# Contributing to local_tinytoolbar

Thank you for your interest in contributing! This guide explains how to set up your development environment and submit quality contributions.

---

## 📋 Table of contents

1. [Code of conduct](#code-of-conduct)
2. [Getting started](#getting-started)
3. [Development setup](#development-setup)
4. [Coding standards](#coding-standards)
5. [Testing](#testing)
6. [Submitting changes](#submitting-changes)
7. [Release process](#release-process)

---

## Code of conduct

Please be respectful and constructive. We follow the [Moodle community guidelines](https://moodle.org/mod/page/view.php?id=8442).

---

## Getting started

1. **Fork** the repository on GitHub.
2. **Clone** your fork locally:
   ```bash
   git clone https://github.com/<your-username>/moodle-local_tinytoolbar.git
   cd moodle-local_tinytoolbar
   ```
3. Create a **feature branch**:
   ```bash
   git checkout -b feature/my-improvement
   ```

---

## Development setup

### PHP environment

```bash
# Install Composer dependencies (for linting / testing tools)
composer install
```

### JavaScript environment

```bash
npm install        # Install Node devDependencies
npx grunt amd      # Build AMD modules (output: amd/build/)
```

### Moodle integration

Place (or symlink) the plugin in your Moodle installation:

```bash
ln -s /path/to/moodle-local_tinytoolbar /path/to/moodle/local/tinytoolbar
```

Then run the Moodle upgrade:

```bash
php /path/to/moodle/admin/cli/upgrade.php
```

---

## Coding standards

### PHP

We follow **[Moodle Coding Style](https://moodledev.io/general/development/policies/codingstyle)**, which is based on **PSR-12** with Moodle-specific additions.

- Run the code sniffer before every commit:
  ```bash
  vendor/bin/phpcs --standard=moodle classes/ admin/ tests/
  ```
- Fix auto-fixable issues:
  ```bash
  vendor/bin/phpcbf --standard=moodle classes/ admin/ tests/
  ```

### JavaScript

- Follow **[Moodle JavaScript guidelines](https://moodledev.io/docs/guides/javascript)**.
- Use ES modules (`import`/`export`), avoid `var`.
- Lint with ESLint:
  ```bash
  npx eslint amd/src/
  ```

### Mustache templates

- Use `{{#str}}` helpers for language strings.
- Avoid inline JavaScript in templates.
- Lint:
  ```bash
  npx mustache-lint templates/
  ```

### CSS

- Follow **Bootstrap 5** conventions.
- Prefix all selectors with `.local-tinytoolbar-` or `.tinytoolbar-`.
- Lint:
  ```bash
  npx stylelint styles.css
  ```

---

## Testing

### PHPUnit

```bash
# From Moodle root:
vendor/bin/phpunit --testsuite local_tinytoolbar_testsuite
```

### Behat (browser tests)

```bash
php admin/tool/behat/cli/init.php
vendor/bin/behat --config behat/behat.yml --tags @local_tinytoolbar
```

### Full CI pipeline

The same checks run automatically on every pull request via GitHub Actions (`.github/workflows/moodle-plugin-ci.yml`). Ensure they pass locally before submitting.

---

## Submitting changes

1. Ensure all tests pass and linters report no errors.
2. Update `CHANGELOG.md` under the `[Unreleased]` section.
3. Push your branch and open a **Pull Request** against `main`.
4. Fill in the PR template (description, screenshots if applicable, test steps).
5. A maintainer will review your PR. Be ready to iterate.

### Commit message format

Follow [Conventional Commits](https://www.conventionalcommits.org/):

```
feat: add accessibility preset
fix: correct JSON validation for empty toolbar
docs: update README preset table
chore: upgrade eslint to 8.57
```

---

## Release process

Releases are automated via GitHub Actions:

1. Create and push a version tag:
   ```bash
   git tag v1.1.0
   git push origin v1.1.0
   ```
2. The `release.yml` workflow builds the ZIP and attaches it to the GitHub Release.
3. Update `CHANGELOG.md` to move `[Unreleased]` items under the new version heading.

---

Thank you for helping make this plugin better! 🎉
