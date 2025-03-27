# User Management System

A PHP-based user management system with role-based access control and session tracking.

## Features

- User Authentication
  - Login/Registration system
  - Role-based access control (Admin/Client)
  - Session tracking
  - Password hashing for security

- Admin Dashboard
  - User management (Create, Read, Update, Delete)
  - User status toggle (Active/Inactive)
  - Role management
  - Login history tracking
  - User search and filtering

- User Features
  - Profile management
  - Password update
  - View login history

## Technical Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Web Server
- XAMPP (recommended)

## Installation

1. Clone the repository to your XAMPP htdocs folder
2. Import the database schema from `database.sql`
3. Configure database connection in `config/config.php`
4. Access the application through your web browser

## Database Structure

- Users Table: Stores user information
- Roles Table: Defines user roles
- Sessions Table: Tracks user login/logout activities

## Security Features

- Password Hashing
- Session Management
- Input Validation
- Role-based Access Control
- Status-based Access Control


## Directory Structure

BRIEF3/
├── config/
│   ├── config.php                 # Application configuration
│   └── Database.php              # Database connection class
├── controllers/
│   ├── Admin.php                 # Admin controller
│   ├── Core.php                  # Core controller
│   ├── Pages.php                 # Static pages controller
│   └── Users.php                 # User management controller
├── models/
│   └── User.php                  # User model with database operations
├── views/
│   ├── admin/
│   │   ├── create_user.php       # New user creation form
│   │   ├── edit_user.php         # User edit form
│   │   ├── login_history.php     # Session tracking view
│   │   └── users.php             # User management dashboard
│   ├── users/
│   │   ├── login.php             # Login form
│   │   ├── profile.php           # User profile page
│   │   └── register.php          # Registration form
│   └── inc/
│       ├── header.php            # Common header template
│       └── footer.php            # Common footer template
├── helpers/
│   ├── session_helper.php        # Session management functions
│   └── url_helper.php            # URL handling functions
└── public/
├── css/
│   └── styles.css            # Custom styles
├── js/
│   └── main.js               # Custom JavaScript
├── img/                      # Image assets
└── index.php                 # Application entry point


## Usage

1. Admin Access:
   - Manage users
   - View login history
   - Toggle user status
   - Assign roles

2. User Access:
   - Update profile
   - Change password
   - View personal login history


## License

MIT License

Copyright (c) 2024 User Management System

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


## Technologies Used

- PHP MVC Architecture
- MySQL Database
- Tailwind CSS
- JavaScript
- Apache Server
