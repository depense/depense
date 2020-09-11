# Depense - Expense Management

“Depense” is a web application project, prepared to help users track their expenses 
and visualize their daily transactions for better decision-making.

This repository contains the application source code (based on [Symfony 5.1.5 Framework](https://symfony.com/doc/5.1/index.html)).

### Getting Started

These instructions will get you a copy of the project up and running on 
your local machine for development and testing purposes.

### Prerequisites

This project requires the following dependencies:
* PHP 7.4 or higher
* [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

### Installation

Clone the repository in your local machine

```bash
$ git clone https://github.com/mradhi/ibanfirst-viewer.git
```

The application uses environment variables to configure the connection with 
database and Depense services. 
You can look up the default values in `.env` file and customise them 
by creating `.env.local` with variables you want to override.

Next you need to install the application dependencies by running:

```bash
$ composer install
```

### Accessing the application

I strongly recommend using the Symfony Local Web Server by running the `symfony serve` 
command and then accessing `http(s)://127.0.0.1:8000` in your web browser.

Get to know more about using Symfony Local Web Server 
in the [Symfony server documentation](https://symfony.com/doc/5.1/setup/symfony_server.html). 

Now you're ready to go...

### Running Tests

To execute all the tests in the application, you need to run the following command:

```bash
$ ./bin/phpunit
```

### Deployment

Download the latest version of `Automate` deployment tool using the following
command:

```bash
$ curl -LSs https://automate-deployer.com/installer.php | php
```

Create a new file based on `.automate.yml.dist`
and edit it with your own configuration.

```bash
$ cp .automate.yml.dist automate.yml
```

For each deployment process for this application the desired path is
`/var/www/<staging|production>.depense.net`.

If you want to add the directory of the app inside /var/www directory, you need
to set permissions to that directory using the following command:

```bash
$ sudo setfacl -m u:<user>:rwX /var/www/<staging|production>.depense.net
```

Next, you need to create/access to the shared directory using the command

```bash
$ mkdir /var/www/<staging|production>.depense.net/shared
$ cd /var/www/<staging|production>.depense.net/shared
```

Then add the following files/directories to it:

```bash
mkdir var && touch .env.local
```

Of course, you need to update the `.env.local` with the correct
values depending on the environment.

For example, in the staging environment, the `.env.local` file should be something similar to:

```dotenv
APP_ENV=dev
```

Next, add permissions to the www-data and the current user to `shared/var` directory

```bash
$ setfacl -dL -R -m u:www-data:rwX -m u:<user>:rwX var
```

**NOTE**: After each deployment, it's recommended that we clear the cache of our opcache
and to do that,  you need to add your user to the www-data group using this command:

```bash
$ sudo usermod -a -G www-data <user>
```

Finally, run the following script:

```bash
php automate.phar deploy <staging|production>
```

## Questions?

If you have any questions please [open an issue](https://github.com/depense/depense/issues/new).
