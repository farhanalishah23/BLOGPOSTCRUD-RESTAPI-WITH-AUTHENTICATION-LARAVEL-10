# Simple Authentication APIs & BlogPost CRUD with Image Insert in Laravel 10

This project demonstrates a **Simple Authentication API** for **User Login** and **Registration**, alongside **BlogPost CRUD** operations (Create, Read, Update, Delete) with **Image Upload** functionality. The project is built using **Laravel 10**, **PHP**, and **MySQL**.

![Laravel Logo](https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnhfAMgG_6ps9Hs_2NjmJ5pgskwlhFAQyv7g&s)  
![MySQL Logo](https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMAcIinT4Nro73mPS36Kub9ejIbv9nyqmf9hXdR-vjtY_aJXV4voC2XIoLPiz9KB56-qk&usqp=CAU)

## Features

- **User Registration**: Allows users to register with their name, email, and password.
- **User Login**: Authenticates users and returns an authentication token.
- **JWT Authentication**: Uses **JSON Web Tokens (JWT)** to manage user authentication.
- **BlogPost CRUD**: Allows users to create, read, update, and delete blog posts with title, content, and an optional image.
- **Image Upload**: Blog posts can have images uploaded to the server.
- **REST API**: All functionalities are exposed via RESTful APIs.

## Tech Stack

- **Backend**: Laravel 10
- **Authentication**: JWT (using `tymon/jwt-auth` package)
- **Database**: MySQL
- **Image Upload**: Laravel's built-in file storage functionality

## Installation

### Prerequisites

- **PHP 8.1 or higher**
- **Composer** (for dependency management)
- **MySQL** (or any relational database)
- **Postman** or any API testing tool to test the APIs.

### Step-by-Step Guide

#### 1. Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/farhanalishah23/BLOGPOSTCRUD-RESTAPI-WITH-AUTHENTICATION-LARAVEL-10.git
cd simple-auth-crud-laravel
