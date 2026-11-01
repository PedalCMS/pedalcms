# PedalCMS

[![Version](https://img.shields.io/badge/version-0.7.0-blue.svg)](https://github.com/PedalCMS/pedalcms)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![WordPress](https://img.shields.io/badge/WordPress-6.9%2B-blue.svg)](https://wordpress.org)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

A comprehensive WordPress plugin designed as a **program marketing powerhouse** for educational institutions. PedalCMS provides a complete content management system for academic programs, courses, faculty, and student information.

## 📖 Documentation

The documentation lives at **[pedalcms.com/docs](https://pedalcms.com/docs)** and is maintained in a separate docs repository:

- **User guide**: a hands-on course for site administrators and content editors.
- **Developer handbook**: architecture, template overrides, configuration and hooks.
- **PHP API reference** and **hooks reference**: generated from this source by the docs repository for every release.

## 🚀 Features

### 📚 **Program Management**
- **Programs**: Comprehensive program listings with detailed information
- **Courses**: Course catalog with scheduling and prerequisites
- **Subpages**: Flexible program sub-content (Apply, Cost, Faculty, FAQs, etc.)
- **Program Types**: Categorization and filtering system

### 👥 **People Directory**
- **Faculty & Staff**: Complete team directory with profiles
- **Person Categories**: Flexible categorization system
- **Contact Information**: Structured contact details and job titles
- **Photo Management**: Professional headshot integration

### 📖 **Course System**
- **Course Catalog**: Detailed course information and descriptions
- **Prerequisites**: Course dependency management
- **Scheduling**: Session and timing management
- **Subjects**: Course categorization by academic subject

### 🎯 **Content Blocks**
- **Custom Blocks**: Gutenberg-compatible content blocks
- **Contact Info Blocks**: Structured contact information display
- **Job Title Blocks**: Professional title and role management
- **FAQ System**: Organized frequently asked questions

### 🏢 **Organizational Structure**
- **Colleges**: High-level institutional organization
- **Departments**: Academic department management
- **Instruction Modes**: Online, hybrid, in-person classifications

## 🛠️ Installation

### Requirements
- **WordPress**: 6.9 or higher
- **PHP**: 8.2 or higher
- **MySQL**: 5.6 or higher

### Quick Install

#### Via WordPress Admin
1. Download the latest release from [GitHub](https://github.com/PedalCMS/pedalcms)
2. Navigate to **Plugins > Add New > Upload Plugin**
3. Upload the `pedalcms.zip` file
4. Click **Install Now** and then **Activate**

#### Via FTP
1. Download and extract `pedalcms.zip`
2. Upload the `pedalcms` directory to `/wp-content/plugins/`
3. Activate the plugin through the WordPress admin

#### Via Composer
```bash
composer require pedalcms/pedalcms
```

### Configuration Constants

Define these in `wp-config.php` before WordPress loads plugins.

| Constant | Effect |
|---|---|
| `PEDALCMS_DISABLE_SETTINGS_UI` | Removes the Pedal CMS settings page and the links to it. Stored settings still apply and can still be changed programmatically. |

```php
define( 'PEDALCMS_DISABLE_SETTINGS_UI', true );
```

To decide at runtime instead — per role, per environment — filter
`pedalcms/settings_ui_enabled`:

```php
add_filter( 'pedalcms/settings_ui_enabled', function ( $enabled ) {
	return current_user_can( 'manage_network' );
} );
```

## 🎨 Template System

PedalCMS includes a complete template system for displaying content. To change any template, copy it into `your-theme/pedalcms/` (keeping the same file name and sub-folder); see *Template overrides* in the [developer handbook](https://pedalcms.com/docs/developers/template-overrides/).

### Single Templates
- `single-program.php` - Individual program pages
- `single-course.php` - Individual course pages  
- `single-person.php` - Faculty/staff profile pages

### Archive Templates
- `archive-program.php` - Program listings
- `archive-course.php` - Course catalog
- `archive-person.php` - People directory

### Taxonomy Templates
- `taxonomy-program-type.php` - Programs by type
- `taxonomy-person-cat.php` - People by category
- `taxonomy-college.php` - Content by college
- `taxonomy-department.php` - Content by department

## 🧩 Custom Post Types

| Post Type | Description | Slug |
|-----------|-------------|------|
| Programs | Academic programs and degrees | `pedalcms_program` |
| Courses | Individual courses and classes | `pedalcms_course` |
| People | Faculty, staff, and personnel | `pedalcms_person` |
| FAQs | Frequently asked questions | `pedalcms_faq` |

## 🏷️ Taxonomies

| Taxonomy | Description | Used For |
|----------|-------------|----------|
| Program Types | Categories of programs | Programs |
| Person Categories | Faculty/staff classifications | People |
| Colleges | Institutional divisions | Programs, Courses, People |
| Departments | Academic departments | Programs, Courses, People |
| Subjects | Academic subjects | Courses |
| FAQ Categories | FAQ organization | FAQs |
| Instruction Modes | Delivery methods | Programs |

## 🎛️ Template Tags

PedalCMS provides numerous template tags for theme development:

### Common Functions
```php
pedalcms_get_option( $option, $fallback )          // Read a plugin setting
pedalcms_get_label( $label_key )                   // Read a front-end label
pedalcms_get_field( $selector, $post_id )          // Read a field value (post, term or setting)
pedalcms_get_the_term_list( $post, $taxonomy )     // Get a formatted list of terms
pedalcms_get_action_link( $action, $program )      // Get a program button URL
pedalcms_get_template_part( $template, $data )     // Load a plugin template
```

### Subpage and Filter Functions
```php
pedalcms_register_program_subpage( $slug, $args )  // Register a custom program subpage
pedalcms_get_subpages()                            // Get the registered program subpages
pedalcms_get_active_subpage()                      // Get the slug of the current subpage
pedalcms_subpage_link( $subpage )                  // Output or return a subpage URL
pedalcms_register_filter( $slug, $args )           // Register an archive search filter
```

See the PHP API reference in the [documentation](https://pedalcms.com/docs/phpdocs/) for the full list.

## 🧪 Development

### Setup Development Environment

1. **Clone the repository**
   ```bash
   git clone https://github.com/PedalCMS/pedalcms.git
   cd pedalcms
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

   > **Prefixed dependencies:** `pedalcms/cassette-cmf` is namespace-prefixed with
   > [Strauss](https://github.com/BrianHenryIE/strauss) so it cannot collide with another
   > plugin's copy. `composer install`/`update` runs `composer prefix-namespaces`, which
   > downloads a pinned `bin/strauss.phar` (git-ignored) and writes the prefixed library to
   > `vendor-prefixed/` (also git-ignored, `PedalCMS\Vendor\PedalCMS\CassetteCMF`). Never
   > reference the unprefixed namespace in plugin code, and always run `composer install`
   > (not just a copy of `vendor/`) before building or testing.

3. **Start development environment**
   ```bash
   npm run env:start
   ```

### Available Scripts

#### PHP/Composer
```bash
composer run lint        # Run PHP CodeSniffer
composer run format      # Auto-fix code formatting
composer run test        # Run PHPUnit tests
composer run coverage    # Generate test coverage
```

#### JavaScript/NPM
```bash
npm run env:start        # Start WordPress environment
npm run env:stop         # Stop WordPress environment  
npm run test:e2e         # Run Playwright end-to-end tests
npm run test:e2e:headed  # Run Playwright tests in headed mode
npm run playground:build # Build the release ZIP and local Playground bundle
npm run playground:start # Build and open the complete demo locally
npm run playground:test  # Build and smoke-test the complete demo headlessly
```

The Playground commands use PHP 8.2 and the latest stable WordPress. Generated
archives are written to `.cache/playground/` and are ignored by Git.

### Code Standards

This project follows:
- **WordPress Coding Standards** for PHP
- **PSR-2** compliance where applicable
- **@wordpress/eslint-plugin** for JavaScript
- **Prettier** for code formatting

## 📊 Testing

### Unit Tests
PedalCMS uses WordPress core's official PHPUnit mechanism (`WP_UnitTestCase`) via `wordpress-tests-lib`.

```bash
# 1) Install WordPress test suite and core test files.
composer run test:setup

# 2) Run plugin tests against the official WP test bootstrap.
composer run test
```

You can override setup defaults with environment variables:

```bash
WP_TESTS_DB_NAME=pedalcms_test WP_TESTS_DB_USER=root WP_TESTS_DB_PASS=root composer run test:setup
```

```bash
# Run all tests
composer run test

# Run multisite tests
composer run test:multisite

# Generate coverage report
composer run coverage:full
```

### End-to-End Tests

1. Copy `.env.e2e.example` to `.env.e2e` and set credentials.
2. Ensure a WordPress site is running and reachable at `E2E_BASE_URL`.

```bash
npm run test:e2e
```

## 🏗️ Architecture

### Class Structure
```
PedalCMS\Core\
├── CustomPostType          # Base class for post types
├── CustomTaxonomy          # Base class for taxonomies
├── CustomBlock             # Base class for Gutenberg blocks
├── TemplateManager         # Template loading and management
├── SubpageManager          # Program subpage management
└── Plugin                  # Main plugin orchestration
```

### Key Components
- **Custom Post Types**: Program, Course, Person, FAQ
- **Custom Taxonomies**: Program Types, Person Categories, etc.
- **Template System**: Comprehensive template hierarchy
- **CassetteCMF**: Settings pages and custom fields come from the bundled `pedalcms/cassette-cmf` library
- **Block Editor**: Gutenberg block compatibility

## 🎨 Theming

### Theme Integration
PedalCMS is designed to work with any WordPress theme. Include the following in your theme:

1. **Template files** (optional, uses defaults if not present)
2. **Styling** for PedalCMS content types
3. **Template tags** for custom functionality

### CSS Classes
All PedalCMS templates include semantic CSS classes:
```css
.pdlcms                      /* Wrapper around all PedalCMS templates */
.single-program-page-header  /* Program page header */
.program-subnav              /* Program subpage navigation */
.pdl-breadcrumbs             /* Breadcrumb container */
```

## 🤝 Contributing

We welcome contributions! Documentation changes go to the separate docs repository; its *Writing the docs* page explains the style and the build.

### Development Workflow
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and linting
5. Submit a pull request

### Reporting Issues
- Use [GitHub Issues](https://github.com/PedalCMS/pedalcms/issues)
- Provide detailed reproduction steps
- Include WordPress and plugin version information

## 📄 License

This project is licensed under the **GPL-2.0+** License - see the [LICENSE](LICENSE.txt) file for details.

## 🆘 Support

- **Website**: [https://pedalcms.com](https://pedalcms.com)
- **Documentation**: [https://pedalcms.com/docs](https://pedalcms.com/docs)
- **Issues**: [GitHub Issues](https://github.com/PedalCMS/pedalcms/issues)
- **Community**: [WordPress.org Plugin Forum](https://wordpress.org/support/plugin/pedalcms/)

## 🚀 Roadmap

### Upcoming Features
- [ ] REST API enhancements
- [ ] Additional Gutenberg blocks
- [ ] Import/Export functionality
- [ ] Advanced reporting dashboard
- [ ] Multi-language support
- [ ] Integration with learning management systems

### Version History
See [GitHub Releases](https://github.com/PedalCMS/pedalcms/releases) and the changelog in `readme.txt`.

---

**Made with ❤️ for educational institutions by the PedalCMS team**
