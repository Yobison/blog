<?php
// iniciar la sesión y la conexión a la base de datos

require_once 'includes/conexion.php';

// recoger los datos del formulario

if(isset($_POST)){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // consulta para comprobar las credenciales del usuario

    $sql = "SELECT * FROM usuarios WHERE email ='$email'";
    $login = mysqli_query($db, $sql);

    if($login && mysqli_num_rows($login) == 1){
        $usuario = mysqli_fetch_assoc($login);

        // comprobar la contraseña

        $verify = password_verify($password, $usuario['password']);

        if($verify){
            // utilizar una sesión para guardar los datos del usuario logueado
            $_SESSION['usuario'] = $usuario;

            if(isset($_SESSION['error_login'])){
                unset($_SESSION['error_login']);
            }
        }else{
            // si algo falla enviar una sesión con el fallo
            $_SESSION['error_login'] = "Login incorrecto!!!";
        }
    }else{
        //mensaje de error
        $_SESSION['error_login'] = "Login incorrecto!!!";
    }

}
// redirigir al index.php

header('location: index.php');



?>