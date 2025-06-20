<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if(!$conn)
    {
        echo '{"codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
    } else 
    {
        if(isset($_POST['nombre']))
        {

            $nombre = $_POST['nombre'];

            $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."';";
            $resultado = $conn -> query($sql);

            if($resultado->num_rows > 0)
            {
                echo '{"codigo": 202, "mensaje": "El Componente existe en la Base de Datos.", "respuesta": "'.$resultado->num_rows.'"}';
            }
            else
            {
                echo '{"codigo": 203, "mensaje": "El Componente no existe en la Base de Datos.", "respuesta": ""}';
            }
        }
        else
        {
            echo '{"codigo": 402, "mensaje": "Faltan datos para ejecutar la accion solicitada.", "respuesta": ""}';
        }
    }
} catch(Exception $e) 
{
    echo '{"codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
}