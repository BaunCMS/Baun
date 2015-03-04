title: Installing
----
# Installing Baun

Baun has the following minimum requirements:

* Apache 2 with URL rewriting (mod_rewrite) or nginx
* PHP 5.4+

## Install Composer

Baun utilizes [Composer](http://getcomposer.org) to manage its dependencies. So, before installing Baun, you will
need to make sure you have SSH access to your server and Composer installed on your server.

## Download & Install Baun

1. [Download the latest version](https://github.com/BaunCMS/Baun/releases) of Baun
2. Upload the files to your server (normally using FTP or some other deployment method)
3. Login to your server using SSH
4. Navigate to the installation location of Baun and run `composer install`
5. Make sure your virtual host points to the `/public` folder of Baun and not the root folder

## Setup Apache Virtual Host

If you use Apache you will need to setup a virtual host to point to the `/public` folder of Baun, and
not the root folder. The process for doing this varies depending on your server but the actual
virtual host should look like:

    <VirtualHost *:80>
        ServerName mybaun.com
        DocumentRoot "/path/to/baun/public"
        <Directory "/path/to/baun/public">
            AllowOverride all
        </Directory>
    </VirtualHost>

If you have any trouble doing this speak to your hosting provider and ask if they can set it up for you.