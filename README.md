# Bibliotheca - Library Management System

A modern library management system built with Laravel, allowing librarians and users to manage books, borrowings, and returns efficiently.

## Features

- **User Management**
  - Role-based access control (Admin and User roles)
  - User authentication and authorization
  - User profile management

- **Book Management**
  - Complete CRUD operations for books
  - Book categorization
  - Book availability status tracking
  - Search books by title or author
  - Filter books by category and status

- **Category Management**
  - Organize books by categories
  - Full CRUD operations for categories (Admin only)
  - View books count per category

- **Borrowing System**
  - Borrow books with automatic due date calculation
  - Return book functionality
  - Overdue tracking
  - Borrowing history
  - Current borrows tracking

- **Reporting**
  - Most borrowed books analytics
  - Most active users tracking
  - Available and borrowed books statistics
  - Overdue borrows monitoring

## Technical Requirements

- PHP >= 8.1
- MySQL Database
- Composer
- Node.js & NPM

## Installation

1. Clone the repository
```bash
git clone [repository-url]
cd bibliotheca
```

2. Install PHP dependencies
```bash
composer install
```

3. Install Node.js dependencies
```bash
npm install
```

4. Create and configure environment file
```bash
cp .env.example .env
```

5. Configure your database in the .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliotheca
DB_USERNAME=[your-username]
DB_PASSWORD=[your-password]
```

6. Generate application key
```bash
php artisan key:generate
```

7. Run database migrations and seeders
```bash
php artisan migrate --seed
```

8. Build assets
```bash
npm run dev
```

9. Start the development server
```bash
php artisan serve
```

## Default Users

After seeding, you can log in with these default accounts:

- **Admin Account**
  - Email: admin@example.com
  - Password: password

- **User Account**
  - Email: user@example.com
  - Password: password

## Database Structure

- **Users**: Stores user information and roles
- **Books**: Contains book details including title, author, and availability status
- **Categories**: Manages book categories
- **Borrows**: Tracks book borrowing records including borrow dates and return status

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email [your-email] instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
