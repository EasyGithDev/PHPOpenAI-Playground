# PHPOpenAI-Playground
An example of using the project `PHPOpenAI`

The main project is hosted here :

[https://github.com/EasyGithDev/PHPOpenAI](https://github.com/EasyGithDev/PHPOpenAI).

## System Requirements

This project is based on PHP version 8.1 in order to use features such as enumerations. This project does not require any external dependencies. However, you must have the cURL extension installed for it to work properly.

- PHP version >= 8.1
- cURL extension

## Installation

The project uses Composer to manage dependencies. If you haven't already installed Composer, you can do so by following the instructions on the official Composer website.

#### Clone the project

To install the project, you can clone it from GitHub using the following Git command:

```bash
git clone git@github.com:EasyGithDev/PHPOpenAI-Playground.git
```

#### Install the project

```bash
composer install
```

#### Run the project

First, you need to go in the public directory :

```bash
cd /INSTALL/DIR/public
```

Next, launch the server :

```bash
php -S localhost:8000
```

Finally, you can open the playround in your browser :

```
http://localhost:8000
```

#### Important

The application stores images and associated metadata in the "download" and "serialize" folders. These two folders must be writable.