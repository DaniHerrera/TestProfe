<?php
function calcularEncuentros($input, $output): void
{
    $estadisticaPorEquipos = array();

    $filas = fopen($input, "r");
    while (!feof($filas)){
        $fila = fgets($filas);
        $datos = explode(';', $fila);
        $local = trim($datos[0]);
        $visitante = trim($datos[1]);
        $resultado = trim($datos[2]);

        if (!isset($estadisticaPorEquipos[$local])) {
            $estadisticaPorEquipos[$local] = array('Team'=>'','MP' => 0, 'W' => 0, 'D' => 0, 'L' => 0, 'P' => 0);
        }

        $estadisticaPorEquipos[$local]['Team'] = $local;
        $estadisticaPorEquipos[$local]['MP'] += 1;
        if ($resultado === 'win') {
            $estadisticaPorEquipos[$local]['W'] += 1;
            $estadisticaPorEquipos[$local]['P'] += 3;
        } elseif ($resultado === 'draw') {
            $estadisticaPorEquipos[$local]['D'] += 1;
            $estadisticaPorEquipos[$local]['P'] += 1;
        } else { //loss
            $estadisticaPorEquipos[$local]['L'] += 1;
        }

        if (!isset($estadisticaPorEquipos[$visitante])) {
            $estadisticaPorEquipos[$visitante] = array('Team'=>'','MP' => 0, 'W' => 0, 'D' => 0, 'L' => 0, 'P' => 0);
        }
        $estadisticaPorEquipos[$visitante]['Team'] = $visitante;
        $estadisticaPorEquipos[$visitante]['MP'] += 1;
        if ($resultado === 'win') {
            $estadisticaPorEquipos[$visitante]['L'] += 1;
        } elseif ($resultado === 'draw') {
            $estadisticaPorEquipos[$visitante]['D'] += 1;
            $estadisticaPorEquipos[$visitante]['P'] += 1;
        } else { //loss
            $estadisticaPorEquipos[$visitante]['W'] += 1;
            $estadisticaPorEquipos[$visitante]['P'] += 3;
        }
    }
    fclose($filas);

    array_multisort(array_column($estadisticaPorEquipos, 'P'), SORT_DESC, array_column($estadisticaPorEquipos, 'Team'), SORT_ASC, $estadisticaPorEquipos);

    $tablaResultados = [
        sprintf("| %s | MP |  W |  D |  L |  P |", str_pad("Team", 30)),
    ];

    foreach ($estadisticaPorEquipos as $equipo => $estadisticas) {
        $fila = sprintf(
            "| %s | %2d | %2d | %2d | %2d | %2d |", str_pad($equipo, 30), $estadisticas['MP'],
            $estadisticas['W'], $estadisticas['D'], $estadisticas['L'], $estadisticas['P']
        );
        $tablaResultados[] = $fila;
    }

    file_put_contents($output, implode("\n", $tablaResultados));

}

if (isset($argv[1]) && isset($argv[2])) {
    $input = $argv[1];
    $output = $argv[2];
    calcularEncuentros($input,$output);
} else {
    echo "Debe proporcionar los nombres de archivo de entrada y salida como argumentos en la línea de comandos.";
}
