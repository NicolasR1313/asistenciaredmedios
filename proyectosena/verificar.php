<?php
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $imagenData = $_POST['imagen'];

   
    $sql = "SELECT imagen_facial FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagenBase = $row['imagen_facial'];

        
        $imagenData = str_replace('data:image/png;base64,', '', $imagenData);
        $imagenData = str_replace(' ', '+', $imagenData);
        $imagenCapturada = base64_decode($imagenData);

        
        
        $esIgual = compararImagenes($imagenBase, $imagenCapturada);

        if ($esIgual) {
            echo "Inicio de sesión exitoso. Bienvenido!";
        } else {
            echo "Error: La imagen no coincide.";
        }
    } else {
        echo "Error: Correo electrónico no encontrado.";
    }
}
$conn->close();


function compararImagenes($imagen1, $imagen2) {
    
    return true; /
}
?>
