<?php

$servidor = "localhost"; 
$usuario = "root"; 
$senha = ""; 
$BaseDados = "login";

try {
    $conn = new mysqli($servidor, $usuario, $senha, $BaseDados);
    echo "success";

} catch (PDOException $err) {}
