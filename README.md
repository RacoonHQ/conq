# Laravel Conq

A modern Laravel application built for team collaboration and development.

## Project Description

Laravel Conq is a web application framework built on top of Laravel 12, designed to provide a robust foundation for developing scalable and maintainable web applications. This project includes:

- **Modern Framework**: Built with Laravel 12 and PHP 8.2+
- **AI Integration**: Includes AI service integration for intelligent features
- **Conversation System**: Built-in conversation and chat functionality
- **User Management**: Complete user authentication and authorization system
- **Development Tools**: Pre-configured development environment with hot reload
- **Testing Suite**: Comprehensive testing setup with PHPUnit

### Key Features

- RESTful API design
- Database migrations and seeding
- Queue system for background processing
- Real-time logging and monitoring
- Frontend asset compilation with Vite
- Code formatting with Laravel Pint

## Setup Instructions

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- Database (MySQL, PostgreSQL, or SQLite)

### Quick Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-conq
   ```

2. **Run the automated setup script**
   ```bash
   composer run setup
   ```
   
   This script will:
   - Install PHP dependencies
   - Copy environment file
   - Generate application key
   - Run database migrations
   - Install and build frontend assets

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Update your `.env` file with:
   - Database credentials
   - Mail configuration
   - Other service credentials

4. **Start development server**
   ```bash
   composer run dev
   ```
   
   This will start:
   - Laravel development server (http://localhost:8000)
   - Queue worker
   - Log monitoring
   - Vite asset compilation

### Manual Setup

If you prefer manual setup:

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve
```

## Git Contribution Guidelines

### Branch Naming Convention

- `feature/feature-name` - New features
- `bugfix/bug-description` - Bug fixes
- `hotfix/critical-fix` - Critical production fixes
- `refactor/code-improvement` - Code refactoring
- `docs/documentation-update` - Documentation updates

### Commit Message Format

Follow the [Conventional Commits](https://www.conventionalcommits.org/) specification:

```
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation
- `style`: Code style changes
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

Examples:
```
feat(auth): add two-factor authentication
fix(api): resolve user profile endpoint error
docs(readme): update setup instructions
```

### Pull Request Process

1. **Create a feature branch** from `main`
2. **Make your changes** following coding standards
3. **Run tests** to ensure everything works
4. **Commit your changes** with proper commit messages
5. **Push to your fork** and create a Pull Request
6. **Wait for code review** and address feedback

### Code Quality Standards

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Run `composer run test` before submitting
- Use `vendor/bin/pint` for code formatting
- Write tests for new features
- Keep methods small and focused

## Development Workflow

### Daily Development

1. **Start development environment**
   ```bash
   composer run dev
   ```

2. **Make changes** to your code
3. **Run tests** frequently
   ```bash
   composer run test
   ```

4. **Format code**
   ```bash
   vendor/bin/pint
   ```

### Available Scripts

- `composer run setup` - Full project setup
- `composer run dev` - Start development environment
- `composer run test` - Run test suite
- `npm run dev` - Start asset compilation
- `npm run build` - Build production assets

### Database Management

```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback migration
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestName

# Generate test coverage
php artisan test --coverage
```

## Cara untuk Team Contribute

### Untuk Tim Developer

#### 1. Persiapan Awal

- **Install tools yang dibutuhkan**:
  - PHP 8.2+
  - Composer
  - Node.js
  - Git
  - IDE/Editor (VS Code, PhpStorm, dll)

- **Setup repository**:
  ```bash
  git clone <repository-url>
  cd laravel-conq
  composer run setup
  ```

#### 2. Alur Kerja Development

1. **Ambil task dari project management** (Jira, Trello, dll)
2. **Buat branch baru**:
   ```bash
   git checkout -b feature/nama-feature
   ```
3. **Develop sesuai requirement**
4. **Test secara lokal**:
   ```bash
   composer run test
   ```
5. **Commit dengan format yang benar**:
   ```bash
   git add .
   git commit -m "feat(module): tambahkan fitur baru"
   ```
6. **Push dan buat Pull Request**

#### 3. Code Review Process

- **Setiap PR harus di-review** oleh minimal 1 team member
- **Checklist review**:
  - Code follows PSR-12 standards
  - Tests are included and passing
  - Documentation is updated
  - No hardcoded values
  - Security considerations addressed

#### 4. Deployment

- **Development**: Auto-deploy ke development server setiap merge ke `develop`
- **Staging**: Manual deploy ke staging setelah approval
- **Production**: Manual deploy ke production dengan schedule

### Untuk Tim QA

#### 1. Testing Process

- **Unit Testing**: Developer responsibility
- **Integration Testing**: QA team verification
- **User Acceptance Testing**: Business user validation

#### 2. Bug Reporting

Gunakan format berikut untuk bug report:

```
**Title**: [Bug Type] - Brief Description
**Environment**: Development/Staging/Production
**Browser**: Chrome/Firefox/Safari
**Steps to Reproduce**:
1. Step 1
2. Step 2
3. Step 3
**Expected Result**: What should happen
**Actual Result**: What actually happened
**Screenshots**: [Attach if applicable]
```

### Untuk Tim Product/Designer

#### 1. Design Integration

- **Design files** disimpan di shared folder (Figma, Adobe XD)
- **Component library** menggunakan Blade components
- **CSS framework**: Tailwind CSS

#### 2. Content Management

- **Static content**: Edit di language files (`resources/lang`)
- **Dynamic content**: Manage melalui admin panel
- **Images**: Upload melalui media manager

### Communication Guidelines

#### 1. Daily Standup

- **Time**: Setiap hari pukul 09:00
- **Format**: What did yesterday, What today, Any blockers
- **Duration**: Max 15 menit

#### 2. Sprint Planning

- **Frequency**: Setiap 2 minggu
- **Participants**: Seluruh development team
- **Output**: Sprint backlog dengan task breakdown

#### 3. Retrospective

- **Frequency**: Akhir setiap sprint
- **Focus**: Process improvement
- **Action items**: Documented dan tracked

### Best Practices

#### 1. Code Quality

- **Follow PSR-12** coding standards
- **Write tests** untuk semua fitur baru
- **Use type hints** untuk parameter dan return values
- **Keep methods small** dan focused

#### 2. Security

- **Validate all input** data
- **Use prepared statements** untuk database queries
- **Implement proper authentication** dan authorization
- **Keep dependencies updated**

#### 3. Performance

- **Use caching** untuk data yang sering diakses
- **Optimize database queries**
- **Implement lazy loading** untuk relationships
- **Monitor application performance**

## Support

For questions or support:
- Create an issue in the repository
- Contact the development team
- Check the Laravel documentation at [https://laravel.com/docs](https://laravel.com/docs)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
