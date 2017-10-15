# pREST
A simple controller implementation in php to handle different routes in one place.
To enable this please update your htaccess file like follows.

```
Options +FollowSymLinks
RewriteEngine On

RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f

RewriteRule ^.*$ ctrl.php
```

This will force all routes to be handled in ctrl.php.

A simple example implementation for ctrl.php could be as follows.

```php
require_once("controller.php");
try {
  $ctrl = new Controller();
  $ctrl->route('book', function($res) {
    echo "here we are in book";
  });

  $ctrl->route('book/:id', function($res) {
    echo "here we are in book/id with id {$res["id"]}";
  });

  $ctrl->parse();
} catch (Exception $e) {
  echo "error occurred " . $e->getMessage() . "\n";
}
```
