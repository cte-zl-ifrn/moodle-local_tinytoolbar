# Security Policy

## Supported Versions

| Version | Supported |
|---------|-----------|
| 1.x     | ✅ Yes     |

## Reporting a Vulnerability

We take security seriously. **Please do not open a public GitHub issue for security vulnerabilities.**

### How to report

1. **Email** the Moodle security team: **security@moodle.org**  
   (Follow the [Moodle security issue process](https://moodledev.io/general/development/process/security))

2. **Alternatively**, open a **private** security advisory on GitHub:  
   [https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/security/advisories/new](https://github.com/cte-zl-ifrn/moodle-local_tinytoolbar/security/advisories/new)

### What to include

Please provide:
- A clear description of the vulnerability.
- Steps to reproduce (proof-of-concept if possible).
- The affected version(s).
- Suggested mitigation or fix (optional but welcome).

### Response timeline

| Step | Target time |
|---|---|
| Acknowledgement | Within **48 hours** |
| Initial assessment | Within **7 days** |
| Fix released | Within **30 days** (critical issues sooner) |

### Responsible disclosure

We ask that you:
- Allow us reasonable time to patch before public disclosure.
- Avoid accessing or modifying other users' data during testing.
- Act in good faith.

We will credit reporters in the release notes (unless anonymity is requested).

---

## Security considerations for administrators

- Only users with `moodle/site:config` capability can access or modify toolbar settings.
- Custom JSON input is validated server-side before storage.
- No user-generated HTML is rendered unsanitised.
- The plugin stores no personal data (see Privacy API implementation).
