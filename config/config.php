<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '&tec77@info!');
define('DB_NAME', 'callback_bd');

