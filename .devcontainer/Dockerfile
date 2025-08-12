version: "3.8"

services:
  laravel:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_app
    ports:
      - "8000:8000"
    volumes:
      - .:/var/www/html
    depends_on:
      - mysql
    environment:
      - DB_CONNECTION=mysql
      - DB_HOST=mysql
      - DB_PORT=3306
      - DB_DATABASE=laravel
      - DB_USERNAME=laravel
      - DB_PASSWORD=secret
    command: >
      sh -c "composer install &&
             php artisan key:generate &&
             php artisan migrate &&
             php artisan serve --host=0.0.0.0 --port=8000"

  mysql:
    image: mysql:8.0
    container_name: mysql_db
    restart: always
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_USER: laravel
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: rootpassword
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
