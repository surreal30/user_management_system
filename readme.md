## User Management System

An application to add, store and maintain users. The app allows users to login and add user to the database. The user can also see the list of all the users where he can edit or delete the user. 

## Technology Used

- PHP
- MySQL
- Apache
- Docker

## Prerequisite

- Docker

## Installation

- Open terminal and go to the directory where you want to install the application.
- Clone the repository using `git clone git@github.com:surreal30/user_management_system.git`.
- Go to user_management_system directory.
- Open .env.sample using `vi .env.sample` on terminal.
- Replace the values of keys `MYSQL_ROOT_PASSWORD`, `MYSQL_PASSWORD` and `MYSQL_USER` with your credentials. Do not change the keys which have "DO NOT CHANGE" mentioned.
- Change the file name from `.env.sample` to `.env` for it to work. 
- Run command `docker-compose up -d --build`.

## Working

- When you go to `localhost:8080`, the application checks if you are logged in or not. If you are not logged in you are redirected to the login page.
- On the login page you are prompted to login to contiue on the application. Once you login, the application check if you opened any other page other than home page before being redirected to login page. If you were on another page you will be redirected to the same page and if you were not then you will be redirected to the home page.
- On the site you can use navbar to go to page to add user or see the list of all the users in the database.
- On the list user page you get the option to edit or delete the user.