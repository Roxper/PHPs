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
           isset($_GET['tipo_mantenimiento'])&&
           isset($_GET['ultima_revision']) &&
           //isset($_GET['ultima_revision2']) &&
           isset($_GET['proxima_revision'])) //&&
           //isset($_GET['proxima_revision2']))
        {

            $nombre = $_GET['nombre'];
            $tipo_mantenimiento = $_GET['tipo_mantenimiento'];
            $ultima_revision = $_GET['ultima_revision'];
            //$ultima_revision2 = $_GET['ultima_revision2'];
            $proxima_revision = $_GET['proxima_revision'];
           // $proxima_revision2 = $_GET['proxima_revision2'];

            //* Es un login sin contraseña, ya que solo queremos saber que Escena llama a la BD.

            $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."';"; 
            $resultado = $conn -> query( $sql);

            if($resultado->num_rows > 0)
            {
                // * Si existe un Componente con el nombre      
                // ? Es vital mandar el nombre, el tipo de mantenimiento,  valor de la ultima revision, nuevo valor de la ultima revision, 
                //?         valor de la proxima revision, nuevo valor de la proxima revision
                //$sql = "UPDATE `componentes` SET `ultima_revision` = '".$ultima_revision2."', `proxima_revision` = '".$proxima_revision2."' WHERE nombre = '".$nombre."';"; 
                $sql = "UPDATE `componentes` SET `ultima_revision` = '".$ultima_revision."', 
                    `proxima_revision` = '".$proxima_revision."' WHERE nombre = '".$nombre."' and tipo_mantenimiento = '".$tipo_mantenimiento."' ;"; 
                $conn -> query($sql);

                $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."';"; 
                $resultado = $conn -> query($sql);
                $texto = '';
                    
                while($row = $resultado->fetch_assoc())
                    {
                        $texto = 
                        "{ #id#: ".$row['id'].
                        ", #nombre#:# ".$row['nombre'].
                        "#, #tipo_mantenimiento#:# ".$row['tipo_mantenimiento'].
                        "#, #ultima_revision#: ".$row['ultima_revision'].
                        ", #proxima_revision#: ".$row['proxima_revision'].
                        "}";
                    }                
                echo '{"Codigo": 206, "mensaje": "Fechas actualizadas correctamente.", "respuesta": "'.$texto.'"}';
            }
            else
            {
                // * No existe un Componente con el nombre 
                echo '{"Codigo": 204, "mensaje": "El Componente es incorrecto.", "respuesta": ""}';
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