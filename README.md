# PedalCMS

[![Version](https://img.shields.io/badge/version-0.3.0-blue.svg)](https://github.com/PedalCMS/pedalcms)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![WordPress](https://img.shields.io/badge/WordPress-5.6%2B-blue.svg)](https://wordpress.org)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

A comprehensive WordPress plugin designed as a **program marketing powerhouse** for educational institutions. PedalCMS provides a complete content management system for academic programs, courses, faculty, and student information.

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
- **WordPress**: 5.6 or higher
- **PHP**: 8.2 or higher
- **MySQL**: 5.6 or higher
- **Advanced Custom Fields (ACF)**: Required for full functionality

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

## 🎨 Template System

PedalCMS includes a complete template system for displaying content:

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
| Programs | Academic programs and degrees | `pdl_program` |
| Courses | Individual courses and classes | `pdl_course` |
| People | Faculty, staff, and personnel | `pdl_person` |
| FAQs | Frequently asked questions | `pdl_faq` |

## 🏷️ Taxonomies

| Taxonomy | Description | Used For |
|----------|-------------|----------|
| Program Types | Categories of programs | Programs |
| Person Categories | Faculty/staff classifications | People |
| Colleges | Institutional divisions | Programs, Courses, People |
| Departments | Academic departments | Programs, Courses, People |
| Subjects | Academic subjects | Courses |
| FAQ Categories | FAQ organization | FAQs |
| Instruction Modes | Delivery methods | Programs, Courses |

## 🎛️ Template Tags

PedalCMS provides numerous template tags for theme development:

### Program Functions
```php
pdl_program_title()          // Get program title
pdl_program_subpages()       // Get program subpages
pdl_get_the_term_list()      // Get formatted taxonomy terms
```

### Course Functions
```php
pdl_course_prerequisites()   // Get course prerequisites
pdl_course_schedule()        // Get course schedule
```

### Person Functions
```php
pdl_person_contact_info()    // Get contact information
pdl_person_job_title()       // Get job title
```

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
- **ACF Integration**: Advanced Custom Fields support
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
.program-header          /* Program page headers */
.course-info            /* Course information blocks */
.person-profile         /* Person profile containers */
.faq-item              /* Individual FAQ items */
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

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

This project is licensed under the **GPL-2.0+** License - see the [LICENSE](gpl-3.txt) file for details.

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
- **0.3.0** - Current version with enhanced template system
- **0.2.0** - Added custom blocks and improved ACF integration
- **0.1.0** - Initial release with core post types and taxonomies

---

**Made with ❤️ for educational institutions by the PedalCMS team**
