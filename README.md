# Project Title

Laravel Github oAuth 

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [How to Run the Project](#how-to-run-the-project)
- [Usage](#usage)


## Overview

In this project, I have developed a GitHub profile viewer application that allows users to authenticate using their GitHub accounts and view their repositories, including filtering options for languages, stars, and update dates.

## Features

- GitHub authentication
- Display user repositories
- Filter repositories by language, stars, and update date
- Pagination for repository results

## Technologies Used

- PHP
- Laravel
- GitHub API
- JavaScript
- HTML/CSS
- Tailwind

## Installation

Follow these steps to set up the project locally:

1. Clone the repository:
   ```bash
   https://github.com/JimNewaz/github-oAuth2-Laravel.git

2. Navigate to the project directory:
    ```bash
   cd your-repo-name
    
3. Install dependencies:
     ```bash
   composer install
     
4. Copy the .env.example file to .env:     
    ```bash
   cp .env.example .env
5. Generate the application key:
```bash
   php artisan key:generate
```

## How to Run the Project

```bash
php artisan serve
```

## Usage
Once authenticated, you can:

1) View your repositories listed on the profile page.
2) Use the search bar to filter repositories by name.
3) Filter repositories by programming language, stars, and last updated date.
4) You can navigate through pages of your repositories.

