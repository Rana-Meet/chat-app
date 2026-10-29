# Chat App NEw 

A real-time one-to-one chat app built with **Laravel 12**, **Laravel Reverb** (websockets), **Tailwind CSS** and **Vite**. Messages appear instantly for the other person, with no page refresh.

## Features

- Register, log in and log out (Laravel Breeze authentication)
- Private one-to-one chat with live delivery over websockets
- Delete your own messages
- Add new users and edit your profile
- Responsive design with a landing page, dashboard and chat screen

## Requirements

| Tool | Version |
|---|---|
| PHP | 8.2 or newer |
| Composer | 2.x |
| Node.js | 20.19+ or 22.12+ (needed by Vite 8) |
| MySQL | 5.7+ or MariaDB (XAMPP works) |

PHP needs the usual Laravel extensions: `mbstring`, `openssl`, `pdo_mysql`, `curl`, `fileinfo`, `xml`, `zip`.

## Installation

```bash
# 1. Clone and enter the project
git clone https://github.com/Rana-Meet/chat-app.git
cd chat-app

# 2. Install dependencies
composer install
npm install

# 3. Create the environment file and app key
copy .env.example .env        # Windows (use "cp" on Mac/Linux)
php artisan key:generate
```

## Database

1. Start MySQL (for example from the XAMPP control panel).
2. Create an empty database named `chat_app` (phpMyAdmin, or `CREATE DATABASE chat_app;`).
3. Check these values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chat_app
DB_USERNAME=root
DB_PASSWORD=
```

4. Create the tables:

```bash
php artisan migrate
```

## Websocket (Reverb) setup

`.env.example` does not include the Reverb settings, so add them to your `.env`. Replace `BROADCAST_CONNECTION=log` with `reverb` and add the rest. Pick your own values for the app id, key and secret (any numbers/random text, but keep them private):

```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-random-key
REVERB_APP_SECRET=your-random-secret
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

Use each `REVERB_*` name only once in the file. Optionally set `APP_NAME="Chat App"` so your own name shows in the header.

After editing `.env`, clear the cached config:

```bash
php artisan config:clear
```

## Running the project

Open **three terminals** in the project folder and start one command in each:

```bash
php artisan serve          # the website  -> http://127.0.0.1:8000
php artisan reverb:start   # the websocket server (port 8080)
npm run dev                # Vite for CSS/JS
```

Instead of `npm run dev` you can build the assets once and skip the third terminal:

```bash
npm run build
```

Open http://127.0.0.1:8000, register two accounts, and log in with each one in a different browser (or an incognito window). Open the chat, pick the other person and send a message. It should appear on the other side right away.

## Changed the design or `.env`?

```bash
npm run build
php artisan view:clear
php artisan config:clear
```

Restart `php artisan reverb:start` after any change to the `REVERB_*` values.

## Troubleshooting

| Problem | Fix |
|---|---|
| `cURL error 7: Failed to connect to localhost port 8080` when sending a message | Reverb is not running. Run `php artisan reverb:start`. |
| `No matching application for ID` | Old config is cached. Run `php artisan config:clear` and restart Reverb. |
| Messages only show after a refresh | Check `BROADCAST_CONNECTION=reverb`, rebuild with `npm run build`, and look for `Echo not loaded!` in the browser console (F12). |
| Page looks unstyled or half styled | Run `npm run build` (or keep `npm run dev` running). If a file named `public/hot` exists and Vite is not running, delete it. |
| Port 8080 is already in use | Set `REVERB_PORT=8081` in `.env`, clear config, restart Reverb and rebuild the JS. |
| `SQLSTATE[HY000] [1049] Unknown database` | Create the `chat_app` database first, then run `php artisan migrate`. |
| `No application encryption key has been specified` | Run `php artisan key:generate`. |
| Vite fails to start or build | Update Node.js to 20.19+ or 22.12+ and run `npm install` again. |

## Tech stack

Laravel 12 · PHP 8.2+ · MySQL · Laravel Reverb · Laravel Echo · Tailwind CSS · Alpine.js · Vite

## Security notes

- Never commit your `.env` file. It holds your database password and Reverb secret.
- Use your own random values for `REVERB_APP_KEY` and `REVERB_APP_SECRET` in every environment.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
