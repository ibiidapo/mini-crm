# Project
<p>Mini CRM demo app using VueJS and Laravel PHP Framework</p>

# Author
<p>Created by Marios Vasiliou<p>
<p>Mobile and Full Stack Developer<p>
<a href="https://linkedin.com/in/darkpain">LinkedIn</a>

# Requirements
- PHP: >=7.1.3
- Composer Package Manager (https://getcomposer.org/)
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- ZIP PHP Extension
- GD2 PHP Extension
- MYSQL Server 5.7+

# Clone 
To clone repository open terminal and type\
git clone https://github.com/DarkPain0/mini-crm.git for HTTPS\
git clone git@github.com:DarkPain0/mini-crm.git for SSH

# Installation
In the root repository folder you have cloned write those commands
- composer install (to install vendor packages)
- cp .env.example to .env (or copy and paste my .env file and change according)
- create a database in mysql and add credentials in .env file
- php artisan migrate (to create tables)
- php artisan db:seed (to optionally seed fake data to database)

# Run Project
- php artisan serve --host=mini-crm.localhost --port=80 (to run laravel dev server)
- Optionally you download and use Laragon for easy setup a WAMP or LAMP Stack
- Open website http://mini-crm.localhost.com
- Login with seeded admin user with credentials 
`admin@admin.com  password`
- In case you have problem with js,css run `npm prod`

# Unit Tests
To run unit tests execute command
- phpunit (to run php unit tests)
- php artisan dusk (to run browser tests)`