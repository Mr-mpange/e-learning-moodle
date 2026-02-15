# Modern Moodle Theme

A clean, modern theme for Moodle with enhanced UI/UX features including redesigned login, registration, and dashboard pages.

## Features

- **Modern Login Page**: Centralized card layout with gradient background and smooth animations
- **Enhanced Dashboard**: Clean interface with sidebar navigation and course cards
- **Responsive Design**: Mobile-first approach with breakpoints for all devices
- **Accessibility**: WCAG 2.1 AA compliant
- **Customizable**: Easy color customization through theme settings
- **Performance Optimized**: Minimal CSS and JavaScript for fast loading

## Installation

1. Copy the `modernmoodle` folder to your Moodle `theme` directory
2. Log in as an administrator
3. Navigate to Site Administration → Notifications
4. Click "Upgrade Moodle database now" to install the theme
5. Navigate to Site Administration → Appearance → Themes → Theme selector
6. Select "Modern Moodle" as your theme

## Configuration

### Theme Settings

Navigate to Site Administration → Appearance → Themes → Modern Moodle to configure:

- **Brand Color**: Primary color for buttons and links
- **Secondary Color**: Accent color for highlights
- **Logo**: Upload your custom logo

### Custom SCSS

You can add custom SCSS in the theme settings:
- **Raw initial SCSS**: Variables and mixins
- **Raw SCSS**: Additional styles

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- Moodle 4.3 or later
- PHP 8.0 or later

## File Structure

```
modernmoodle/
├── amd/
│   └── src/
│       └── main.js
├── lang/
│   └── en/
│       └── theme_modernmoodle.php
├── layout/
│   ├── columns.php
│   ├── dashboard.php
│   ├── login.php
│   └── secure.php
├── scss/
│   ├── _components.scss
│   ├── _dashboard.scss
│   ├── _login.scss
│   ├── _signup.scss
│   └── _variables.scss
├── templates/
│   └── theme_modernmoodle/
│       ├── dashboard.mustache
│       ├── login.mustache
│       └── secure.mustache
├── config.php
├── lib.php
├── version.php
└── README.md
```

## Customization

### Colors

Edit `scss/_variables.scss` to change the color scheme:

```scss
$primary-color: #3B82F6;
$secondary-color: #8B5CF6;
$success-color: #10B981;
$warning-color: #F59E0B;
$error-color: #EF4444;
```

### Typography

Modify font settings in `scss/_variables.scss`:

```scss
$font-family-base: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
$font-size-base: 15px;
```

## Development

### Compiling SCSS

After making changes to SCSS files:

1. Navigate to Site Administration → Development → Purge caches
2. Click "Purge all caches"

### JavaScript Development

AMD modules are located in `amd/src/`. After editing:

1. Run Grunt to compile: `grunt amd`
2. Purge caches

## Support

For issues and feature requests, please contact your Moodle administrator.

## License

This theme is licensed under the GNU GPL v3 or later.

## Credits

Developed for modern educational platforms with focus on user experience and accessibility.

## Changelog

### Version 1.0.0 (2026-02-08)
- Initial release
- Modern login page design
- Enhanced dashboard layout
- Responsive design implementation
- Accessibility improvements
