<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the existing connection script
require_once 'conexao.php';
$con->set_charset("utf8");

// Decode JSON input (but ignore its contents)
json_decode(file_get_contents('php://input'), true);

// New SQL: no WHERE clause
$sql = "SELECT idUsuario, nmUsuario, deEmail, deSenha, cdSexo, cdTipo, dtNascimento, opTermo FROM Usuario";

$result = $con->query($sql);

$response = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row; // ✅ Use as-is, no encoding conversion
    }
} else {
    $response[] = [
        "idUsuario" => 0,
        "nmUsuario" => "",
        "deEmail" => "",
        "deSenha" => "",
        "cdSexo" => 0,
        "cdTipo" => 0,
        "dtNascimento" => "",
        "opTermo" => false
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response, JSON_UNESCAPED_UNICODE); // ✅ ensures UTF-8 chars are preserved

$con->close();
?>
