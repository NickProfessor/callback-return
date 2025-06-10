<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }


    public function registraUsuario($data)
    {
        $user = new User(
            $this->conn,
            $data['nome'],
            $data['email'],
            $data['dataNasc'],
            $data['sexo'],
            $data['fraseSeguranca'],
            $data['foto'] ?? null,
            $data['tipo_usuario'] ?? 1
        );


        // Verificar se o usuário já existe
        if ($this->usuarioExiste($data['email'])) {
            return ['success' => false, 'message' => 'Usuário já cadastrado.'];
        }

        // Se não existir, cadastrar novo usuário
        $user->salvarNoBanco();
        return ['success' => true, 'message' => 'Usuário registrado com sucesso.'];

    }

    public function usuarioExiste($email)
    {
        return User::existeNoBanco($this->conn, $email);
    }

    public function validaUsuario($id, $frase)
    {
        return User::validaAcesso($this->conn, $id, $frase);
    }

    public function consultaDadosDoUsuario($id)
    {
        return User::consultaDados($this->conn, $id);
    }

    // public static function logout()
    // {
    //     session_unset();
    //     session_destroy();
    //     header("Location: ../../index.php?voce-foi-desconectado"); // 🔹 Redireciona para a página de login após logout
    //     exit;
    // }
}
