<?php
/*
    @ Autor:       David Arriaga | Alimentador WEB
    @ Enterprise:   tw @alimentadorweb
    @ Version PHP:  PHP 8.0
    @ Location:     El Salvador
*/

require_once 'controllers/core/core.php';

$c   = isset($_GET['c']) ? $_GET['c'] : 'controller';
$m   = isset($_GET['m']) ? $_GET['m'] : 'index';
//$c  .= 'Controller';

if(file_exists('controllers/' . $c . '.php')){
    require_once 'controllers/' . $c . '.php';
    if(method_exists($c, $m)){
        $c = new $c;
        call_user_func([$c,$m]);
    }else{
        die("Error: El Metodo o Funcion [{$m}()] no existe");
    }
}else{
    die("Error: El Controlador [{$c}] no existe.");
}


?>
