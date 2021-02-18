<?php 
require 'classes.php';

$produtos = new Produtos();
$produtos->getLista();

//$produtos->setOrder(new IdOrder());
//$data = produtos->getArray();


//Define um tipo de saída
$produtos->setOutput(new JsonOutput());
//$produtos->setOutput(new ArrayOutput());

$data = $produtos->getOutput();

print_r($data);