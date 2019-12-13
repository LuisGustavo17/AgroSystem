# Product Management
This is a demo of stock management system.

## Features
  - Stock Adding
  - Stock Manage 
  - Supplier Management
  - Category Manage
  - Low stock alert
  - Upcoming expiration alert
  - Telegram alerts
  - Product input and output charts
  
## Run
  Copy .env.example to .env and setup your Database information.

  ``` bash
  # Composer install
  composer install

  # Laravel init
  php artisan key:generate
  php artisan migrate
  php artisan db:seed

  # serve at localhost:8000
  php artisan serve
  ```
  ## Screenshot
https://user-images.githubusercontent.com/44074498/70838773-889f9780-1de8-11ea-841d-bf73e9fa9996.png
