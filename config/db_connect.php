<?php
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die('Erro de conexão: ' . $mysqli->connect_error);
}

echo 'Conexão bem-sucedida!';
