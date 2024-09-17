<?php

require_once '../models/User.php';

class UserController
{
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

    public function usuarioExiste($nome, $dataNasc, $sexo)
    {
        return User::existeNoBanco($nome, $dataNasc, $sexo);
    }
}
