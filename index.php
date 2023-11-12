<!-- Front controller -->
<?php

use App\Core\Routing\Router;
use App\Models\Contracts\mysqlBaseModel;
use App\Models\User;

include_once('./bootstrap/init.php');
$router = new Router();
$router->run();
