<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . "/../helpers/Logger.php";


class Aluno
{
    private $conn;
    private $nome;
    private $ra;
    private $rm;
    private $serie;
    private $turma;
    private $curso;
    private $id_usuario;
    //todo: TERMINAR DE IMPLEMENTAR OS MÉTODOS DE ALUNO

    public function __construct($conn, string $nome, string $ra, string $rm, string $serie, string $curso, string $id_usuario, string $turma = null)
    {
        $this->conn = $conn;
        $this->nome = $nome;
        $this->ra = $ra;
        $this->rm = $rm;
        $this->serie = $serie;
        $this->curso = $curso;
        $this->id_usuario = $id_usuario;
        $this->turma = $turma;
    }

    public static function existeNoBanco($conn, $id_usuario)
    {
        try {
            $stmt = $conn->prepare("SELECT id_aluno FROM aluno WHERE id_usuario = ?");
            if (!$stmt) {
                Logger::log("Erro ao preparar a consulta: " . $conn->error);
            }

            $stmt->bind_param("s", $id_usuario);
            $stmt->execute();
            $stmt->bind_result($id);

            if ($stmt->fetch()) {
                $stmt->close();
                return $id;
            }

            $stmt->close();


            return null;

        } catch (Exception $e) {
            Logger::log("Erro ao consultar aluno: " . $e->getMessage(), "ERROR");
            return null;
        }
    }

    public function salvarNoBanco()
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO aluno (nome, ra, rm, turma, serie, curso, id_usuario ) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                Logger::log("Erro ao preparar a query: " . $this->conn->error);
            }

            $stmt->bind_param(
                "sssssss",
                $this->nome,
                $this->ra,
                $this->rm,
                $this->turma,
                $this->serie,
                $this->curso,
                $this->id_usuario
            );
            $stmt->execute();
            $stmt->close();

            Logger::log("Criou um novo aluno no banco", "ADD");

            return true;

        } catch (Exception $e) {
            Logger::log("Erro ao criar aluno: " . $e->getMessage(), "ERROR");
            return false;
        }
    }
}