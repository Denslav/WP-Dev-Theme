# Main Theme

A starter classic WordPress theme for developing custom websites. The theme includes basic WordPress templates, Gutenberg and `theme.json` support, local fonts, a responsive navigation menu, Customizer settings, SCSS, Gulp, Webpack, and a starter template for creating ACF blocks.

Current version: **1.0.2**

## Table of Contents

- [Theme Features](#theme-features)
- [System Requirements](#system-requirements)
- [Theme Installation](#theme-installation)
- [Development Tools Installation](#development-tools-installation)
- [Build Commands](#build-commands)
- [Local Environment Configuration](#local-environment-configuration)
- [Theme Structure](#theme-structure)
- [Working with Styles](#working-with-styles)
- [Working with JavaScript](#working-with-javascript)
- [Gutenberg and theme.json](#gutenberg-and-themejson)
- [ACF Blocks](#acf-blocks)
- [Loading CSS and JavaScript](#loading-css-and-javascript)
- [Fancybox](#fancybox)
- [Customizer](#customizer)
- [Menus](#menus)
- [Page Templates](#page-templates)
- [Localization](#localization)
- [Development Recommendations](#development-recommendations)
- [Preparing the Theme for Release](#preparing-the-theme-for-release)
- [Changelog](#changelog)

## Theme Features

- classic WordPress theme structure;
- Gutenberg support;
- editor settings configured through `theme.json`;
- wide and full-width block alignment;
- responsive embeds support;
- Gutenberg editor styles;
- primary and footer menu locations;
- responsive mobile navigation without a jQuery dependency;
- keyboard-accessible navigation;
- locally hosted Lato and Roboto fonts;
- basic templates for posts, pages, archives, search results, and the 404 page;
- comments support;
- container, header, and footer settings available through the Customizer;
- conditional Fancybox loading;
- SCSS compilation with Gulp;
- JavaScript bundling with Webpack and Babel;
- automatic generation of SCSS variables from `theme.json`;
- starter structure for registering ACF blocks;
- POT file for translating the theme's PHP strings.

## System Requirements

### Theme Requirements

Recommended configuration:

- WordPress 6.6 or later;
- PHP 8.0 or later;
- MySQL 5.7+ or MariaDB 10.4+;
- a modern web browser.

The theme may work with earlier versions of PHP and WordPress, but they are not recommended for development.

### Development Requirements

- Node.js 18 or later;
- npm;
- a local WordPress installation;
- ACF Pro, only when developing or using ACF blocks.

The Node.js version requirement is defined in `package.json`:

```json
"engines": {
  "node": ">=18"
}
```

## Theme Installation

### Through the WordPress Dashboard

1. Open **Appearance - Themes**.
2. Click **Add New Theme**.
3. Click **Upload Theme**.
4. Select the theme ZIP archive.
5. Install and activate the theme.
6. Go to **Appearance - Menus** and assign menus to the required locations.

### Through the File System

Extract the theme folder into:

```text
wp-content/themes/dev-main/
```

Then activate the theme in the WordPress dashboard.

The folder name may be different, but it must be specified in the `WP_THEME_NAME` environment variable when running BrowserSync.

## Development Tools Installation

Open the theme root directory and install the dependencies:

```bash
npm install
```

To install the exact dependency versions from `package-lock.json`, use:

```bash
npm ci
```

`npm ci` removes the existing `node_modules` directory before installing dependencies strictly according to the lock file.

## Build Commands

### Start Development Mode

```bash
npm run start
```

This command:

- cleans the `dist` directory;
- generates SCSS variables from `theme.json`;
- compiles styles;
- bundles JavaScript;
- copies fonts;
- starts BrowserSync;
- watches PHP, SCSS, JavaScript, font, and `theme.json` files for changes.

### Full Production Build

```bash
npm run build
```

The production build:

- cleans `dist`;
- minifies CSS;
- adds vendor prefixes;
- minifies JavaScript;
- copies fonts;
- does not generate source map files.

### Build CSS Only

```bash
npm run build:css
```

### Build JavaScript Only

```bash
npm run build:js
```

### Development Build with Source Maps

Linux and macOS:

```bash
NODE_ENV=development npm run build
```

Windows PowerShell:

```powershell
$env:NODE_ENV="development"
npm run build
```

Windows CMD:

```cmd
set NODE_ENV=development&& npm run build
```

## Local Environment Configuration

The `gulpfile.js` file uses two environment variables:

- `WP_PROXY` - the URL of the local WordPress website;
- `WP_THEME_NAME` - the active theme directory name.

Default values:

```text
WP_PROXY=http://nbco.loc
WP_THEME_NAME=dev-main
```

### Windows PowerShell Example

```powershell
$env:WP_PROXY="http://my-site.loc"
$env:WP_THEME_NAME="dev-main"
npm run start
```

### Windows CMD Example

```cmd
set WP_PROXY=http://my-site.loc
set WP_THEME_NAME=dev-main
npm run start
```

### Linux or macOS Example

```bash
WP_PROXY=http://my-site.local WP_THEME_NAME=dev-main npm run start
```

BrowserSync does not open the browser automatically. After it starts, open the URL displayed in the terminal.

## Theme Structure

```text
dev-main/
├── dist/                         # Compiled files used by WordPress
│   ├── css/
│   │   ├── blocks/              # Gutenberg and ACF block styles
│   │   ├── libs/                # Third-party library styles
│   │   ├── pages/               # Styles for individual page types
│   │   ├── admin-styles.css     # Gutenberg editor styles
│   │   ├── fonts.css            # Local font declarations
│   │   ├── footer.css
│   │   ├── global.css
│   │   └── header.css
│   ├── fonts/                   # Copied font files
│   └── js/                      # Compiled JavaScript files
├── inc/
│   ├── customizer.php           # Customizer settings
│   ├── enqueue.php              # CSS and JavaScript loading
│   ├── init.php                 # PHP module loader
│   ├── template-functions.php   # Template helper functions
│   └── theme-support.php        # WordPress feature support
├── languages/
│   └── main.pot                 # Translation template
├── parts/
│   ├── blocks/
│   │   └── main-hero/           # ACF block starter template
│   └── loops/
│       └── loop-post.php        # Post card used in loops
├── src/
│   ├── fonts/                   # Source font files
│   ├── js/                      # Source JavaScript files
│   └── scss/                    # Source SCSS files
├── 404.php
├── archive.php
├── comments.php
├── footer.php
├── functions.php
├── gulpfile.js
├── header.php
├── index.php
├── page.php
├── search.php
├── single.php
├── style.css
└── theme.json
```

## Working with Styles

Source styles are stored in:

```text
src/scss/
```

After compilation, they are saved to:

```text
dist/css/
```

Editing files in `dist/css` manually is not recommended because the next build will overwrite those changes.

### Main SCSS Files

```text
src/scss/global.scss              # Global website styles
src/scss/fonts.scss               # Font declarations
src/scss/header.scss              # Header and navigation
src/scss/footer.scss              # Footer
src/scss/admin-styles.scss        # Gutenberg editor styles
src/scss/pages/                   # Page template styles
src/scss/blocks/                  # Custom block styles
src/scss/libs/                    # Library styles
```

### SCSS Partial Files

Files whose names start with `_` are not compiled separately:

```text
_variables.scss
_mixins.scss
_base.scss
_typography.scss
_forms.scss
_content.scss
_listing.scss
_comments.scss
_gutenberg-variables.scss
```

They are imported by the main SCSS files.

### Converting px to rem

The build process uses `postcss-pxtorem` with the following base value:

```text
1rem = 16px
```

Most pixel values are automatically converted to `rem`.

## Working with JavaScript

Source files are stored in:

```text
src/js/
```

Webpack automatically creates a separate entry point for each `.js` file and saves the result using the same relative structure inside `dist/js`.

Example:

```text
src/js/header.js
```

is compiled to:

```text
dist/js/header.min.js
```

The file:

```text
src/js/blocks/example.js
```

is compiled to:

```text
dist/js/blocks/example.min.js
```

JavaScript is processed by Babel using the `@babel/preset-env` preset.

The mobile navigation script is written without jQuery. jQuery is used only by the Customizer preview script because it relies on the standard WordPress Customizer API.

## Gutenberg and theme.json

The `theme.json` file defines global editor and front-end settings:

- content and wide layout widths;
- color palette;
- gradients;
- font sizes;
- font families;
- base styles for text, headings, and links;
- available CSS units;
- spacing and block gap controls.

The theme uses `theme.json` version 3.

### Container Sizes

```text
contentSize: 75rem
wideSize: 90rem
```

### Fonts

- Lato - headings;
- Roboto - body text.

### Automatic SCSS Variable Generation

During a full build, the `jsonToScss` task reads `theme.json` and creates:

```text
src/scss/_gutenberg-variables.scss
```

The generated file includes:

- container sizes;
- colors;
- gradients;
- font sizes;
- font families.

After changing `theme.json`, run a full build:

```bash
npm run build
```

When using `npm run start`, changes to `theme.json` are watched automatically.

## ACF Blocks

The theme includes a starter block in:

```text
parts/blocks/main-hero/
```

It contains:

```text
block.json
block-render-template.php
```

The block stylesheet is located at:

```text
src/scss/blocks/main-hero.scss
```

Compiled file:

```text
dist/css/blocks/main-hero.css
```

### Important

`main-hero` is only a starter template. It intentionally does not include production-ready markup, ACF fields, or design styles.

To make the block fully functional:

1. install and activate ACF Pro;
2. create an ACF field group;
3. assign the field group to the `thm/main-hero` block;
4. add field output to `block-render-template.php`;
5. add styles to `main-hero.scss`;
6. build the theme.

### Block Registration

The block list is defined in the `main_register_acf_blocks()` function:

```php
$blocks = array( 'main-hero' );
```

To add a new block, create its directory and add the folder name to the array:

```php
$blocks = array(
    'main-hero',
    'content-section',
);
```

### Recommended Structure for a New Block

```text
parts/blocks/content-section/
├── block.json
└── block-render-template.php

src/scss/blocks/content-section.scss
src/js/blocks/content-section.js
```

Create a JavaScript file only when the block actually requires interactivity.

### block.json Example

```json
{
  "name": "thm/content-section",
  "title": "Content Section",
  "category": "main-blocks",
  "icon": "layout",
  "apiVersion": 2,
  "acf": {
    "mode": "preview",
    "renderTemplate": "block-render-template.php"
  },
  "style": "file:../../../dist/css/blocks/content-section.css",
  "supports": {
    "align": ["full"],
    "anchor": true,
    "html": false,
    "spacing": {
      "margin": true,
      "padding": true
    }
  },
  "textdomain": "main"
}
```

When using the custom `main-blocks` category, register it in WordPress or replace it with a standard category such as `design`.

## Loading CSS and JavaScript

Assets are loaded in:

```text
inc/enqueue.php
```

File modification timestamps from `filemtime()` are used for versioning. This ensures that browsers receive the latest asset version after a file changes instead of using an outdated cached copy.

### Global Assets

The following files are loaded on the front end:

```text
fonts.css
global.css
header.css
footer.css
header.min.js
```

### Page-Specific Styles

Files from `dist/css/pages/` are loaded conditionally:

```text
front-page.css - front page
single.css     - single post
page.css       - standard page
archive.css    - archives and posts page
search.css     - search results
404.css        - 404 page
```

To add styles for another conditional template:

1. create an SCSS file in `src/scss/pages/`;
2. build the theme;
3. add a condition to the `$page_styles` array inside `main_theme_assets()`.

## Fancybox

Fancybox is loaded only when required instead of being included on every page.

The library is loaded when one of the following is detected in the post or page content:

- a `data-fancybox` attribute;
- the standard `core/gallery` block;
- the `acf/fancy-box-gallery` block;
- the `[gallery]` shortcode.

The check is handled by:

```php
main_should_enqueue_fancybox()
```

You can change this behavior with the following filter:

```php
add_filter( 'main_should_enqueue_fancybox', function ( $should_enqueue ) {
    if ( is_page_template( 'templates/gallery.php' ) ) {
        return true;
    }

    return $should_enqueue;
} );
```

Source files:

```text
src/js/libs/fancybox.js
src/js/blocks/fancy-box-gallery.js
src/scss/libs/fancybox.scss
```

## Customizer

The theme adds the following settings:

- container width;
- horizontal container padding;
- header background color;
- footer background color;
- default site title color.

The settings are defined in:

```text
inc/customizer.php
```

Dynamic styles are generated by:

```php
main_get_dynamic_css()
```

and loaded with:

```php
wp_add_inline_style()
```

### Value Ranges

Container width:

```text
800-1920 px
```

Horizontal padding:

```text
0-100 px
```

Backward compatibility with previous Customizer setting names is preserved.

## Menus

The theme registers two menu locations:

```text
primary - primary navigation
footer  - footer navigation
```

Menus can be assigned under:

```text
Appearance - Menus - Manage Locations
```

The mobile navigation supports:

- opening and closing with a button;
- nested submenus;
- `aria-expanded`, `aria-controls`, and `aria-hidden` attributes;
- closing with the Escape key;
- closing when clicking outside the header;
- locking page scrolling;
- returning focus to the menu button;
- automatic available-height calculation;
- switching between mobile and desktop modes.

Source file:

```text
src/js/header.js
```

## Page Templates

### `index.php`

The default WordPress fallback template.

### `single.php`

The single post template supports:

- title;
- publication date;
- author;
- featured image;
- content;
- paginated post content;
- categories;
- tags;
- comments.

### `page.php`

The standard page template.

### `archive.php`

The template for category, tag, date, author, and custom taxonomy archives.

### `search.php`

The search results template.

### `404.php`

The template displayed when the requested content cannot be found.

### `comments.php`

The comments list and comment form template.

### `parts/loops/loop-post.php`

A reusable post card for archives, search results, and the main loop.

## Localization

Theme Text Domain:

```text
main
```

The translation template is located at:

```text
languages/main.pot
```

When adding new user-facing strings, use WordPress translation functions:

```php
__( 'Text', 'main' );
esc_html__( 'Text', 'main' );
esc_attr__( 'Text', 'main' );
_e( 'Text', 'main' );
```

Use the appropriate escaping function when outputting dynamic values:

```php
esc_html()
esc_attr()
esc_url()
wp_kses_post()
```

## Development Recommendations

### Do Not Edit `dist` Manually

Development should be performed in:

```text
src/scss/
src/js/
src/fonts/
```

Run the build process after making changes.

### Use a Child Theme for Third-Party Projects

When the theme is distributed and updated as a standalone product, project-specific changes should be placed in a child theme. When it is used as a starter theme for each new project, it can be copied and its name, Text Domain, and function namespace can be changed directly.

### Rename the Theme for Each New Project

For a separate website, update:

- the theme name in `style.css`;
- the package name in `package.json`;
- the `main` Text Domain;
- the `main_` function prefix;
- the `MAIN_THEME_VERSION` constant;
- the theme directory name;
- author information;
- the theme screenshot.

This is especially important when multiple custom themes or plugins with similar function names may run on the same WordPress installation.

### Use Prefixes

All new global functions, hooks, constants, and identifiers should use a unique project prefix.

### Validate Output Security

- text - `esc_html()`;
- attributes - `esc_attr()`;
- URLs - `esc_url()`;
- allowed HTML - `wp_kses_post()`;
- input data - appropriate `sanitize_*` functions;
- forms and AJAX - nonces and user capability checks.

### Load Assets Conditionally

Do not load large libraries on every page. Use WordPress conditional tags, block metadata, and separate entry points.

### Do Not Include `node_modules` in the Theme Archive

The installation archive should include compiled files from `dist`, but it should not include:

```text
node_modules/
.git/
.idea/
.vscode/
*.map
```

Source map files should be included only in development archives.

## Preparing the Theme for Release

Before creating the final ZIP archive:

1. update the version in `style.css`;
2. update `MAIN_THEME_VERSION` in `functions.php`;
3. update the version in `package.json`;
4. run a production build:

```bash
npm run build
```

5. validate PHP syntax;
6. test the main templates;
7. test the mobile navigation;
8. test the Gutenberg editor;
9. test the 404 page and search results;
10. clear WordPress and optimization plugin caches;
11. do not include `node_modules` in the ZIP archive;
12. create the archive so that the theme folder is located at the archive root.

### PHP Syntax Validation

Linux, macOS, or Git Bash:

```bash
find . -name "*.php" -not -path "./node_modules/*" -print0 | xargs -0 -n1 php -l
```

PowerShell:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

## Changelog

### 1.0.2

- added basic styles for posts, pages, archives, search results, and the front page;
- added Gutenberg editor styles;
- synchronized core design settings with `theme.json`;
- fixed global image behavior;
- changed Fancybox to conditional loading;
- rewrote the mobile navigation using native JavaScript;
- improved mobile navigation accessibility;
- added post metadata and comments support;
- removed the unused sidebar;
- added `dist` cleanup before a full build;
- added `glob` as a direct dependency;
- removed unused build dependencies;
- added the `languages/main.pot` translation template;
- updated the theme screenshot;
- preserved backward compatibility with previous Customizer settings;
- kept `main-hero` as an empty starter template for a future ACF block.

### 1.0.1

- initial starter theme release.

## Author

**Den Slav / Denslav**

## License

The build tools in `package.json` use the ISC license. Before distributing the theme publicly, add a separate `LICENSE` file and explicitly define the licenses for the PHP, CSS, JavaScript, fonts, and third-party libraries.
