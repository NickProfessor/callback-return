<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . "/../../src/controllers/UserController.php";


class Avaliacao
{
    private $nota;
    private $id_projeto;
    private $comentario;
    private $id_usuario;
    private $fraseSeguranca;

    public function __construct($nota, $id_projeto, $comentario, $id_usuario, $fraseSeguranca)
    {
        $this->nota = $nota;
        $this->id_projeto = $id_projeto;
        $this->comentario = $comentario;
        $this->id_usuario = $id_usuario;
        $this->fraseSeguranca = $fraseSeguranca;
    }



    public function avaliaProjeto()
    {
        $userController = new UserController();
        $usuario = $userController->validaUsuario($this->id_usuario, $this->fraseSeguranca);

        if ($usuario) {
            if (empty($this->comentario)) {
                $this->comentario = "sem comentario";
            }
            if ($this->usuarioJaAvaliou()) {
                return false;
            } else {
                global $conn;

                $sql = "INSERT INTO avaliacao (id_projeto, id_usuario, data_avaliacao, comentario, nota)
                        VALUES (?, ?, NOW(), ?, ?);";  // NOW() para a data atual
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Ajuste no bind_param para passar os parâmetros corretos
                    $stmt->bind_param("iisd", $this->id_projeto, $this->id_usuario, $this->comentario, $this->nota);

                    if ($stmt->execute()) {
                        return true;
                    } else {
                        throw new Exception("Falha ao inserir avaliação: " . $stmt->error);
                    }
                } else {
                    die("Erro na preparação da consulta: " . $conn->error);
                }
            }
        } else {
            return false;
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
}
