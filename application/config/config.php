<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configuration for: Project URL
 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
 */
define('URL', '/');
define('SITE_NAME', 'Loyality programm');
define('DEBUG', true);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 * Example for MySql connect
 *
 * define('DB_TYPE', 'mysql');
 * define('DB_HOST', '127.0.0.1');
 * define('DB_NAME', 'ly');
 * define('DB_USER', 'ly');
 * define('DB_PASS', 'password');
 *
 * For sqlite DB_HOST is database file
 */
define('DB_TYPE', 'sqlite');
define('DB_HOST', '../data/database.sqlite');
/**


/**
 * Configuration for: Folders
 * Here you define where your folders are. Unless you have renamed them, there's no need to change this.
 */
define('LIBS_PATH', '../libs/');
define('CONTROLLER_PATH', '../application/controllers/');
define('MODELS_PATH', '../application/models/');
define('VIEWS_PATH', '../application/views/');

/**
 * TimThumb configuration
 */
define ('FILE_CACHE_DIRECTORY', '../data/cache');

/**
 * Configuration for: Cookies
 * Please note: The COOKIE_DOMAIN needs the domain where your app is,
 * in a format like this: .mydomain.com
 * Note the . in front of the domain. No www, no http, no slash here!
 * For local development .127.0.0.1 is fine, but when deploying you should
 * change this to your real domain, like '.mydomain.com' ! The leading dot makes the cookie available for
 * sub-domains too.
 * @see http://stackoverflow.com/q/9618217/1114320
 * @see php.net/manual/en/function.setcookie.php
 */
// 1209600 seconds = 2 weeks
define('COOKIE_RUNTIME', 1209600);
// the domain where the cookie is valid for, for local development ".127.0.0.1" and ".localhost" will work
// IMPORTANT: always put a dot in front of the domain, like ".mydomain.com" !
define('COOKIE_DOMAIN', '.localhost');

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

/**
 * Configuration for: Views
 *
 * PATH_VIEWS is the path where your view files are. Don't forget the trailing slash!
 * PATH_VIEW_FILE_TYPE is the ending of your view files, like .php, .twig or similar.
 */
define('PATH_VIEWS', '../application/views/');
define('PATH_VIEW_FILE_TYPE', '.twig');

/**
 * Configuration for: Hashing strength
 * This is the place where you define the strength of your password hashing/salting
 *
 * To make password encryption very safe and future-proof, the PHP 5.5 hashing/salting functions
 * come with a clever so called COST FACTOR. This number defines the base-2 logarithm of the rounds of hashing,
 * something like 2^12 if your cost factor is 12. By the way, 2^12 would be 4096 rounds of hashing, doubling the
 * round with each increase of the cost factor and therefore doubling the CPU power it needs.
 * Currently, in 2013, the developers of this functions have chosen a cost factor of 10, which fits most standard
 * server setups. When time goes by and server power becomes much more powerful, it might be useful to increase
 * the cost factor, to make the password hashing one step more secure. Have a look here
 * (@see https://github.com/panique/php-login/wiki/Which-hashing-&-salting-algorithm-should-be-used-%3F)
 * in the BLOWFISH benchmark table to get an idea how this factor behaves. For most people this is irrelevant,
 * but after some years this might be very very useful to keep the encryption of your database up to date.
 *
 * Remember: Every time a user registers or tries to log in (!) this calculation will be done.
 * Don't change this if you don't know what you do.
 *
 * To get more information about the best cost factor please have a look here
 * @see http://stackoverflow.com/q/4443476/1114320
 */

// the hash cost factor, PHP's internal default is 10. You can leave this line
// commented out until you need another factor then 10.
define("HASH_COST_FACTOR", "10");

/**
 * Configuration for: Email server credentials
 *
 * Here you can define how you want to send emails.
 * If you have successfully set up a mail server on your linux server and you know
 * what you do, then you can skip this section. Otherwise please set EMAIL_USE_SMTP to true
 * and fill in your SMTP provider account data.
 *
 * An example setup for using gmail.com [Google Mail] as email sending service,
 * works perfectly in August 2013. Change the "xxx" to your needs.
 * Please note that there are several issues with gmail, like gmail will block your server
 * for "spam" reasons or you'll have a daily sending limit. See the readme.md for more info.
 *
 * define("PHPMAILER_DEBUG_MODE", 0);
 * define("EMAIL_USE_SMTP", true);
 * define("EMAIL_SMTP_HOST", 'ssl://smtp.gmail.com');
 * define("EMAIL_SMTP_AUTH", true);
 * define("EMAIL_SMTP_USERNAME", 'xxxxxxxxxx@gmail.com');
 * define("EMAIL_SMTP_PASSWORD", 'xxxxxxxxxxxxxxxxxxxx');
 * define("EMAIL_SMTP_PORT", 465);
 * define("EMAIL_SMTP_ENCRYPTION", 'ssl');
 *
 * It's really recommended to use SMTP!
 */
// Options: 0 = off, 1 = commands, 2 = commands and data, perfect to see SMTP errors, see the PHPMailer manual for more
define("PHPMAILER_DEBUG_MODE", 0);
// use SMTP or basic mail() ? SMTP is strongly recommended
define("EMAIL_USE_SMTP", false);
// name of your host
define("EMAIL_SMTP_HOST", 'yourhost');
// leave this true until your SMTP can be used without login
define("EMAIL_SMTP_AUTH", true);
// SMTP provider username
define("EMAIL_SMTP_USERNAME", 'yourusername');
// SMTP provider password
define("EMAIL_SMTP_PASSWORD", 'yourpassword');
// SMTP provider port
define("EMAIL_SMTP_PORT", 465);
// SMTP encryption, usually SMTP providers use "tls" or "ssl", for details see the PHPMailer manual
define("EMAIL_SMTP_ENCRYPTION", 'ssl');
