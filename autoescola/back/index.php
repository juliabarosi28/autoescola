<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "autoescola" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}
function readAlunos($con) {
    header("content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM alunos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function readInstrutores($con) {
    header("content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM instrutores");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function readAulas($con) {
    header("content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM aulas");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function createAluno($con){
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
    $data_nascimento = $_POST["data_nascimento"] ?? "";
    try {
        $stmt = $con->prepare("INSERT INTO alunos (nome, email, telefone, data_nascimento) VALUES (?,?,?,?)");
        $stmt -> execute([$nome, $email, $telefone, $data_nascimento]);
        echo "Aluno adicionado com sucesso!";
    }catch(PDOException $e) {
        echo "Erro!";
    }
    exit;
}
function createInstrutor($con){
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
    $categoria_cnh = $_POST["categoria_cnh"] ?? "";
    try {
        $stmt = $con->prepare("INSERT INTO instrutores (nome, email, telefone, categoria_cnh) VALUES (?,?,?,?)");
        $stmt -> execute([$nome, $email, $telefone, $categoria_cnh]);
        echo "Instrutor adicionado com sucesso!";
    }catch(PDOException $e) {
        echo "Erro!";
    }
    exit;
}

if($rota === "create/aluno"){
    createAluno($con);
}elseif($rota === "create/instrutor"){
    createInstrutor($con);
}elseif ($rota === "aulas"){
    readAulas($con);
}elseif ($rota === "instrutores"){
    readInstrutores($con);
}elseif ($rota === "alunos"){
    readAlunos($con);
}else {
    teste();
}
?>