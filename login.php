<?php
include 'header.php';

try {
    $conn = mysqli_connect($db_servidor, $db_usuario, $db_pass, $db_baseDatos);
    if(!$conn)
    {
        echo '{"codigo": 400, "mensaje": "Error intentando Conectar.", "respuesta": ""}';
    } else 
    {
        if(isset($_POST['nombre'])&&
           isset($_POST['tipo_mantenimiento']))
        {

            $nombre = $_POST['nombre'];
            $tipo_mantenimiento = $_POST['tipo_mantenimiento'];

            //* Es un login sin contraseña, ya que solo queremos saber que Escena llama a la BD.
            $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."' and tipo_mantenimiento = '".$tipo_mantenimiento."' ;"; 
            $resultado = $conn -> query($sql);

            if($resultado->num_rows > 0)
            {
                // * Si existe un Componente con el nombre 
                $sql = "SELECT * FROM `componentes` WHERE nombre = '".$nombre."';"; 
                $resultado = $conn -> query($sql);
                $texto = '';
                    
                while($row = $resultado->fetch_assoc())
                    {
                        $texto = 
                        "{ #id#: ".$row['id'].
                        ", #nombre#:#".$row['nombre'].
                        "#, #tipo_mantenimiento#:#".$row['tipo_mantenimiento'].
                        "#, #ultima_revision#:#".$row['ultima_revision'].
                        "#, #proxima_revision#:#".$row['proxima_revision'].
                        "#}";
                    }                
                echo '{"codigo": 205, "mensaje": "Vinculacion al componente exitoso.", "respuesta": "'.$texto.'"}';
            }
            else
            {
                // * No existe un Componente con el nombre 
                echo '{"codigo": 204, "mensaje": "El Componente es incorrecto.", "respuesta": ""}';
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