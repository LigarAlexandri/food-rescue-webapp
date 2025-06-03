## GitHub Repository Description (Short)

A web application built with Laravel to connect small food vendors with surplus food to individuals in need, aiming to reduce food waste and support the local community.

Made as Final project for ASOSEK (Aspek Sosial dan Perangkat Lunak) Class

---

## Food Rescue App - Documentation (for README.md)

# Food Rescue Platform

## Overview

The Food Rescue Platform is a web application designed to bridge the gap between small food vendors with excess, perishable food and individuals or organizations that can utilize this surplus. The primary goals are to reduce food waste at the local level and provide a resource for those facing food insecurity. Vendors can easily list available food items, and recipients can browse and claim these items for pickup.

## Features

* **User Roles:**
    * **Vendor:** Can register, list surplus food items, manage their listings (edit, delete, update status), and view items claimed from them.
    * **Recipient:** Can register, browse available food items from various vendors, view item details, and claim items for pickup.
    * **Admin (Basic):** A basic admin role is seeded for potential future administrative functionalities.
* **Vendor Functionality:**
    * Secure registration and login.
    * Dashboard to view and manage listed food items.
    * Form to easily add new food items with details like name, description, quantity, pickup location, pickup time window, and optional image.
    * Ability to edit existing listings.
    * Ability to delete listings.
    * Ability to update the status of a food item (e.g., to 'completed' after pickup, 'unavailable').
* **Recipient Functionality:**
    * Secure registration and login.
    * Dashboard to browse all currently available food items.
    * View detailed information for each food item, including vendor details and pickup instructions.
    * Ability to "claim" an available food item.
    * View a list of items they have personally claimed.
* **Email Verification:** New user registrations require email verification.

## Technology Stack

* **Backend:** Laravel (PHP Framework)
* **Frontend:** Blade (Laravel's Templating Engine), Tailwind CSS, Alpine.js (via Laravel Breeze)
* **Database:** MySQL / PostgreSQL (configurable in `.env`)
* **Authentication:** Laravel Breeze
* **Asset Bundling:** Vite
* **Development Email Testing:** Configured for Mailpit (can be changed to `log` or other services in `.env`)

## Setup and Installation

Follow these steps to get the application running locally:

1.  **Prerequisites:**
    * PHP (>= 8.1 recommended)
    * Composer
    * Node.js & npm
    * A database server (MySQL or PostgreSQL)

2.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/YOUR_USERNAME/YOUR_REPOSITORY_NAME.git](https://github.com/YOUR_USERNAME/YOUR_REPOSITORY_NAME.git)
    cd YOUR_REPOSITORY_NAME
    ```

3.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

4.  **Install JavaScript Dependencies:**
    ```bash
    npm install
    ```

5.  **Environment Configuration:**
    * Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    * Generate an application key:
        ```bash
        php artisan key:generate
        ```
    * Open the `.env` file and configure your database connection details (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.).
    * Configure your `MAIL_MAILER` settings. For local development without a mail server, you can set `MAIL_MAILER=log` to write emails to the Laravel log file. If using Mailpit, ensure `MAIL_HOST=mailpit` (or `127.0.0.1`) and `MAIL_PORT=1025`.

6.  **Database Migration:**
    * Ensure your database is created.
    * Run the migrations to create the necessary tables:
        ```bash
        php artisan migrate
        ```

7.  **Database Seeding (Optional but Recommended for Testing):**
    * This will populate the database with sample users (vendors, recipients, admin) and food items.
        ```bash
        php artisan db:seed
        ```

8.  **Storage Link:**
    * To make uploaded images publicly accessible, create the symbolic link:
        ```bash
        php artisan storage:link
        ```

9.  **Compile Frontend Assets:**
    * For development (with hot module replacement):
        ```bash
        npm run dev
        ```
    * For production:
        ```bash
        npm run build
        ```

10. **Serve the Application:**
    ```bash
    php artisan serve
    ```
    The application will typically be available at `http://127.0.0.1:8000`.

## Usage

1.  **Registration:**
    * Navigate to the registration page.
    * Fill in your details. You will need to select a role (Vendor or Recipient) during registration (Note: The current Breeze registration form might need modification to include a role selector; otherwise, roles are set by the seeder or need manual DB adjustment for initial testing if not using seeders).
    * Verify your email address by clicking the link sent to your email (or found in `storage/logs/laravel.log` if `MAIL_MAILER=log`).

2.  **Test Users (if seeded):**
    * **Vendor 1:** `vendor1@example.com` / `password`
    * **Vendor 2:** `vendor2@example.com` / `password`
    * **Recipient 1:** `recipient1@example.com` / `password`
    * **Recipient 2:** `recipient2@example.com` / `password`
    * **Admin:** `admin@example.com` / `password`

3.  **Vendor Actions:**
    * Log in as a vendor.
    * From the Vendor Dashboard, click "List New Food Item".
    * Fill out the form and submit.
    * Manage existing items from the dashboard (edit, delete, update status).

4.  **Recipient Actions:**
    * Log in as a recipient.
    * The Recipient Dashboard will show available food items.
    * Click "View Details & Claim" on an item.
    * On the item detail page, click "Claim This Item".
    * View your claimed items under "My Claims".

## Contributing

Contributions are welcome! Please feel free to fork the repository, make changes, and submit a pull request. For major changes, please open an issue first to discuss what you would like to change.

## License

(Specify your license here, e.g., MIT License. If you don't have one yet, you can add it later.)

This project is open-sourced software licensed under the [MIT license](LICENSE.md).
