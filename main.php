<?php

require_once "Horario.php";

$h1 = new Horario(10, 30, 0);

echo $h1->formatar() . PHP_EOL;

$h2 = new Horario(minuto: 45, hora: 8);
echo $h2->formatar() . PHP_EOL;


$h3 = Horario::agora();
echo $h3->formatar() . PHP_EOL;

$h4 = Horario::fromString("15:20:10");
echo $h4->formatar() . PHP_EOL;

$h4->set(segundo: 50);
echo $h4->formatar() . PHP_EOL;

$valores = [12, 59, 30];
$h4->ajustarVarios(...$valores);
echo $h4->formatar() . PHP_EOL;

$h4->tick(90);
echo $h4->formatar() . PHP_EOL;

$resultado = $h1->comparar($h2);
var_dump($resultado);