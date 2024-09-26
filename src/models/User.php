<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";


class User
{
    private $nome;
    private $dataNasc;
    private $sexo;
    private $fraseSeguranca;

    public function __construct(string $nome, string $dataNasc, string $sexo, string $fraseSeguranca)
    {
        $this->nome = $nome;
        $this->dataNasc = $dataNasc;
        $this->sexo = $sexo;
        $this->fraseSeguranca = $fraseSeguranca;
    }

    public function salvarNoBanco()
    {
        global $conn;
        try {
            $stmt = $conn->prepare("INSERT INTO usuario (nome, sexo, frase_seguranca, data_nascimento) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $this->nome, $this->sexo, $this->fraseSeguranca, $this->dataNasc);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            error_log("Erro ao salvar usuário no banco: " . $e->getMessage());
            return false;
        }
        return true;
    }

    public static function existeNoBanco($nome, $dataNasc, $sexo)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE nome = ? AND data_nascimento = ? AND sexo = ?");
        $stmt->bind_param("sss", $nome, $dataNasc, $sexo);
        $stmt->execute();

        $stmt->bind_result($id);

        if ($stmt->fetch()) {
            $stmt->close();
            return $id; // Retorna o ID do usuário se ele existir
        } else {
            $stmt->close();
            return null; // Retorna null se o usuário não existir
        }
    }

    public static function validaAcesso($id_usuario, $frase)
    {
        global $conn;

        $sql = "SELECT * FROM usuario WHERE id_usuario = ?;";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id_usuario);  // Corrigido para usar $this->id_usuario
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result) {
                $usuario = $result->fetch_assoc();
                if (isset($usuario['frase_seguranca']) && $usuario['frase_seguranca'] == $frase) {
                    return $usuario;
                } else {
                    return false;  // Frase de segurança incorreta
                }
            }
        } else {
            die("Erro na preparação da consulta: " . $conn->error);
        }
    }

}