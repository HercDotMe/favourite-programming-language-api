# Favourite programming language
A simple api to determine a GitHub user's favourite programming language based on their public repositories.

## Requirements
You will need docker to be able to run the application properly. Alternatively you can install PHP 8.0 or greater locally and use Symfony's builtin webserver.

## Limitations
This API is only able to read public repositories. Also, it will only read the 100 most recent ones.

## Usage

URL to get the user's favourite language: `/api/favourite-programming-language/{provider}/{username}`

Supported providers:
- GitHub