# LaravelRosterAdmin

## Efficiently manage sports teams and players with ease.

## Overview
LaravelRosterAdmin is a web-based application designed specifically for managing sports teams and players. The application is implemented using Laravel, adhering to the MVC (Model-View-Controller) architecture, and utilizes Eloquent ORM for database interactions.

## Features
- **User Authentication**: Secure login and user management.
- **Team Management**: Add, edit, remove, and view teams.
- **Player Management**: Add, edit, remove, and view players.
- **Responsive Design**: User-friendly interface with CSS styling.

## Requirements
- PHP 7.4 or higher
- Composer
- MySQL or MariaDB
- Web server (e.g., Apache, Nginx)


## Installation
1. **Clone the repository**:
   ```sh
   git clone https://github.com/yourusername/BioLabSuppliesInventory.git
   cd BioLabSuppliesInventory
   ```

2. **Install dependencies**:
   ```sh
    composer install
    ```

3. **Set up the database**:

- Create a new MySQL database.
- Import the SQL schema:
   ```sh
   mysql -u yourusername -p yourpassword yourdatabase < sql/ecommerce.sql
   ```

4. **Configure the application**:

- Copy config.example.php to config.php and update the database credentials and other configuration settings.

- Generate the application key:
   ```sh
    php artisan key:generate
    ```


5. **Run the migrations and seeders**:


    ```sh
    php artisan key:generate
    ```

6. **Run the application**:

Start your web server and navigate to the application's root directory:
   ```sh
    php artisan serve
    ```