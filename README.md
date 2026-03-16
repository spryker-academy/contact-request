# Spryker Academy - ContactRequest Training Module

[![Latest Version](https://img.shields.io/github/v/tag/spryker-academy/contact-request?label=version)](https://github.com/spryker-academy/contact-request/tags)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Learn Spryker fundamentals through progressive exercises building a complete ContactRequest module across all application layers.

## 📚 What You'll Learn

This training module covers the essential Spryker concepts through 4 progressive exercises:

1. **Hello World Back Office** - Create your first Zed controller and view
2. **Data Transfer Objects** - Implement type-safe data handling with Transfer objects
3. **Message Table Schema** - Work with Propel ORM and database schemas
4. **Module Layers** - Build a complete module with Client, Zed, and Yves layers

## 🎯 Prerequisites

- PHP 8.4 or higher
- Spryker project (B2B/B2C Demo Shop or Suite)
- Basic understanding of MVC architecture
- Docker environment

## 📦 Installation

### Install Specific Training Version

```bash
# Start with the skeleton version for hands-on learning
composer require spryker-academy/contact-request:1.0.0-skeleton

# Or install complete version to see the solution
composer require spryker-academy/contact-request:1.0.0-complete
```

### Install from Branch (Alternative)

```bash
# Install specific training branch
composer require spryker-academy/contact-request:dev-ilt/202512.0/basics/contact-request-back-office/skeleton
```

## 🚀 Training Progression

### Module 1: Hello World Back Office (v1.0)

**What You'll Build:**
- Zed controller with index action
- Twig template with Back Office layout
- Navigation menu integration

**Install:**
```bash
composer require spryker-academy/contact-request:1.0.0-skeleton
```

**Access:**
```
http://backoffice.eu.spryker.local/contact-request
```

### Module 2: Data Transfer Objects (v2.0)

**What You'll Build:**
- Transfer object definitions (XML)
- Type-safe data passing between layers
- Client-Zed gateway communication

**Install:**
```bash
composer require spryker-academy/contact-request:2.0.0-skeleton
```

### Module 3: Message Table Schema (v3.0)

**What You'll Build:**
- Propel schema definition
- Database table with columns and behaviors
- Entity and query classes generation

**Install:**
```bash
composer require spryker-academy/contact-request:3.0.0-skeleton
```

### Module 4: Module Layers (v4.0)

**What You'll Build:**
- Complete Business layer (Facade, Factory, Reader, Writer)
- Persistence layer (Repository, EntityManager, Mapper)
- Client layer with stub
- Yves integration with controllers and views

**Install:**
```bash
composer require spryker-academy/contact-request:4.0.0-skeleton
```

## ⚙️ Configuration

### 1. Register SprykerAcademy Namespace

Add to `config/Shared/config_default.php`:

```php
<?php

use Spryker\Shared\Kernel\KernelConstants;

$config[KernelConstants::CORE_NAMESPACES] = [
    'SprykerShop',
    'SprykerEco',
    'Spryker',
    'SprykerSdk',
    'SprykerAcademy', // Add this line
];
```

### 2. Run Code Generation

```bash
# Generate transfer objects
vendor/bin/console transfer:generate

# Generate Propel models (Module 3+)
vendor/bin/console propel:install

# Build navigation (Module 1+)
vendor/bin/console navigation:build-cache
```

## 📖 Usage

### Check Your Branch/Version

```bash
composer show spryker-academy/contact-request
```

### Switch Between Skeleton and Complete

```bash
# Switch to complete version to check your solution
composer require spryker-academy/contact-request:1.0.0-complete

# Go back to skeleton to practice
composer require spryker-academy/contact-request:1.0.0-skeleton
```

### Upgrade to Next Module

```bash
# After completing Module 1, move to Module 2
composer require spryker-academy/contact-request:2.0.0-skeleton
```

## 🏗️ Module Structure

```
src/SprykerAcademy/
├── Zed/ContactRequest/              # Back Office (Zed) layer
│   ├── Business/                # Business logic
│   ├── Communication/           # Controllers, Forms, Tables
│   ├── Persistence/             # Database access
│   └── Presentation/            # Twig templates
├── Client/ContactRequest/           # Client layer (Zed-Yves gateway)
│   └── Stub/                    # RPC communication
├── Yves/ContactRequestPage/         # Storefront (Yves) layer
│   ├── Controller/              # Frontend controllers
│   ├── Plugin/                  # Route providers
│   └── Theme/                   # Frontend templates
└── Shared/ContactRequest/           # Shared code
    └── Transfer/                # Transfer object definitions
```

## 🎓 Learning Path

1. **Start with Skeleton** - Install v1.0-skeleton and follow TODOs in the code
2. **Complete the Exercise** - Implement the functionality based on hints
3. **Verify Your Work** - Test your implementation
4. **Compare with Complete** - Install v1.0-complete to see the solution
5. **Move to Next Module** - Progress to v2.0-skeleton

## 📚 Additional Resources

- [Spryker Documentation](https://docs.spryker.com)
- [Spryker Academy](https://academy.spryker.com)
- [Training Manual](../../docs/training/SPRYKER_TRAINING_MANUAL.md)
- [Student Exercise Guide](../../docs/training/STUDENT_EXERCISE_GUIDE.md)

## 🤝 Contributing

This is a training module. For issues or improvements, please contact Spryker Academy.

## 📄 License

MIT License - See [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Documentation**: Check the training manual in your main project
- **Issues**: Report problems via GitHub issues
- **Community**: Join Spryker Community Slack

---

**Happy Learning! 🚀**
