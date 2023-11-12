<!-- Front controller -->
<?php

use App\Core\Routing\Router;

include_once('./bootstrap/init.php');
$router = new Router();
$router->run();
