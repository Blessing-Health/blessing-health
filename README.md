## Blessing Health

All frontend code is a standalone Quasar JS app located under `/spa`

## Getting Started

### Install the dependencies

```
composer install
cd spa
yarn
```



### Setting up .env

- Create a copy of `.env.example` and rename to `.env`. This is where you will store your local config.
- Go to spa folder and create a copy of `.env.example` and rename to `.env`.


### Setting up the database

Once we go live you can just grab a backup of the production db and use that locally. Otherwise build a new database from scratch:

```
php artisan migrate --seed
php artisan import:database
```


### Start the app in development mode (hot-code reloading, error reporting, etc.)

```
yarn dev
```


By default, Quasar uses port `9001` which is specified in `spa\quasar.config.js` and it's allowed in `config\sanctum.php`
If by any chance, Quasar uses a different port, you need to add it to `config\sanctum.php`.


### Build the app for production

```
yarn build
```


### Media

Ensure media is publicly accessible for things such as report generation by symlinking the media folder as follows (from BH root folder).
This allows tools to directly link to media via their direct web url (without going through the framework).

On windows:

```
mklink /J "public\media" "storage\media"
```

On linux:

```
ln -s /home/wwwsites/path/to/app/public/media storage/media
```


### PDF Reports (Browsershot / Puppeteer)

For all PDF reports to generate properly make sure you have puppeteer globally installed `npm install -g puppeteer` and
make sure `NODE_BIN_PATH` and `NODE_PATH` are set correctly in your `.env` file. Use `which node` to find what node you are running.
You also need to set the `NODE_PATH` environment variable in your apache config `apache.conf` file:

```
<Directory />
    AllowOverride none
    Require all denied
	
    SetEnv NODE_PATH "C:/path/to/your/node/node_modules"
</Directory>
```


### Deploying to production (first time setup)

- Deploy the application to the target server with appsync (configure required deployment checks etc)
- For UAT environments make sure you use `yarn build:uat` to make a uat build with UAT-specific variables and paths as per `.env.uat`
- Create public symlink `/home/www/bh -> /home/wwwsites/bh/public`
- Create public symlink for the spa subfolder `/home/www/bh/spa -> /home/wwwsites/bh/spa/dist`
- Ensure media symlinks exist (as detailed above)
- Login to the server make sure the .env is properly setup and config cached
- Run any migrations and seeders


### Developer Notes

- For checking available components and other documentation: https://quasar.dev (you'll want to keep this tab pinned in your browser)
- You can also use material icons in addition to font awesome. Available material icons can be found here: https://fonts.google.com/icons?selected=Material+Icons
- Supporting both Dark and Light quasar theme. Automatically set based on users windows theme setting. You need to test any custom CSS against both modes - see here for more info: https://quasar.dev/style/dark-mode
- Not using typescript for now unless compelling reason to do so later on


### Laragon (Dev Only)
Laragon registers host and apache vhost entry for us to map the foldername as a domain name pointing to localhost. (domain name)
.e.g bh -> bh.localhost -> 127.0.0.1
Laragon also sets up a apache vhost so that bh.localhost -> /path/to/webroot/www/bh/public
If not using laragon, you can just use "http://localhost/bh/public" as the app url for both .env files. They both must match for Sanctum cookie auth to work correctly!

