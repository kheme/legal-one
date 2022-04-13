# Legal One Assessment

A simple Symfony 6 application, Dockerized.

## Contributors

-   [Okiemute Omuta](mailto:omuta.okiemute@gmail.com)

## Project Requirements

-  Nginx web server
-  MySQL 8.0
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
-   To start up the development server, run the command `php bin/console serve`
-   To spin up the Docker container, run the command `docker-compose up -d`

#### Extracting Logs
-   To extrtact logs into the database, run the command `symfony console log:extract`