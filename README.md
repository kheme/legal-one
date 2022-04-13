# Legal One Assessment

A simple Symfony 6 application, Dockerized.

## Contributors

-   [Okiemute Omuta](mailto:omuta.okiemute@gmail.com)

## Project Requirements

-  Nginx
-  MariaDB 8.0.10 or higher
-  PHP 8.0.2 or higher
-  Symfony 6.0
-  Docker

## Project Setup

<!-- #### Database Setup

-   Create a new MySQL database user with username = `legal-one` and password = `legal-one` -->

<!-- ##### Testing Database Setup

-   Create a new MySQL database called `bhr_test`
-   Create a new MySQL database user with username = `bhr_test` and password = `bhr_test`
-   Grant the new MySQL database user (`bhr_test`) full privileges to the `bhr_testbhr_test` database -->

#### Project Initialization and Configuration

-   In your localhost root folder, launch a new terminal window and run the following commands:
-   `git clone https://github.com/kheme/legal-one.git`
-   `cd legal-one`
-   `cp .env.example .env` *- Don't forget to set your variables here*
-   `composer install`
-   `php bin/console doctrine:database:create`
-   `doctrine:migrations:sync-metadata-storage`
-   `php bin/console doctrine:migrations:migrate`
-   `symfony server:start` *- To start up the development server*
-   `docker-compose up -d` *- To start up the Docker container*

#### Extracting Logs
-   To extrtact logs into the database, run the command `symfony console log:extract`

#### API
-   Once you have the server up and running, make a `GET` request to: `http://127.0.0.1:8000/api/count`
-   Optionally, you may filter count results with the following query parameters:
    - serviceNames (`array`): An array of strings specifying which service names to count
    - statusCode (`integer`): A valid HTTP status code to filter by
    - startDate (`date`): A validate date in `YYYY-MM-DD` format from which to start searching (inclusive)
    - endDate (`date`): A validate date in `YYYY-MM-DD` format up to which to stop searching (inclusive)