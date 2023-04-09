<?php
    /*
    @ Autor:        David Arriaga | Alimentador WEB
    @ Enterprise:   tw @alimentadorweb
    @ Version PHP:  PHP 8.0
    @ Location:     El Salvador
    */

class Model extends Database{
    // Aqui colocaremos todas las sentencias SQL

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

    #Función de insert.
    private function insert($data){
        try{
            $SQL    = 'INSERT INTO usuarios (alias, nombres, email) VALUE (?,?,?)';
            $result = $this->connect()->prepare($SQL);
            $result->execute(array(
                                    $data['name'],
                                    $data['last_name'],
                                    $data['email']
                                  ));
        }catch (Exception $e){
            die('Error Controller(insert): '. $e->getMessage());
        }finally{
            $result = null;
        }
    }

    #La funcion insert es privada, por lo cual debemos ejecutarla a parte para la proteccion de los datos.
    function set_insert($data){
        return $this->insert($data);
    }

    private function GetId($id){
        try{
            $SQL    = 'SELECT * FROM usuarios WHERE id = ?';
            $result = $this->connect()->prepare($SQL);
            $result->execute(array($id));
            return $result->fetch(PDO::FETCH_OBJ);

        }catch (Exception $e){
            die('Error Administrativo: (GetId) ' . $e->getMessage());
        }finally{
            $result = null;
        }
    }

    function GetById($id){
        return $this->GetId($id);
    }

    private function Update($data){
        try{
            $SQL    = 'UPDATE usuarios SET
                      alias     = ?,
                      nombres   = ?,
                      email     = ?
                      WHERE id  = ?';
            $result = $this->connect()->prepare($SQL);
            $result->execute(array(
                                $data['name'],
                                $data['last_name'],
                                $data['email'],
                                $data['id']
                                ));
        }catch (Exception $e){
            die('Error Administrativo (Update): '. $e->getMessage());
        }finally{
            $result = null;
        }
    }

    function getUpdate($data){
        $this->Update($data);
    }

    private function Delete($data){
        try{
            $SQL    = 'DELETE FROM usuarios WHERE id = ?';
            $result = $this->connect()->prepare($SQL);
            $result->execute(array($data));
        }catch (Exception $e){
            die('Error Administrativo (Delete):' . $e->getMessage);
        }finally{
            $result = null;
        }
    }

    function getDelet($data){
        $this->Delete($data);
    }

}
?>
