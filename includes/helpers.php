<?php 
function mostrarError($errores, $campo) {
    $alerta = '';
    If(isset($errores[$campo]) && !empty($campo)){
        $alerta = "<div class='alerta alerta-error'>" . $errores[$campo] . '</div>';
    }

    return $alerta;
}
function borrarErrores(){
    $borrado = false;
    if(isset($_SESSION['errores'])){
        unset($_SESSION['errores']);
        $borrado = true;
    } 
    if(isset($_SESSION['completado'])){
        unset($_SESSION['completado']);
        $borrado = true;
    }

    return $borrado;

}

?>