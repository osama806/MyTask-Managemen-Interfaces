# MyTask Management Interfaces

The **MyTask Management Interfaces** is a web service built with PHP and MySQL that allows users to manage tasks by blade template engine

## Table of Contents

-   [MyTask Management Interfaces](#my-task-management-interfaces)
    -   [Table of Contents](#table-of-contents)
    -   [Features](#features)
    -   [Getting Started](#getting-started)
        -   [Prerequisites](#prerequisites)
        -   [Installation](#installation)
        -   [Cronjob Explaning](#cronjob-explaning)

## Features

1. Authorization

-   Registration for new user
-   Login user
-   Logout user

2. Task

-   Create new task
-   Update task info by owner
-   Display one or more taks through interface
-   Delete task by owner
-   Change task status from pending to completed

3. Cron Job

-   Execute command to send email for users that have tasks in pending status at daily

## Getting Started

These instructions will help you set up and run the MyTask Management Interfaces on your local machine for development and testing purposes.

### Prerequisites

-   **PHP** (version 7.4 or later)
-   **MySQL** (version 5.7 or later)
-   **Apache** or **Nginx** web server
-   **Composer** (PHP dependency manager, if you are using any PHP libraries)

### Installation

1. **Clone the repository**:

    ```
    git clone https://github.com/osama806/MyTask-Managemen-Interfaces.git
    cd MyTask-Managemen-Interfaces
    ```

2. **Set up the environment variables:**:

Create a .env file in the root directory and add your database configuration:

```
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=blade-task
DB_USERNAME=root
DB_PASSWORD=password
```

3. **Set up the MySQL database:**:

-   Create a new database in MySQL:
    ```
    CREATE DATABASE blade-task;
    ```
-   Run the provided SQL script to create the necessary tables:
    ```
    mysql -u root -p blade-task < database/schema.sql
    ```

4. **Configure the server**:

-   Ensure your web server (Apache or Nginx) is configured to serve PHP files.
-   Place the project in the appropriate directory (e.g., /var/www/html for Apache on Linux).

5. **Install dependencies (if using Composer)**:

```
composer install
```

6. **Start the server:**:

-   For Apache or Nginx, ensure the server is running.
-   The API will be accessible at http://localhost/blade-task.

### Cronjob Explaning

1.  create command
```
php artisan make:command SendDailyPendingTasksEmail
```

2.  edit handle function in command file

3.  create mail
```
php artisan make:mail SendEmail
```

4.  edit function build in mail file

5.  create view page to be mail template 

6.  set config Queue to send mails through it

7.  start queue 
```
php artisan queue:work
```

8.  start schedule
```
php artisan schedule:work
```
