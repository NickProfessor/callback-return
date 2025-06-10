<?php

class Logger
{
    private static $logFile = __DIR__ . "/../../logs/db.log"; // Caminho do arquivo de log

    public static function log($mensagem, $tipo = "INFO")
    {
        date_default_timezone_set("America/Sao_Paulo");


        // Garante que o diretório de logs existe
        $logDir = dirname(self::$logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true); // Cria a pasta caso não exista
        }

        // Monta a linha do log
        $dataHora = date("Y-m-d H:i:s");
        $usuarioId = $_SESSION['usuario']['id_usuario'] ?? '???';
        $usuarioNome = $_SESSION['usuario']['nome'] ?? 'desconhecido';
        // Se não houver sessão, marca como 'desconhecido'
        $linhaLog = "[$dataHora] [$tipo] ($usuarioId - $usuarioNome) $mensagem" . PHP_EOL;

        // Escreve no arquivo de log
        file_put_contents(self::$logFile, $linhaLog, FILE_APPEND);
    }
}
