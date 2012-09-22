PHP-Userbars
============

Simple class for creating Dynamic Userbars in PHP

```php
include("userbars.php");
$generator = new UserBars();
$image = $generator->create("Test bar! :: ".date("r"));
```