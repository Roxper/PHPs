<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if(!$conn)
    {
        echo '{"Codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
    } else 
    {
        if(isset($_GET['nombre']) &&
           isset($_GET['tipo_mantenimiento']) &&
           isset($_GET['ultima_revision']) &&
           isset($_GET['proxima_revision']))
        {

            $nombre = $_GET['nombre'];
            $tipo_mantenimiento = $_GET['tipo_mantenimiento'];
            $ultima_revision = $_GET['ultima_revision'];
            $proxima_revision = $_GET['proxima_revision'];

            $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."';";
            $resultado = $conn -> query($sql);

            if($resultado->num_rows > 0)
            {
                echo '{"Codigo": 403, "mensaje": "Ya existe un Componente registrado con ese nombre.", "respuesta": "'.$resultado->num_rows.'"}';
            }
            else
            {
                $sql = "INSERT INTO `componentes` (`id`, `nombre`, `tipo_mantenimiento`, `ultima_revision`, `proxima_revision`) 
                VALUES (NULL, '".$nombre."', '".$tipo_mantenimiento."', '".$ultima_revision."', '".$proxima_revision."');";

                if($conn -> query($sql) === TRUE)
                {
                    $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."';"; 
                    $resultado = $conn -> query($sql);
                    $texto = '';
                    
                    while($row = $resultado->fetch_assoc())
                    {
                        $texto = 
                        "{ #id#:".$row['id'].
                        ", #nombre#:# ".$row['nombre'].
                        "#, #tipo_mantenimiento#:# ".$row['tipo_mantenimiento'].
                        "#, #ultima_revision#:# ".$row['ultima_revision'].
                        ", #proxima_revision#: ".$row['proxima_revision'].
                        "}";
                    }


                    echo '{"Codigo": 201, "mensaje": "Componente Creado Correctamente.", "respuesta": "'.$texto.'"}';
                }
                else
                {
                    echo '{"Codigo": 401, "mensaje": "Error intentando crear al componente.", "respuesta": ""}';
                }
            }            
        }
        else
        {
            echo '{"Codigo": 402, "mensaje": "Faltan datos para ejecutar la accion solicitada.", "respuesta": ""}';
        }
    }
} catch(Exception $e) 
{
    echo '{"Codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
}