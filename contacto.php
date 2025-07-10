<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = strip_tags(trim($_POST["nombre"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $mensaje = strip_tags(trim($_POST["mensaje"]));

        if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Datos inválidos. Por favor, completá el formulario correctamente.";
            exit;
        }

        $destinatario = "teofernandez@teofernandez.com.ar";
        $asunto = "Nuevo mensaje desde tu portafolio web";

        $contenido = "Nombre: $nombre\n";
        $contenido .= "Email: $email\n\n";
        $contenido .= "Mensaje:\n$mensaje\n";

        $cabeceras = "From: $nombre <$email>";

        if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
            http_response_code(200);
            echo "Mensaje enviado correctamente.";
        } else {
            http_response_code(500);
            echo "Hubo un problema al enviar el mensaje.";
        }
        } else {
        http_response_code(403);
        echo "Acceso no permitido.";
    }
?>
