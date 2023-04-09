<?php
/*
    @ Autor:        David Arriaga | Alimentador WEB
    @ Enterprise:   tw @alimentadorweb
    @ Version PHP:  PHP 8.0
    @ Location:     El Salvador
*/
//require_once('../models/model.php');

class controller extends model{

    function index(){
        //require_once('view/frontend/all/header.php');
        require_once('views/index.php');
        //require_once('view/frontend/all/footer.php');
    }

    function table_users(){
		?>
		<table border="1">
			<thead>
				<tr>
				<th>#</th>
				<th>Usuario</th>
				<th>Nombre</th>
				<th>Email</th>
                <th>Acciones</th>
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
            <td><a href="?c=controller&m=update&id=<?php echo $data->id; ?>">Actualizar</a>
            <a onclick="javascript: return confirm('¿Seguro desea Eliminar?');" href="?c=controller&m=delet&id=<?php echo $data->id; ?>">Eliminar</a></td>
		</tr>
		<?php
		}
		?>
			</tbody>
		</table>
	<?php
	}

	function new(){
		require_once('view/frontend/all/header.php');
        require_once('view/frontend/options/new.php');
        require_once('view/frontend/all/footer.php');
	}

	function register(){
		$data = array(
						'name' 		=>$_REQUEST['name'],
						'last_name' =>$_REQUEST['last_name'],
						'email' 	=>$_REQUEST['email']
					 );
		$e = parent::set_insert($data);
		/*if($e){
			$this->new();
		}else{
			header('Location: index.php')
		}*/
		#Probando condicional Shorthand IF
		$e = ($e) ? $e : header('Location: index.php');
	}

	function update(){
		if(isset($_REQUEST['id'])){
			$data = parent::GetById($_REQUEST['id']);
		}

		require_once('view/frontend/all/header.php');
        require_once('view/frontend/options/update.php');
        require_once('view/frontend/all/footer.php');
	}

	function updateData(){
		$data = array(
					'id' 		=>$_REQUEST['id'],
					'name'		=>$_REQUEST['name'],
					'last_name'	=>$_REQUEST['last_name'],
					'email'		=>$_REQUEST['email']
					 );

		$e = parent::getUpdate($data);
		$e = ($e) ? $e : header('Location: index.php');
	}

	function delet(){
		$e = parent::getDelet($_REQUEST['id']);
		$e = ($e) ? $e : header('Location: index.php');
	}

}

?>
