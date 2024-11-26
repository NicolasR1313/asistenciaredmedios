<?php
$servername = "localhost";
$username = "u566651163_Nicolas";
$password = "Semeolvido1011.";
$database = "u566651163_reconocimiento";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST)) {
            throw new Exception("No se recibieron datos en el formulario.");
        }

        $nombre = $_POST['nombre'] ?? null;
        $apellido = $_POST['apellido'] ?? null;
        $documento = $_POST['documento'] ?? null;
        $programa = $_POST['programa'] ?? null;
        $ficha = $_POST['ficha'] ?? null;
        $estado = $_POST['estado'] ?? null;
        $id_area = $_POST['id_area'] ?? null;
        $email = $_POST['email'] ?? null;
        $hora_registro = $_POST['hora_registro'] ?? null;
        $imagen_url = $_POST['imagen1'] ?? null;

        if (!$nombre || !$apellido || !$documento || !$programa || !$ficha || !$estado || !$id_area || !$email || !$hora_registro) {
            throw new Exception("Por favor, complete todos los campos obligatorios.");
        }

        $conn->beginTransaction();

        $sqlUsuario = "INSERT INTO usuarios (nombre, apellido, documento, programa, ficha, estado, id_area, email, hora_registro, imagen1) 
                       VALUES (:nombre, :apellido, :documento, :programa, :ficha, :estado, :id_area, :email, :hora_registro, :imagen1)";
        $stmtUsuario = $conn->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':nombre', $nombre);
        $stmtUsuario->bindParam(':apellido', $apellido);
        $stmtUsuario->bindParam(':documento', $documento);
        $stmtUsuario->bindParam(':programa', $programa);
        $stmtUsuario->bindParam(':ficha', $ficha);
        $stmtUsuario->bindParam(':estado', $estado);
        $stmtUsuario->bindParam(':id_area', $id_area);
        $stmtUsuario->bindParam(':email', $email);
        $stmtUsuario->bindParam(':hora_registro', $hora_registro);
        $stmtUsuario->bindParam(':imagen1', $imagen_url);

        $stmtUsuario->execute();
        $usuarioId = $conn->lastInsertId();

        $conn->commit();

        header("Location: index.php");
        exit();
    }
} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
