<?php

// Función de interpolación de Newton
function interpolacionNewton($x, $fx) {
    $n = count($x); // número de puntos
    $coeff = []; // coeficientes del polinomio

    // Inicializar los coeficientes con los valores de y (fx)
    for ($i = 0; $i < $n; $i++) {
        $coeff[$i] = $fx[$i];
    }

    // Calcular los coeficientes divididos
    for ($j = 1; $j < $n; $j++) {
        for ($i = $n - 1; $i >= $j; $i--) {
            $coeff[$i] = ($coeff[$i] - $coeff[$i - 1]) / ($x[$i] - $x[$i - $j]);
        }
    }

    // Construir el polinomio como una cadena
    $polinomio = '';
    for ($i = 0; $i < $n; $i++) {
        if ($i > 0) {
            $polinomio .= ' + ';
        }
        $polinomio .= $coeff[$i];
        for ($j = 0; $j < $i; $j++) {
            $polinomio .= ' * (x - ' . $x[$j] . ')';
        }
    }

    return $polinomio;
}

// Obtener los datos de x y fx del POST
$x = $_POST['x']; // array de valores de x (timestamps)
$fx = $_POST['fx']; // array de valores de fx

// Calcular el polinomio de interpolación de Newton
$polinomio = interpolacionNewton($x, $fx);

// Devolver el resultado como texto
echo $polinomio;

?>