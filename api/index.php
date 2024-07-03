<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST,DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$servidor = "localhost";
$usuario = "root";
$senha = "";
$nomeBaseDados = "login";
$conn = new mysqli($servidor, $usuario, $senha, $nomeBaseDados);




if (isset($_GET["cadastrarUsuario"])) {
    $data = json_decode(file_get_contents("php://input"));
    $cpf = $data->cpf ?? '';
    $senha = $data->senha ?? '';
    $nome = $data->nome ?? '';
    $nascimento = $data->nascimento ?? '';
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $nomedb = 'usuarios';


    if (!empty($cpf) && !empty($senhaHash)) {
        $sqlUser = mysqli_query($conn, "INSERT INTO usuarios(cpf, senha, nome, nascimento, nomedb ) VALUES('$cpf', '$senhaHash', '$nome', '$nascimento', '$nomedb')");
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0, "message" => ""]);
    }
    exit();
}




if (isset($_GET["cadastrarEscola"])) {
    $data = json_decode(file_get_contents("php://input"));


    $nome = $data->nome ?? '';
    $endereco = $data->endereco ?? '';
    $nomedb = 'escolas';

    if (!empty($nome) && !empty($endereco)) {
        $sqlUser = mysqli_query($conn, "INSERT INTO escolas(nome, endereco, nomedb) VALUES('$nome', '$endereco', '$nomedb')");
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0, "message" => ""]);
    }
    exit();
}


if (isset($_GET["cadastrarProfessor"])) {
    $data = json_decode(file_get_contents("php://input"));


    $nome = $data->nome ?? '';

    $DropEscola = $data->DropEscola ?? '';
    $cpf = $data->cpf ?? '';
    $dataNascimento = $data->dataNascimento ?? '';
    $senha = $data->senha ?? '';
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $nomedb = 'professores';

    if (!empty($nome) && !empty($senhaHash)) {
        $sqlUser = mysqli_query($conn, "INSERT INTO professores(nome, DropEscola, cpf, dataNascimento, senha, nomedb) VALUES('$nome', '$DropEscola', '$cpf', '$dataNascimento', '$senhaHash', '$nomedb')");
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0, "message" => ""]);
    }
    exit();
}

if (isset($_GET["cadastrarAluno"])) {
    $data = json_decode(file_get_contents("php://input"));
    $nomedb = 'aluno';

    $nome = $data->nome ?? '';

    $DropProf = $data->DropProf ?? '';
    $cpf = $data->cpf ?? '';
    $dataNascimento = $data->dataNascimento ?? '';



    if (!empty($nome) && !empty($cpf)) {
        $sqlUser = mysqli_query($conn, "INSERT INTO aluno(nome, DropProf, cpf, dataNascimento, nomedb) VALUES('$nome', '$DropProf', '$cpf', '$dataNascimento', '$nomedb')");
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0, "message" => ""]);
    }
    exit();
}



if (isset($_GET["Excluir"])) {
    

    $id = intval($_GET["Excluir"]);
    $sqlUser = mysqli_query($conn, "DELETE FROM usuarios WHERE id = $id");

    if ($sqlUser) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0, "message" => "Failed to delete record"]);
    }
    exit();
}





if (isset($_GET["consultar"])) {
    

    $sqlUser = mysqli_query($conn, "SELECT * FROM usuarios WHERE id=" . $_GET["consultar"]);
    if (mysqli_num_rows($sqlUser) > 0) {
        $User = mysqli_fetch_all($sqlUser, MYSQLI_ASSOC);
        echo json_encode($User);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

if (isset($_GET["atualizar"])) {

    $data = json_decode(file_get_contents("php://input"));

    $id = (isset($data->id)) ? $data->id : $_GET["atualizar"];

    $nome = $data->nome;
    $nomedb = $data->nomedb;


    $sqlUser = mysqli_query($conn, "UPDATE $nomedb SET nome='$nome' WHERE id='$id'");
    echo json_encode(["success" => 1]);
    exit();
}


if (isset($_GET["user"])) {


    $sqlUser = mysqli_query($conn, "SELECT * FROM usuarios ");


    if (mysqli_num_rows($sqlUser) > 0) {
        $User = mysqli_fetch_all($sqlUser, MYSQLI_ASSOC);
        echo json_encode($User);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

if (isset($_GET["userEscola"])) {


    $sqlUser = mysqli_query($conn, "SELECT * FROM escolas ");
    if (mysqli_num_rows($sqlUser) > 0) {
        $User = mysqli_fetch_all($sqlUser, MYSQLI_ASSOC);
        echo json_encode($User);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

if (isset($_GET["userProfessor"])) {

    $sqlUser = mysqli_query($conn, "SELECT * FROM professores ");
    if (mysqli_num_rows($sqlUser) > 0) {
        $User = mysqli_fetch_all($sqlUser, MYSQLI_ASSOC);
        echo json_encode($User);
    } else {
        echo json_encode([["success" => 0]]);
    }
}

if (isset($_GET["userAluno"])) {

    $sqlUser = mysqli_query($conn, "SELECT * FROM aluno ");
    if (mysqli_num_rows($sqlUser) > 0) {
        $User = mysqli_fetch_all($sqlUser, MYSQLI_ASSOC);
        echo json_encode($User);
    } else {
        echo json_encode([["success" => 0]]);
    }
}


