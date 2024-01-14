## Example gist app

Created from a default Laravel sail setup, with `curl -s https://laravel.build/example-app | bash`

### Setup

-   composer install
-   mv .env.example .env
-   sail up -d
-   sail artisan migrate

Create github OAuth app and add GITHUB_CLIENT_ID and GITHUB_CLIENT_SECRET to .env.

Run `npm run dev` and go to http://localhost
