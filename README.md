# Blog App

This is a simple CRUD (Create, Read, Update, Delete) system for blog posts. Users can register, log in, log out, create, view, update, and delete blog posts. The system includes a text editor using Summernote, which allows users to create visually appealing and engaging blog content. Blog post creation and updates are facilitated through Bootstrap modals, and all functions are implemented using AJAX requests.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)


## Prerequisites


- PHP 7.4
- Composer
- MySQL
- GIT

## Getting Started


1. **Clone the repository:**

   ```bash
   git clone https://github.com/nasma321/blog-app.git
2. **Navigate to the project directory:**

   ```bash
   cd blog-app
3. **Install dependencies:**

   ```bash
   composer install
4. **Configuration:**

    - Create a copy of the .env.example file and save it as .env. 
    - Update the .env file with your environment-specific settings.
    - Generate an application key:
    
    ```bash
    php artisan key:generate
    ```

    - Migrate and seed the database:

    ```bash
    php artisan migrate
    ```

5. **tart the development server:**

    ```bash
    php artisan serve
    ```


