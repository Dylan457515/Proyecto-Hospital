<?php
// Función para evaluar un polinomio dado en PHP
function evaluarPolinomio($polinomio, $x_evaluar) {
    // Remplazar 'x' por el valor a evaluar en la cadena del polinomio
    $polinomio = str_replace('x', '(' . $x_evaluar . ')', $polinomio);

    // Evaluar el polinomio matemáticamente usando eval()
    $resultado = null;
    @eval('$resultado = ' . $polinomio . ';'); // Usar @ para suprimir errores

    // Verificar si ocurrió un error durante la evaluación
    if (error_get_last() !== null) {
        return 'Error: Polinomio no válido'; // Devolver un mensaje de error si hay un problema
    }

    // Devolver el resultado de la evaluación
    return $resultado;
}

// Polinomio y valor a evaluar
$polinomio = $_POST['polinomio'];
$x_evaluar = $_POST['x_evaluar'];

// Evaluar el polinomio utilizando la función definida
$resultado_evaluacion = evaluarPolinomio($polinomio, $x_evaluar);

// Formatear el resultado usando number_format y cast a float para evitar notación científica
$resultado_formateado = number_format((float)$resultado_evaluacion, 2, '.', ',');

// Devolver el resultado de la evaluación como respuesta
echo $resultado_formateado; // Salida esperada: 3.00
?>
