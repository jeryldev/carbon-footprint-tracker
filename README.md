# Carbon Footprint Tracker

A web application designed to help users understand, measure, and reduce their carbon footprint through tracking, visualization, and gamification.

## Project Overview

This Carbon Footprint Tracker project was created for CMSC 207 - Web Programming and Development at the University of the Philippines Open University. The application transforms complex carbon footprint calculations into an engaging user experience that promotes sustainable behavior.

The application helps users:

- Track their daily activities that contribute to carbon emissions
- Calculate their carbon footprint using scientific emission factors
- Visualize their progress and environmental impact
- Earn achievements for sustainable choices

## Features

- **User Authentication**: Complete registration and login system with profile management
- **Baseline Assessment**: Establishes users' typical carbon-producing habits as a reference point
- **Activity Tracking**: Daily logging of transportation, electricity usage, and waste generation
- **Dashboard**: Visual representation of carbon savings with relatable metrics (tree days, car kilometers)
- **Personalized Recommendations**: Smart suggestion system that provides tailored eco-tips based on user activity patterns, prominently displayed in the dashboard
- **Achievement System**: Gamification elements to motivate eco-friendly choices
- **Knowledge Base**: Educational content about carbon footprints and calculation methodologies

## Technology Stack

- **Backend**: PHP 8.1+ with Laravel framework
- **Database**: MySQL
- **Frontend**: HTML, CSS (Tailwind CSS), JavaScript (Alpine.js)
- **Authentication**: Laravel's built-in authentication system

## Installation & Setup

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & npm

### Installation Steps

1. **Clone the repository**:

    ```bash
    git clone https://github.com/jeryldev/carbon-footprint-tracker.git
    cd carbon-footprint-tracker
    ```

2. **Install PHP dependencies**:

    ```bash
    composer install
    ```

3. **Install JavaScript dependencies**:

    ```bash
    npm install
    ```

4. **Configure environment**:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Set up the database**:

    ```bash
    # Create a database in MySQL
    mysql -u root -p -e "CREATE DATABASE carbon_tracker"

    # Run migrations and seed data
    php artisan migrate
    php artisan db:seed
    ```

6. **Configure database in .env**:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=carbon_tracker
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. **Build frontend assets**:

    ```bash
    npm run build
    ```

8. **Start the development server**:

    ```bash
    php artisan serve
    ```

9. **Access the application** at <http://localhost:8000>

## Scientific Foundation

All carbon footprint calculations are based on emission factors from research by Aiza C. Cortes at the University of the Philippines Cebu. The application implements the formula:

```
CE = AD × EF × GWP₁₀₀
```

Where:

- CE is carbon emission
- AD is activity data (distance traveled, electricity used, etc.)
- EF is the emission factor for that activity
- GWP₁₀₀ is global warming potential

## Troubleshooting

- **Database connection issues**: Ensure your MySQL server is running and credentials are correct
- **Composer errors**: Verify you're using PHP 8.1+ with required extensions
- **JavaScript/CSS not updating**: Run `npm run dev` to rebuild assets during development

## Credits

Developed by: Jeryl Estopace  
LinkedIn: <https://www.linkedin.com/in/jeryldev/>

Scientific basis:  
Cortes, A. C. (2022). Greenhouse Gas Emissions Inventory of a University in the Philippines: the Case of UP Cebu. _Philippine Journal of Science, 151_(3), 901-912.

## License

[MIT License](LICENSE)
