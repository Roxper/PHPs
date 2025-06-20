<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if(!$conn)
    {
        echo '{"Codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
    } else 
    {
        echo '{"Codigo": 200, "mensaje": "Conectado Correctamente.", "respuesta": ""}';
    }
} catch(Exception $e) 
{
    echo '{"Codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
}

include 'footer.php';