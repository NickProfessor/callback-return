<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . '/../helpers/Logger.php';
require_once __DIR__ . "/../models/Aluno.php";
require_once __DIR__ . '/../models/User.php';

class AlunoController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }


    public function registraAluno($data)
    {
        $aluno = new Aluno(
            $this->conn,
            $data['nome'],
            $data['ra'],
            $data['rm'],
            $data['serie'],
            $data['curso'],
            $data['id_usuario'],
            $data['turma']
        );


        // Verificar se o aluno já existe
        if ($this->alunoExiste($data['id_usuario'])) {
            Logger::log("Aluno já possui cadastro", "ERROR");
        } else {
            $aluno->salvarNoBanco();
        }

        // Se não existir, cadastrar novo aluno

        return ['success' => true, 'message' => 'Aluno registrado com sucesso.'];

    }

    public function alunoExiste($ra)
    {
        return Aluno::existeNoBanco($this->conn, $ra);
    }
}