<?php

// Ejemplo de conversión de fecha a número usando formato específico
$fecha = "2024-06-12";
$numero_fecha = (int)str_replace('-', '', $fecha); // Convierte "2024-06-27" a 20240627

// Mostrar resultados
echo "Fecha: " . $fecha . "<br>";
echo "Número de fecha: " . $numero_fecha;

?>
