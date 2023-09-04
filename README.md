## Simple Weather Forecast App
This is a simple weather forecast application created for a developer coding test.

## Local dependencies
PHP version of 8.1

Alternatively, the dev environment can be run using docker and laravel sail by following the instruction provided in the Laravel documentation. https://laravel.com/docs/10.x/sail#main-content
# Set up
To run the app locally
- Clone the repo 
    - For example, use the command 'git clone git@github.com:Claymost/weather-forecasting-app.git'
- Navigate into the newly created repo folder
- Create an .env file using by copying the example.env
    - eg `cp .env.example > .env`
- Generate an app key with php `php artisan key:generate`
- Add the Weatherbit API key into the environment file under the property `WEATHERBIT_API_KEY=?`
- Install the dependencies (alternatively, you could use sail at this point if you don't have PHP 8.1 locally)
    - `npm install`
    - `composer install`


# Run the application

In order to view the web interface locally, you must:

- In one window, run `npm start dev`
- In another terminal, run `php artisan serve`

Following this, the front end can be accessed. The default address is localhost:8000
