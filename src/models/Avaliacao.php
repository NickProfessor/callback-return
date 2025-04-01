<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . "/../../src/controllers/UserController.php";
require_once __DIR__ . "/../helpers/Logger.php";


class Avaliacao
{
    private $nota;
    private $id_projeto;
    private $comentario;
    private $id_usuario;
    private $fraseSeguranca;

    public function __construct(int $nota, $id_projeto, $comentario, $id_usuario)
    {
        $this->nota = $nota;
        $this->id_projeto = $id_projeto;
        $this->comentario = $comentario;
        $this->id_usuario = $id_usuario;
    }



    public function avaliaProjeto()
    {
        $userController = new UserController();


        if (trim($this->comentario) === "") {
            $this->comentario = "sem comentario";
        }

        if ($this->usuarioJaAvaliou()) {
            header("Location: ./avaliaProjeto.php?projeto=" . $this->id_projeto . "&erro=ja-avaliado");
            exit();
        } else {
            global $conn;

            $sql = "INSERT INTO avaliacao (id_projeto, id_usuario, data_avaliacao, comentario, nota)
                    VALUES (?, ?, NOW(), ?, ?);";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("iisd", $this->id_projeto, $this->id_usuario, $this->comentario, $this->nota);

                if ($stmt->execute()) {
                    return [
                        'status' => 'success',
                        'message' => 'Avaliação inserida com sucesso.'
                    ];
                } else {
                    Logger::log("Erro ao avaliar o projeto", "ERROR");
                    header("Location: ./avaliaProjeto.php?projeto={$this->id_projeto}&erro=falha-insercao");
                    exit();
                }
            } else {
                header("Location: ./avaliaProjeto.php?projeto={$this->id_projeto}&erro=preparacao-falha");
                exit();
            }
        }

    }


    private function usuarioJaAvaliou()
    {
        global $conn;

        $sql = "SELECT * FROM avaliacao WHERE id_usuario = ? AND id_projeto = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ii", $this->id_usuario, $this->id_projeto);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                die("Erro na execução da consulta: " . $conn->error);
            }
        } else {
            die("Erro na preparação da consulta: " . $conn->error);
        }
    }

    public static function buscaPerguntas()
    {
        global $conn;
        try {
            $sql = "SELECT id_pergunta, texto_pergunta, tipo_pergunta, ordem FROM pergunta WHERE ativo = 1";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Erro ao preparar a query: " . $conn->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a query: " . $stmt->error);
            }

            $resultado = $stmt->get_result();
            $perguntas = [];

            while ($row = $resultado->fetch_assoc()) {
                $perguntas[] = $row;
            }

            return $perguntas;

        } catch (Exception $e) {
            error_log($e->getMessage()); // Registra o erro no log do servidor
            return ['erro' => 'Não foi possível buscar as perguntas.']; // Retorna um erro amigável
        }
    }
}
