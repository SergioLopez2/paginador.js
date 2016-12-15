<?php
// obtiene los valores para realizar la paginacion
$limit = isset($_POST["limit"]) && intval($_POST["limit"]) > 0 ? intval($_POST["limit"])	: 10;
$offset = isset($_POST["offset"]) && intval($_POST["offset"])>=0	? intval($_POST["offset"])	: 0;
// realiza la conexion
$con = new mysqli("localhost","root","root","paginacion");
$con->set_charset("utf8");

// array para devolver la informacion
$json = array();
$data = array();
//consulta que deseamos realizar a la db	
$query = $con->prepare("select id_usuario,nombres,apellidos from  usuarios limit ? offset ?");
$query->bind_param("ii",$limit,$offset);
$query->execute();

// vincular variables a la sentencia preparada 
$query->bind_result($id_usuario, $nombres,$apellidos);

// obtener valores 
while ($query->fetch()) {
	$data_json = array();
	$data_json["id"] = $id_usuario;
	$data_json["nombres"] = $nombres;
	$data_json["apellidos"] = $apellidos;			
	$data[]=$data_json;	
}

// obtiene la cantidad de registros
$cantidad_consulta = $con->query("select count(*) as total from usuarios");
$row = $cantidad_consulta->fetch_assoc();
$cantidad['cantidad']=$row['total'];

$json["lista"] = array_values($data);
$json["cantidad"] = array_values($cantidad);

// envia la respuesta en formato json		
header("Content-type:application/json; charset = utf-8");
echo json_encode($json);
exit();
?>