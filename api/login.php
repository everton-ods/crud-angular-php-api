<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['cpf']) && isset($data['senha'])) {
    $cpf = $data['cpf'];
    $senha = $data['senha'];
    
    // Substitua pelos seus detalhes de conexão ao banco de dados
    $servidor = "localhost";
    $usuario = "root";
    $senhaDB = "";
    $nomeBaseDados = "login";
    $conn = new mysqli($servidor, $usuario, $senhaDB, $nomeBaseDados);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Busque o hash da senha no banco de dados
    $sql = "SELECT id, senha FROM usuarios WHERE cpf = '$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashSenha = $row['senha'];

        // Verifique a senha
        if (password_verify($senha, $hashSenha)) {
            echo json_encode(["message" => "Login successful", "id" => $row['id']]);
        } else {
            echo json_encode(["message" => "Invalid CPF or password"]);
        }
    } else {
        echo json_encode(["message" => "Invalid CPF or password"]);
    }

    $conn->close();
} else {
    echo json_encode(["message" => "Invalid input"]);
}
?>
