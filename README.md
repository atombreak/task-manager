
# Laravel Task Management Application

This is a Laravel-based task management application that allows users to manage tasks and projects. Users can create, edit, delete tasks and projects, and reorder tasks via drag-and-drop.

## Prerequisites

- PHP 7.4 or higher
- Composer
- Docker

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/task-manager.git
cd task-manager
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Set Up Environment Variables

Copy the example environment file and set up your environment variables.

```bash
cp .env.example .env
```

Update the `.env` file to match your environment. Ensure the following variables are set:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=secret

# Other necessary environment variables
```

### 4. Set Up Docker for MySQL and phpMyAdmin

Create a `docker-compose.yml` file in the root directory of your project:

```yaml
version: '3.1'

services:

  mysql:
    image: mysql:5.7
    container_name: mysql
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: task_manager
    ports:
      - 3306:3306
    volumes:
      - mysql_data:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: phpmyadmin
    restart: always
    environment:
      PMA_HOST: mysql
      MYSQL_ROOT_PASSWORD: secret
    ports:
      - 8080:80

volumes:
  mysql_data:
```

Start the Docker containers:

```bash
docker-compose up -d
```

### 5. Run Migrations

Run the database migrations to set up the necessary tables.

```bash
php artisan migrate
```

### 6. Serve the Application

Run the Laravel development server.

```bash
php artisan serve
```

Open your browser and navigate to `http://127.0.0.1:8000` to view the application.

### Access phpMyAdmin

You can access phpMyAdmin at `http://127.0.0.1:8080` using the following credentials:

- **Server**: mysql
- **Username**: root
- **Password**: secret

## Deployment

To deploy the Laravel application on a server, follow these steps:

### 1. Set Up the Server

- Ensure your server has PHP 7.4 or higher and Composer installed.
- Set up a web server (Apache, Nginx, etc.).
- Ensure MySQL is installed and running.

### 2. Clone the Repository on the Server

```bash
git clone https://github.com/your-repo/task-manager.git
cd task-manager
```

### 3. Install Dependencies

```bash
composer install --no-dev
```

### 4. Set Up Environment Variables

Copy the example environment file and set up your environment variables.

```bash
cp .env.example .env
```

Update the `.env` file to match your production environment. Ensure the following variables are set:

```env
DB_CONNECTION=mysql
DB_HOST=your_production_db_host
DB_PORT=3306
DB_DATABASE=your_production_db_name
DB_USERNAME=your_production_db_user
DB_PASSWORD=your_production_db_password

# Other necessary environment variables
```

### 5. Run Migrations

Run the database migrations to set up the necessary tables.

```bash
php artisan migrate --force
```

### 6. Set Up File Permissions

Ensure the `storage` and `bootstrap/cache` directories are writable by the web server.

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 7. Set Up the Web Server

Configure your web server to serve the Laravel application. Here is an example configuration for Nginx:

```nginx
server {
    listen 80;
    server_name your_domain.com;
    root /path/to/your/project/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Restart your web server to apply the changes.

### 8. Set Up Supervisor for Queue Workers (Optional)

If your application uses Laravel queues, set up Supervisor to manage your queue workers. Install Supervisor:

```bash
sudo apt-get install supervisor
```

Create a Supervisor configuration file for your Laravel queue workers:

```bash
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

Add the following configuration:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
```

Start Supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

Your Laravel application should now be deployed and running on your server.

## Conclusion

This README file provides instructions for setting up and running the Laravel task management application, including using Docker for MySQL and phpMyAdmin, and deploying the application on a server. Follow these steps to get your application up and running smoothly.
