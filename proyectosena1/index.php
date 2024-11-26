<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Imagen y Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            margin: 0;
            padding: 20px;
            overflow-y: auto;
            flex-direction: column;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
            overflow: hidden;
        }
        h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #333;
        }
        video {
            width: 80%;
            height: auto;
            border: 2px solid #007BFF;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        canvas {
            display: none;
        }
        button, input {
            display: block;
            margin: 10px auto;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            width: 90%;
            max-width: 350px;
        }
        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        input {
            border: 1px solid #ccc;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
        }
        input:focus {
            border-color: #007BFF;
            outline: none;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 15px;
            }
            video {
                width: 100%;
                height: auto;
            }
            button, input {
                width: 100%;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Captura de Imagen</h2>
        <video id="video" autoplay></video>
        <button id="capture">Capturar Imagen</button>
        <canvas id="canvas" width="320" height="240"></canvas>

        <h2>Formulario de Registro</h2>
        <form id="formRegistro" method="POST" action="registro.php">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="documento" placeholder="Documento" required>
            <input type="text" name="programa" placeholder="Programa" required>
            <input type="text" name="ficha" placeholder="Ficha" required>
            <input type="text" name="estado" placeholder="Estado" required>
            <input type="number" name="id_area" placeholder="ID del Área" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="text" name="hora_registro" id="horaRegistro" readonly required>
           <input type="text" name="imagen1" id="imagenInput" style="display:none;">
            <button type="submit">Registrar</button>
        </form>

        <button onclick="window.location.href='inicio_sesion.php'">Registrar salida</button>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('capture');
        const imagenInput = document.getElementById('imagenInput');
        const form = document.getElementById('formRegistro');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((error) => {
                console.error("Error al acceder a la cámara:", error);
                alert("No se pudo acceder a la cámara.");
            });

        captureButton.addEventListener('click', async () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageBase64 = canvas.toDataURL('image/png');

            imagenInput.value = imageBase64;

            alert("Imagen capturada y lista para registrar.");
        });

        const fecha = new Date();
        const formatoHora = `${fecha.getFullYear()}-${(fecha.getMonth() + 1).toString().padStart(2, '0')}-${fecha.getDate().toString().padStart(2, '0')} ${fecha.getHours().toString().padStart(2, '0')}:${fecha.getMinutes().toString().padStart(2, '0')}:${fecha.getSeconds().toString().padStart(2, '0')}`;
        document.getElementById('horaRegistro').value = formatoHora;
    </script>
</body>
</html>
