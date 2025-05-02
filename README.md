# Carbon Footprint Tracker - CMSC 207 Final Project

A web application designed to help users understand, measure, and reduce their carbon footprint through tracking, visualization, and actionable recommendations.

## Project Overview

This Carbon Footprint Tracker project was created for CMSC 207 - Web Programming and Development at the University of the Philippines Open University.

The application helps users:

- Track their daily activities that contribute to carbon emissions
- Calculate their carbon footprint using scientific emission factors
- View historical data and progress over time
- Earn achievements and receive personalized recommendations

## Project Structure

The project follows the required submission format:

```
Estopace_Jeryl_CarbonFootprintTracker/
├── carbon-footprint-tracker/       # All PHP and web files
│   ├── app/                        # Laravel application code
│   ├── resources/                  # Views, CSS, JavaScript
│   ├── routes/                     # Route definitions
│   ├── config/                     # Configuration files
│   └── ...                         # Other Laravel directories
├── database/                       # Database files
│   └── carbon_tracker.sql          # SQL export file
├── documentation.pdf               # Project documentation
└── demo.txt                        # Unlisted YouTube link to the demo video
```

## Features

- **User Authentication**: Registration, login, profile management
- **Baseline Assessment**: Measures typical transportation, electricity and waste habits
- **Activity Tracking**: Daily logging of transportation, electricity usage, and waste generation
- **Scientific Calculations**: Based on research from UP Cebu about greenhouse gas emissions
- **Dashboard**: Visual representation of carbon savings and impact
- **Gamification**: Achievements and badges to motivate sustainable choices

## Installation & Setup

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & npm

### Step-by-Step Installation

1. **Open a terminal and navigate to the project folder**:

    ```bash
    cd ~/Desktop/Estopace_Jeryl_CarbonFootprintTracker/carbon-footprint-tracker
    ```

2. **Install PHP dependencies**:

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**:

    ```bash
    npm install
    ```

4. **Configure the environment**:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Set up the database**:

    - Create a MySQL database named `carbon_tracker`:

    ```bash
    mysql -u root -p -e "CREATE DATABASE carbon_tracker"
    ```

    - Import the SQL file from the database folder:

    ```bash
    mysql -u root -p carbon_tracker < ../database/carbon_tracker.sql
    ```

6. **Configure your `.env` file with your database credentials**:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=carbon_tracker
    DB_USERNAME=root or your_username
    DB_PASSWORD= leave empty or your_password
    ```

7. **Build the frontend assets** (required for styles and JavaScript):

    ```bash
    npm run build
    ```

8. **Start the PHP development server**:

    ```bash
    php artisan serve
    ```

9. **Access the application** at <http://localhost:8000>

## Database Setup Details

The `carbon_tracker.sql` file located in the `database/` folder contains all the necessary database structure and initial data for the application:

- Table structures for users, activity logs, baseline assessments, etc.
- Scientific emission factors based on the research paper
- Pre-defined achievements and badges
- Example data (if included)

If you prefer to set up the database manually instead of importing the SQL file, you can use Laravel migrations:

```bash
php artisan migrate
php artisan db:seed --class=EmissionFactorSeeder
```

## Technical Implementation

### Technology Stack

- **Backend**: PHP with Laravel framework
- **Database**: MySQL
- **Frontend**: HTML, CSS (Tailwind CSS), JavaScript
- **Authentication**: Laravel's built-in authentication system

### Scientific Foundation

All carbon footprint calculations are based on emission factors from:

Cortes, A. C. (2022). Greenhouse Gas Emissions Inventory of a University in the Philippines: the Case of UP Cebu. _Philippine Journal of Science, 151_(3), 901-912.

The application uses the formula:

```
CE = AD × EF × GWP₁₀₀
```

Where:

- CE is carbon emission
- AD is activity data (distance traveled, electricity used, etc.)
- EF is the emission factor for that activity
- GWP₁₀₀ is global warming potential

## Demo

A video demonstration of the application can be found at the YouTube link provided in the `demo.txt` file.

## Troubleshooting

- **Database connection issues**: Ensure your MySQL server is running and that the credentials in `.env` are correct
- **Composer errors**: Make sure you're using PHP 8.1+ and that all required PHP extensions are enabled
- **JavaScript/CSS not updating**: Try `npm run dev` to rebuild assets during development

## Credits

Developed by: Jeryl Estopace  
LinkedIn: <https://www.linkedin.com/in/jeryldev/>

Scientific basis:  
Cortes, A. C. (2022). Greenhouse Gas Emissions Inventory of a University in the Philippines: the Case of UP Cebu. _Philippine Journal of Science, 151_(3), 901-912.

## License

[MIT License](LICENSE)
