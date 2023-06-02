## Simple Weather Forecast App - R6

This is a simple weather forecast application created for the r6 php developer coding test.

## Local dependencies
PHP version of 8.1

Alternatively, the dev environment can be run using docker and laravel sail by following the instruction provided in the Laravel documentation. https://laravel.com/docs/10.x/sail#main-content
# Set up
To run the app locally
- Clone the repo 
    - For example, use the command 'git clone git@github.com:Claymost/r6weatherforecast.git'
- Navigate into the newly created repo folder
- Create an .env file using by copying the example.env
    - eg `cp .env.example > .env`
- Generate an app key with php `php artisan key:generate`
- Add the API key into the environment file under the property `WEATHERBIT_API_KEY=?`
- Install the dependencies
    - `npm install`
    - `composer install`


## Run the application

In order to view the web interface locally, you must:

- Run the application
    - In one window, run `npm start dev`
    - In another terminal, run `php artisan serve`

Following this, the front end can be accessed.

## TEST: Assumptions and decisions

- As the information is not sensitive and there was no specifications regarding authentication, there is no authentication required to access the app.

- Weatherbit was selected as the API source as it seemed to best fulfill the requirements of the app.

- Given the limited use case of the api and the limit on time, the weatherbit API service has not been constructed in a way to allow for dependency injection and sophisticated testing, though it was a consideration.

- In its current state, it is assumed the Weatherbit API is linked to a freeplan account. In order to avoid maxing out the api request limit, caching has been implemented on a per city basis with a 2 hour cache timer. The forecast on Weatherbit is updated hourly, meaning it won't always be totally accurate. In a commercial setting on a paid plan this cache timer could be reduced.

- The free plan is also not allowed to be used in a commercial setting.

- No city name validation exists. The user can enter whichever location names they like into the forecast command. The description advises removing or replacing white spaces to avoid mistakes in retrieval.



