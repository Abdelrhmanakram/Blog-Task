# Blog-Task

This project is a simple blog application built with Laravel and Vite. Follow the instructions below to set up the project locally.

## Setup Instructions

### 1. Clone the Repository

Clone the repository using the following command:

```bash
git clone https://github.com/Abdelrhmanakram/Blog-Task.git

Navigate into the project directory:
cd Blog-Task

Copy the Environment File

Copy the .env.example file to create a new .env file:
cp .env.example .env

Generate the Application Key
Generate a new application key:
php artisan key:generate

Set Up the Database
Create a new database for the application. Update the .env file with the name of your database in the DB_DATABASE variable:
DB_DATABASE=your_database_name

Run Migrations
Run the migrations to set up the database schema:
php artisan migrate

Install JavaScript Dependencies
Install JavaScript dependencies using npm:
npm install

Build Assets
Build the frontend assets:
npm run build

Start the Development Server
Start the Laravel development server:
php artisan serve

Register and Test
    Register an account on the application.
    To test email notifications when a comment is added to a post, configure Mailtrap:
        Sign in to Mailtrap.
        Create a new inbox.
        Choose "PHP Laravel +9" from the SMTP settings.
        Copy the SMTP settings and update your .env file with the Mailtrap configuration:
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="${APP_NAME}"

Enjoy!

You’re all set up. Have fun exploring and developing the blog application!
