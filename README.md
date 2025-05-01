# Carbon Footprint Tracker

A web application designed to help users understand, measure, and reduce their carbon footprint through tracking, visualization, and actionable recommendations.

## Project Overview

This application helps users:

- Track their daily activities that contribute to carbon emissions
- Calculate their carbon footprint using scientific emission factors
- View historical data and progress over time
- Receive personalized recommendations for reducing their environmental impact

## Features

- User authentication and registration
- Baseline carbon footprint assessment
- Daily activity tracking (transportation, electricity, waste)
- Carbon calculations based on the UP Cebu research study
- Dashboard with carbon footprint visualization
- Personalized recommendations for reducing emissions

## Setup Instructions

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL or SQLite

### Installation

1. Clone the repository

    ```bash
    git clone https://github.com/jeryldev/carbon-footprint-tracker.git
    cd carbon-footprint-tracker
    ```

2. Install PHP dependencies

    ```bash
    composer install
    ```

3. Install JavaScript dependencies

    ```bash
    npm install
    ```

4. Create a copy of the environment file

    ```bash
    cp .env.example .env
    ```

5. Generate an application key

    ```bash
    php artisan key:generate
    ```

6. Configure the database in `.env`

    ```
    # For MySQL
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=carbon_tracker
    DB_USERNAME=root
    DB_PASSWORD=your_password  # Replace with your actual MySQL password if you have one

    # Or for SQLite (simpler setup)
    # DB_CONNECTION=sqlite
    # (Then create an empty database.sqlite file in the database directory)
    # touch database/database.sqlite
    ```

    **Important:** Make sure to set the correct password for your MySQL installation in the `DB_PASSWORD` field. If your local MySQL instance requires a password and it's not correctly specified in the `.env` file, you'll encounter connection errors.

7. Run migrations

    ```bash
    php artisan migrate
    ```

8. Seed the emission factors data

    ```bash
    php artisan db:seed --class=EmissionFactorsSeeder
    ```

9. Build assets

    ```bash
    npm run dev
    ```

10. Start the development server

    ```bash
    php artisan serve
    ```

The application will be available at <http://localhost:8000>

## Development

### Running the Development Server

```bash
# Terminal 1: Start the Laravel server
php artisan serve

# Terminal 2: Watch for frontend changes
npm run dev
```

### Database Structure

The application uses the following main tables:

- `users` - User account information
- `baseline_assessments` - User's initial carbon footprint data
- `activity_logs` - Daily tracking of user activities
- `emission_factors` - Scientific emission conversion values

## Credits

This project uses emission factors from the following research paper:

Cortes, A. C. (2022). Greenhouse Gas Emissions Inventory of a University in the Philippines: the Case of UP Cebu. _Philippine Journal of Science, 151_(3), 901-912. <https://doi.org/10.56899/151.03.10>

The emission factors derived from this study form the scientific foundation for our carbon footprint calculations.

## License

[MIT License](LICENSE)
