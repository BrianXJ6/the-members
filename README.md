<p align="center">
    <a href="https://github.com/BrianXJ6/the-members" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>
<p align="center">Follow the recommendations below to be able to download and install the project successfully.</p>

## Requirements

- PHP: `^8.2`
- Docker: `^25.0`
- Composer: `^2.7`

> **Note:** If you are a **Windows** user, make sure you already have **WSL2** installed. If you want to know more, [click here](https://learn.microsoft.com/pt-br/windows/wsl/install).

## First step

To clone the repository and obtain all project files, run the command below:

```console
git clone https://github.com/BrianXJ6/the-members.git
```

After finishing the cloning process, enter the directory and run the `composer` command to download all possible dependencies.

```bash
composer update
```

Then perform the 2 commands below:

1. Make a copy of the environment settings file called `.env.example` and rename it to `.env`;
2. Generates a new key for the APP, without it, it will not be possible to execute the project.

```bash
cp .env.example .env
php artisan key:generate
```

Agora precisamos editar o arquivo `.env` que acabamos de copiar e definir as configurações da base de dados.

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=the_members_db
DB_USERNAME=admin
DB_PASSWORD=admin
```

Finally, now let's generate a Docker build and startar the application to a development environment.

```bash
vendor/bin/sail up -d
```

> **Optional:** If you want to create a shortcut for **Laravel Sail** and not have to type its full path, follow this tutorial in the official documentation by [clicking here](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias).

## Second step

Run the database migrations and install the NPM dependencies.

```bash
vendor/bin/sail artisan migrate --seed
vendor/bin/sail npm i
```

Finally, you can now browse and enjoy this project via the URL:<http://localhost> in your browser.
