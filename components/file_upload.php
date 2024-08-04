<?php
function fileUpload($picture, $source = "user")
{
    $uploadDir = "../images/";  // Directorio de subida

    // Crear el directorio si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($picture["error"] == 4) {
        // No se ha seleccionado ningún archivo
        $pictureName = "user.png";
        $message = "No picture has been chosen, but you can upload an image later :)";
    } else {
        // Comprobar si el archivo es una imagen
        if (isset($picture["tmp_name"]) && file_exists($picture["tmp_name"])) {
            $checkIfImage = getimagesize($picture["tmp_name"]); // Comprobar si el archivo es una imagen
            $message = $checkIfImage ? "Ok" : "Not an image";
        } else {
            $message = "File upload error or file does not exist";
        }

        if ($message == "Ok") {
            $ext = strtolower(pathinfo($picture["name"], PATHINFO_EXTENSION)); // Obtener la extensión
            $pictureName = uniqid("") . "." . $ext; // Generar un nombre único
            $destination = $uploadDir . $pictureName;  // Ruta de destino

            if (move_uploaded_file($picture["tmp_name"], $destination)) {
                if ($source == "product") {
                    $destination = "./images/{$pictureName}";
                }
            } else {
                $message = "Failed to move uploaded file.";
                $pictureName = "user.png";  // Nombre predeterminado en caso de fallo
            }
        }
    }

    return [$pictureName, $message]; // Devolver el nombre de la imagen y el mensaje
}
