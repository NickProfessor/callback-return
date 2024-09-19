<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";


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

    private function validaAvaliacao()
    {
        global $conn;

        $sql = "SELECT * FROM usuario WHERE id_usuario = ?;";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $this->id_usuario);  // Corrigido para usar $this->id_usuario
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result) {
                $usuario = $result->fetch_assoc();
                if ($usuario['frase_seguranca'] == $this->fraseSeguranca) {
                    return $usuario;
                } else {
                    return false;  // Frase de segurança incorreta
                }
            }
        } else {
            die("Erro na preparação da consulta: " . $conn->error);
        }
    }

    public function avaliaProjeto()
    {
        $usuario = $this->validaAvaliacao();

        if ($usuario) {
            if($this->comentario === ""){
                $this->comentario = "sem comentario";
            }
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
                    return false;  
                }
            } else {
                die("Erro na preparação da consulta: " . $conn->error);
            }
        } else {
            die("Validação do usuário falhou.");
        }
    }
}
