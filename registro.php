<?php 


if(isset($_POST)){
    // conexion base de datos
    require_once 'includes/conexion.php';

    if(!isset($_SESSION)){
        session_start();
    }
    

    // Recoger los valores del formulario del registro:

    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

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
    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
        $apellidos_validado = true;
    }else{
        $apellidos_validado = false;
        $errores['apellidos'] = "los apellidos no son válidos";
    }
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_validado = true;
    }else{
        $email_validado = false;
        $errores['email'] = "el email no es válido";
    }
    if(!empty($password)) {
        $password_validado = true;
    }else{
        $password_validado = false;
        $errores['password'] = "la contraseña está vacia.";
    }

    $guardar_usuario = false;
    if(count($errores) == 0){
        $insertar_usuario = true;

        //Cifrar la contraseña

        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost' =>4]);
        /*var_dump($password);
        var_dump($password_segura);
        var_dump(password_verify($password, $password_segura));
        die();*/

        // Insertar usuarios en la tabla usuarios de la base de datos
        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE())";
        $guardar = mysqli_query($db, $sql);
        if($guardar) {
            $_SESSION['completado'] = "El registro se ha completado con éxito";
        }else{
            $_SESSION['errores']['general'] = "fallo al guardar el usuario!!";
        }


    }else{
        $_SESSION['errores'] = $errores;
    }
}
header('location: index.php');
?>