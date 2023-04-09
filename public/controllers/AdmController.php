<?php
/*
    @ Autor:        David Arriaga | Alimentador WEB
    @ Enterprise:   tw @alimentadorweb
    @ Version PHP:  PHP 8.0
    @ Location:     El Salvador
*/
session_start();
if(isset($_SESSION['id']) && $_SESSION['logeado'] == 'ok'){

    class AdmController extends AdmModel{

        function ControlPanel(){
            require_once('view/backend/all/header.php');
            require_once('view/backend/all/navbar.php');
            require_once('view/backend/all/modals.php');
            require_once('view/backend/panelControl.php');
            require_once('view/backend/all/footer.php');

        }

        function table_users(){

            ?>
            <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Opciones</th>
                    </tr>
                </thead>
                <tbody >
            <?php
            foreach (parent::get_table() as $data) {
            ?>
            <tr>
                <td><?php echo $data->id; //ID Tomado de Base de Datos ?> </td>
                <td><?php echo $data->alias; ?> </td>
                <td><?php echo $data->nombres; ?> </td>
                <td><?php echo $data->email; ?> </td>
                <td><button class="btn btn-outline-primary" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i>Accciones</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="?c=controller&m=update&id=<?php echo $data->id; ?>">Actualizar</a>
                            <a class="dropdown-item" onclick="javascript: return confirm('¿Seguro desea Eliminar?');" href="?c=controller&m=delet&id=<?php echo $data->id; ?>">Eliminar</a>
                        </div>
                </td>
            </tr>
            <?php
            }
            ?>
                </tbody>
            </table>
        <?php
        }

        function Back_up(){
            require_once('config/lib/BackupDB.php');
            $backup = new BackupDB;

            return $backup->Backup();
        }

    }#cierra clase
#cierra if
}else{
    header('Location: ?c=Login&m=index');
    die();
}#cierra else

?>
