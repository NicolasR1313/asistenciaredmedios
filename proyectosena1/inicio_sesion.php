<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro con Captura de Imagen</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            box-sizing: border-box;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        video {
            border: 3px solid #007BFF;
            border-radius: 8px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 320px;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        input {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            width: 100%;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Captura de Imagen</h2>
        <video id="video" autoplay></video>
        <button id="capture">Capturar Imagen y Registrar Hora</button>
        <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

        <h2>Formulario de Registro</h2>
        <form id="formRegistro" method="POST" action="registro1.php">
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="text" name="hora_salida" id="horaSalida" placeholder="Hora de Salida" readonly>
            <input type="hidden" name="imagen" id="imagenInput">
            <button type="submit">Registrar Salida</button>
        </form>
    </div>

    <div class="footer">
        <p>© 2024 Todos los derechos reservados</p>
    </div>

    <script>
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                document.getElementById('video').srcObject = stream;
            })
            .catch((error) => {
                console.error("Error al acceder a la cámara:", error);
                alert("No se pudo acceder a la cámara.");
            });

        document.getElementById('capture').addEventListener('click', () => {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const video = document.getElementById('video');

            context.drawImage(video, 0, 0, 320, 240);
            const imageData = canvas.toDataURL('image/png');
            document.getElementById('imagenInput').value = imageData;

            const fecha = new Date();
            const año = fecha.getFullYear();
            const mes = String(fecha.getMonth() + 1).padStart(2, '0');
            const dia = String(fecha.getDate()).padStart(2, '0');
            const horas = String(fecha.getHours()).padStart(2, '0');
            const minutos = String(fecha.getMinutes()).padStart(2, '0');
            const segundos = String(fecha.getSeconds()).padStart(2, '0');
            const horaActual = `${año}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;

            document.getElementById('horaSalida').value = horaActual;

            alert("Imagen capturada y hora registrada con éxito.");
        });
    </script>
</body>
</html>
