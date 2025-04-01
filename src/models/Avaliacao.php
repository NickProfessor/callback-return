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

    private $respostas = [];

    public function __construct(int $nota, $id_projeto, $comentario, $id_usuario)
    {
        $this->nota = $nota;
        $this->id_projeto = $id_projeto;
        $this->comentario = $comentario;
        $this->id_usuario = $id_usuario;
    }



    // public function avaliaProjeto()
    // {
    //     $userController = new UserController();


    //     if (trim($this->comentario) === "") {
    //         $this->comentario = "sem comentario";
    //     }

    //     if ($this->usuarioJaAvaliou()) {
    //         header("Location: ./avaliaProjeto.php?projeto=" . $this->id_projeto . "&erro=ja-avaliado");
    //         exit();
    //     } else {
    //         global $conn;

    //         $sql = "INSERT INTO avaliacao (id_projeto, id_usuario, data_avaliacao, comentario, nota)
    //                 VALUES (?, ?, NOW(), ?, ?);";
    //         $stmt = $conn->prepare($sql);

    //         if ($stmt) {
    //             $stmt->bind_param("iisd", $this->id_projeto, $this->id_usuario, $this->comentario, $this->nota);

    //             if ($stmt->execute()) {
    //                 return [
    //                     'status' => 'success',
    //                     'message' => 'Avaliação inserida com sucesso.'
    //                 ];
    //             } else {
    //                 Logger::log("Erro ao avaliar o projeto", "ERROR");
    //                 header("Location: ./avaliaProjeto.php?projeto={$this->id_projeto}&erro=falha-insercao");
    //                 exit();
    //             }
    //         } else {
    //             header("Location: ./avaliaProjeto.php?projeto={$this->id_projeto}&erro=preparacao-falha");
    //             exit();
    //         }
    //     }

    // }

    public function avaliaProjeto()
{
    $userController = new UserController();

    if (trim($this->comentario) === "") {
        $this->comentario = "sem comentario";
    }

    if ($this->usuarioJaAvaliou()) {
        header("Location: ./avaliaProjeto.php?projeto=" . $this->id_projeto . "&erro=ja-avaliado");
        exit();
    }

    global $conn;

    // Iniciar transação
    $conn->begin_transaction();

    try {
        // Inserir a avaliação
        $sql = "INSERT INTO avaliacao (id_projeto, id_usuario, data_avaliacao, comentario, nota)
                VALUES (?, ?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar a inserção da avaliação: " . $conn->error);
        }

        $stmt->bind_param("iisd", $this->id_projeto, $this->id_usuario, $this->comentario, $this->nota);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir avaliação: " . $stmt->error);
        }

        $id_avaliacao = $conn->insert_id; // Obtém o ID da avaliação inserida
        $stmt->close();

        // Inserir as respostas na tabela 'respostas'
        $sqlRespostas = "INSERT INTO respostas (id_avaliacao, id_pergunta, nota) VALUES (?, ?, ?)";
        $stmtResposta = $conn->prepare($sqlRespostas);

        if (!$stmtResposta) {
            throw new Exception("Erro ao preparar inserção das respostas: " . $conn->error);
        }

        foreach ($this->respostas as $resposta) {
            $stmtResposta->bind_param("iii", $id_avaliacao, $resposta['id_pergunta'], $resposta['nota']);

            if (!$stmtResposta->execute()) {
                throw new Exception("Erro ao inserir resposta: " . $stmtResposta->error);
            }
        }

        $stmtResposta->close();
        $conn->commit(); // Confirmar a transação

        return [
            'status' => 'success',
            'message' => 'Avaliação e respostas registradas com sucesso.'
        ];
    } catch (Exception $e) {
        $conn->rollback(); // Desfaz inserções em caso de erro

        Logger::log("Erro ao avaliar o projeto: " . $e->getMessage(), "ERROR");
        header("Location: ./avaliaProjeto.php?projeto={$this->id_projeto}&erro=falha-insercao");
        exit();
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

    public function adicionarResposta($id_pergunta, $resposta) {
        $this->respostas[] = [
            'id_pergunta' => $id_pergunta,
            'resposta' => $resposta
        ];
    }

    public function salvar() {
        $pdo = new PDO("mysql:host=localhost;dbname=escola_nickollas", "root", "");
    
        $stmt = $pdo->prepare("INSERT INTO avaliacoes (id_projeto, id_usuario, comentario) VALUES (?, ?, ?)");
        $stmt->execute([$this->id_projeto, $this->id_usuario, $this->comentario]);
    
        $id_avaliacao = $pdo->lastInsertId();
    
        $stmtResposta = $pdo->prepare("INSERT INTO respostas (id_avaliacao, id_pergunta, nota) VALUES (?, ?, ?)");
        foreach ($this->respostas as $resposta) {
            $stmtResposta->execute([$id_avaliacao, $resposta['id_pergunta'], $resposta['nota']]);
        }
    }

}
