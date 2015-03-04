title: Configuration
----
# Configuring Baun

Baun needs no configuration to get started! However, you may wish to review the `config/app.php` file and its documentation.

## Pretty URLs

Baun ships with a `public/.htaccess` file that is used to allow URLs without `index.php`. If you use Apache be
sure to enable the `mod_rewrite` module. If the `.htaccess` file that ships with Baun does not work with your Apache
installation, try this one:

    Options +FollowSymLinks
    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

### Nginx

On Nginx, the following directive in your site configuration will allow "pretty" URLs:

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }