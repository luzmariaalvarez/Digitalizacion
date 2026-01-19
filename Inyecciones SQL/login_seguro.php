<?php
/*
 EJEMPLO SEGURO

 SOLUCIÓN:
 - Uso de sentencias preparadas
 - Separación total entre datos y código SQL
*/

$conexion = new mysqli("localhost", "root", "", "tienda");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];

// BIEN: consulta preparada
// Consulta SQL con MARCADORES DE POSICIÓN (?)
// Los ? son "huecos" donde más tarde se colocarán los datos del usuario.
// IMPORTANTE: aquí NO se ponen valores reales, solo la estructura del SQL.
$sql = "SELECT * FROM usuarios 
        WHERE usuario = ? 
        AND contrasena = ?";

// Se prepara la consulta:
// - El servidor SQL recibe la consulta SIN DATOS
// - La analiza y la guarda como una plantilla
$stmt = $conexion->prepare($sql);

// Se asocian los datos del usuario a los ?
// "ss" indica el tipo de datos:
//  s = string (texto)
//  s = string (texto)
// El ORDEN es fundamental:
//  primer ?  : $usuario
//  segundo ? : $contrasena
// Estos valores se envían como DATOS, no como código SQL
$stmt->bind_param("ss", $usuario, $contrasena);

// Se ejecuta la consulta ya completa:
// - El SQL ya estaba definido
// - Los datos se insertan de forma segura
// - La base de datos NO interpreta los datos como código
$stmt->execute();


$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
    echo "Login correcto (seguro)";
} else {
    echo "Usuario o contraseña incorrectos";
}

$stmt->close();
$conexion->close();
?>
