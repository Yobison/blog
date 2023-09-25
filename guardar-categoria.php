<?php
if(isset($_POST)){

    // Conesxion a la base de datos
    require_once 'includes/conexion.php';

    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;


    //Array de errores:

    $errores = array();

    // Validar los datos antes de guardarlos en la base de datos:

    if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        //echo "el nombre es válido";
        $nombre_validado = true;
    }else{
        $nombre_validado = false;
        $errores['nombre'] = "el nombre no es válido";
    }

    if(count($errores) == 0){
        $sql = "INSERT INTO categorias VALUES(NULL, '$nombre');";
        $guardar = mysqli_query($db, $sql);
    }

}

header("location: index.php");

?>