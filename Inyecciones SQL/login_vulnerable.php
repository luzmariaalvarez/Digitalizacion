<?php
/*
 EJEMPLO VULNERABLE A INYECCIÓN SQL
 PROBLEMA:
 - Se construye la consulta SQL concatenando directamente
   los datos que introduce el usuario.
 - El servidor NO distingue entre datos y código SQL.
*/

$conexion = new mysqli("localhost", "root", "", "tienda");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];

// MAL: concatenación directa de datos del usuario en la consulta SQL
// Aquí se están metiendo las variables $usuario y $contrasena
// directamente dentro del texto SQL.
$sql = "SELECT * FROM usuarios 
        WHERE usuario = '$usuario' 
        AND contrasena = '$contrasena'";

// En este momento, PHP ya ha sustituido las variables por el texto
// que haya escrito el usuario (SIN comprobar si es seguro o no).

// Se envía la consulta completa a la base de datos
// La base de datos NO sabe qué parte era código
// y qué parte venía del usuario.
$resultado = $conexion->query($sql);


if ($resultado && $resultado->num_rows > 0) {
    echo "Login correcto (pero inseguro)";
} else {
    echo "Usuario o contraseña incorrectos";
}

$conexion->close();
?>
