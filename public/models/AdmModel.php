<?php
    /*
    @ Autor:       David Arriaga | Alimentador WEB
    @ Enterprise:   tw @alimentadorweb
    @ Version PHP:  PHP 8.0
    @ Location:     El Salvador
    */

class AdmModel extends Database{

    private function GetUser($user, $pass){
        try{
            $SQL    = 'SELECT * FROM dbobackend WHERE user = :user AND pass = :pass';
            $result = $this->connect()->prepare($SQL);
            $result->execute(array(
                                'user' => $user,
                                'pass' => $pass));
                if($result->rowCount() == 1){
                    return $result;
                }else{
                    return false;
                }
        }catch (Exeption $e){
            die('Error Administrativo: (GetUser)'. $e->getMessage());
        }

    }

    function GetByUser($user, $pass){
        $consult = $this->getUser($user, $pass);
        return $consult;
    }

    #visualizacion de datos (se puede copiar funcion para replicar, solo cambiando nombre de la funcion).
    private function view_table(){

        try{
            $SQL    = "SELECT * FROM usuarios" ;
            $result = $this->connect()->prepare($SQL);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_OBJ);
        }catch (Exeption $e){
            die('Error Administrativo(view_table) '.$e->getMessage());
        }finally{
            $result = null;
        }
    }

    #Enviar a la vista los datos de la funcion View_Table
    function get_table(){
        return $this->view_table();
    }
}

?>
