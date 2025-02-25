<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once '../models/User.php';

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
            $data['nome'],
            $data['dataNasc'],
            $data['sexo'],
            $data['fraseSeguranca'],
        );


        // Verificar se o usuário já existe
        if ($this->usuarioExiste($data['nome'], $data['dataNasc'], $data['sexo'])) {
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
        return User::validaAcesso($id, $frase);
    }
}
