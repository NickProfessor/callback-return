<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações do banco de dados
define('DB_HOST', '108.167.151.51');
define('DB_USER', 'progro40_etec_expodev');
define('DB_PASS', 'Expot1n@24!');
define('DB_NAME', 'progro40_etec_expotin');

