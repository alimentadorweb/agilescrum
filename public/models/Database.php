<?php

/*
    @ Autor:        David Arriaga | Alimentador WEB
    @ Enterprise:   tw @alimentadorweb
    @ Version PHP:  PHP 8.0
    @ Location:     El Salvador
*/

class Database{

    # Ruta para dejar los logs cuando se generan errores, por defecto el directorio de trabajo
    static protected $pathLogs = './';

    public function __construct(){}

    protected function connect(){

        require_once 'controllers/config/link_pdo.php';
        $e = new Config();
        $db_config = $e->datos();

        # Si el array de configuración viene vacio devolvemos un error y lo guardamos en el LOG
        if ( empty( $db_config))
        {
        # Si el array de configuracion viene vacio devolvemos un error y lo grabamos en el fichero de errores.
        error_log( date("Y-m-d H:i:s") . " - Archivo de configuracion vacio \n", 3, static::$pathLogs."db_error.log");
        $return = array(
            'success' => false,
            'data' => 'Archivo de configuración vacío',
        );
        return ( array( 'success' => false, 'data' => $return));
        }
            #Conexion a la base de datos
            try{
                $connect = new PDO($db_config['dsn'], $db_config['user'], $db_config['pass']);
                $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                //$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return $connect;
            }catch (Exception $e){
               # Si obtenemos un error lo escribimos en un log de errores y devolvemos success=false y el error
                $_error = print_r( $e->getTrace(), true) . "\n" . $e->getMessage();

                error_log( date("Y-m-d H:i:s") . " - " . $_error . "\n", 3, static::$pathLogs."db_error.log");
                $return = array(
                    'success' => false,
                    'data' => $_error,
                );
                return ( array( 'success' => false, 'data' => $return));
            }
    }
}
?>
