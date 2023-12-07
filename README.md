# Project Title
Symfony stack overflow API

# Description
This Symfony application gets the data from an external API https://swapi.dev/api/

# Steps to follow to run the APP
1- Download the project from Github in your local

2- Run composer install

3- Configure the .env file or create a .env.local file it should have a db connection 

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=9ea2d4b318f6ecc3131fb064ef9e886a
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL=mysql://root@127.0.0.1:3306/stack_overflow_test
###< doctrine/doctrine-bundle ###

4- php bin/console doctrine:database:create To create the db

5- php bin/console doctrine:schema:update --force to create the databse structure. 

6- start using the stack overflow api

7- example call: http://127.0.0.1:8000/stackoverflow-questions?tagged=react&fromdate=1701820800&todate=1701907200