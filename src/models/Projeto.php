<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . "/../helpers/Logger.php";
require_once __DIR__ . "/../controllers/AlunoController.php";

class Projeto
{
    private $nome;
    private $resumo;
    private $descricao;
    private $materialApoio;

    private $temas = [];
    private $cursos = [];
    private $alunos = [];
    private $listaDeProjetos = [];
    private $id_projeto;

    public function __construct($nome, $resumo, $descricao, $temas, $cursos, $alunos, $materialApoio, $id_projeto = null)
    {
        $this->nome = $nome;
        $this->resumo = $resumo;
        $this->descricao = $descricao;
        $this->temas = $temas;
        $this->cursos = $cursos;
        $this->alunos = $alunos;
        $this->materialApoio = $materialApoio;
        $this->id_projeto = $id_projeto;
    }

    public static function carregaProjetos()
    {
        global $conn;
        $sql = "SELECT 
        p.id_projeto,
        p.nome AS projeto_nome,
        p.resumo AS projeto_resumo,
        p.descricao AS projeto_descricao,
        
        GROUP_CONCAT(DISTINCT c.nome) AS cursos,
        GROUP_CONCAT(DISTINCT i.nome) AS alunos,
        GROUP_CONCAT(DISTINCT t.nome) AS temas,

        COALESCE(a.total_avaliacoes, 0) AS total_avaliacoes,
        COALESCE(a.media_notas, 0) AS media_notas

    FROM 
        projeto p
        LEFT JOIN curso_has_projeto chp ON p.id_projeto = chp.projeto_id_projeto
        LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
        LEFT JOIN aluno_has_projeto ihp ON p.id_projeto = ihp.id_projeto
        LEFT JOIN aluno i ON ihp.id_aluno = i.id_aluno
        LEFT JOIN tema_has_projeto pht ON p.id_projeto = pht.projeto_id_projeto
        LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema

        LEFT JOIN (
            SELECT 
                a.id_projeto,
                COUNT(a.id_avaliacao) AS total_avaliacoes,
                AVG(a.nota) AS media_notas
            FROM 
                avaliacao a
            GROUP BY a.id_projeto
        ) a ON p.id_projeto = a.id_projeto

    WHERE p.ativo = 1

    GROUP BY 
        p.id_projeto, p.nome, p.resumo, p.descricao;
    ";

        $result = $conn->query($sql);

        if ($result) {
            $projetos = $result->fetch_all(MYSQLI_ASSOC);
            $projetos = array_reverse($projetos);
            return $projetos;
        } else {
            die("Algo deu errado na consulta dos projetos");
        }
    }





    public static function obterProjetoPeloId($id)
    {
        global $conn;

        $sql = "SELECT * FROM projeto WHERE id_projeto = ? AND ativo = 1;";
        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param("i", $id);
            $stmt->execute();


            $result = $stmt->get_result();
            if ($result) {
                $projeto = $result->fetch_assoc();
                return $projeto;
            } else {
                die("Projeto com ID $id não encontrado.");
            }
        } else {
            die("Erro na preparação da consulta: " . $conn->error);
        }
    }

    public static function obterDetalhesDoProjeto($id)
    {
        global $conn;
        $sql = "SELECT 
        p.id_projeto,
        p.nome AS projeto_nome,
        p.descricao AS projeto_descricao,
        p.resumo AS projeto_resumo,
        p.material_apoio AS projeto_material_apoio,
        GROUP_CONCAT(DISTINCT c.nome) AS cursos,
        GROUP_CONCAT(DISTINCT i.nome) AS alunos,
        GROUP_CONCAT(DISTINCT t.nome) AS temas,
        
        COALESCE(ag.total_avaliacoes, 0) AS total_avaliacoes,
        COALESCE(ag.media_notas, 0) AS media_notas,
        
        GROUP_CONCAT(DISTINCT a.comentario SEPARATOR ' | ') AS comentarios

    FROM 
        projeto p
        LEFT JOIN curso_has_projeto chp ON p.id_projeto = chp.projeto_id_projeto
        LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
        LEFT JOIN aluno_has_projeto ihp ON p.id_projeto = ihp.id_projeto
        LEFT JOIN aluno i ON ihp.id_aluno = i.id_aluno
        LEFT JOIN tema_has_projeto pht ON p.id_projeto = pht.projeto_id_projeto
        LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema
        
        LEFT JOIN (
            SELECT 
                a.id_projeto,
                COUNT(a.id_avaliacao) AS total_avaliacoes,
                AVG(a.nota) AS media_notas
            FROM 
                avaliacao a
            GROUP BY a.id_projeto
        ) ag ON p.id_projeto = ag.id_projeto

        LEFT JOIN avaliacao a ON p.id_projeto = a.id_projeto

    WHERE 
        p.id_projeto = ? 

    GROUP BY 
        p.id_projeto, p.nome, p.descricao, p.resumo, p.material_apoio;";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $projeto = $result->fetch_assoc();

                return $projeto;
            } else {
                die("Algo deu errado na consulta do projeto");
            }
        } else {
            die("Algo deu errado na preparação da consulta do projeto");
        }
    }


    public function cadastraProjeto()
    {
        global $conn;

        // Inicia uma transação
        $conn->begin_transaction();

        try {
            if (!$this->projetoJaExiste()) {

                $projetoId = $this->criaProjeto();

                if (!$projetoId) {
                    Logger::log("Erro ao criar o projeto.", "ERROR");
                }

                $this->registraCursosDoProjeto($projetoId);
                $this->registraTemasDoProjeto($projetoId);
                $this->registraAlunosDoProjeto($projetoId);

                // Se tudo deu certo, fazemos o commit da transação
                $conn->commit();
                $this->registrarNotaAutomatica($projetoId);
                Logger::log("Projeto $projetoId cadastrado com sucesso! ", "ADD");
            } else {
                header("Location: ./criarProjetos.php?erro=projeto-ja-existe");
            }
        } catch (Exception $e) {
            // Se qualquer erro ocorrer, desfazemos a transação
            $conn->rollback();
            Logger::log("Erro ao cadastrar projeto: " . $e->getMessage(), "ERROR");
            header("Location: ./criarProjetos.php?erro=nao-foi-possivel-adicionar");
        }
    }


    private function registraCursosDoProjeto($idProjeto)
    {
        global $conn;
        $sql = "INSERT INTO curso_has_projeto (curso_id_curso, projeto_id_projeto) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            Logger::log("Erro ao preparar consulta: " . $conn->error, "ERROR");
        }

        $cursos = $this->cursos;
        foreach ($cursos as $idCurso) {
            $stmt->bind_param("ii", $idCurso, $idProjeto);
            if (!$stmt->execute()) {
                $stmt->close();
                Logger::log("Erro ao registrar cursos: " . $stmt->error, "ERROR");
            }
        }

        $stmt->close();
    }
    private function registraTemasDoProjeto($idProjeto)
    {
        global $conn;
        $sql = "INSERT INTO tema_has_projeto (tema_id_tema, projeto_id_projeto) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            Logger::log("Erro ao preparar consulta: " . $conn->error, "ERROR");
        }

        $temas = $this->temas;
        foreach ($temas as $idTema) {
            $stmt->bind_param("ii", $idTema, $idProjeto);
            if (!$stmt->execute()) {
                $stmt->close();
                Logger::log("Erro ao registrar temas: " . $stmt->error, "ERROR");
            }
        }

        $stmt->close();
    }

    private function criaProjeto()
    {
        $nomeDoProjeto = $this->nome;
        $resumoDoProjeto = $this->resumo;
        $descricaoDoProjeto = $this->descricao;
        $materialApoio = $this->materialApoio;

        global $conn;

        $stmt = $conn->prepare("INSERT INTO projeto (nome, resumo, descricao, material_apoio) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssss", $nomeDoProjeto, $resumoDoProjeto, $descricaoDoProjeto, $materialApoio);

        if ($stmt->execute()) {
            $insertId = $conn->insert_id; // Retorna o ID do projeto inserido
            $stmt->close();
            return $insertId;
        } else {
            $stmt->close();
            return false; // Retorna false em caso de erro
        }
    }





    private function registraAlunosDoProjeto($id_projeto)
    {
        global $conn;
        $alunos = $this->alunos;

        foreach ($alunos as $idAluno) {

            if ($idAluno) {
                $query = "INSERT INTO aluno_has_projeto (id_aluno, id_projeto) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    Logger::log("Erro na preparação da consulta (registraAlunosDoProjeto): " . $conn->error, "ERROR");
                    return;
                }
                $stmt->bind_param("ii", $idAluno, $id_projeto);

                if (!$stmt->execute()) {
                    $stmt->close();
                    Logger::log("Erro ao registrar aluno na tabela de relacionamentos.", "ERROR");
                    return;
                }
                $stmt->close();
            } else {
                Logger::log("Algo deu errado ao encontrar aluno no banco.", "ERROR");
                return;
            }
        }
    }


    private function verificaAluno($aluno)
    {
        $id_aluno = $aluno['id_aluno'];
        global $conn;
        $query = "SELECT COUNT(*) FROM aluno WHERE id_aluno = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $id_aluno);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0; // Verifica se o aluno já existe
    }


    private function pegaIDAluno($nomeAluno)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id_aluno FROM aluno WHERE nome = ?");
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $nomeAluno);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $stmt->close();
            return $row['id_aluno'];
        } else {
            $stmt->close();
            return null; // Se o aluno não for encontrado
        }
    }


    private function projetoJaExiste()
    {
        global $conn;
        if (!$this->id_projeto) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM projeto WHERE nome = ? AND ativo = 1");
            if (!$stmt) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("s", $this->nome);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
        } else {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM projeto WHERE id_projeto = ? AND ativo = 1");
            if (!$stmt) {
                die("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $this->id_projeto);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
        }
        $stmt->close();

        return $count > 0; // Verifica se o projeto já existe
    }


    private function registrarNotaAutomatica($id_projeto)
    {
        global $conn;

        // Prepare a consulta para inserir a nota automática
        $sql = "INSERT INTO avaliacao (id_projeto, id_usuario, data_avaliacao, nota, comentario) VALUES (?, ?, NOW(), ?, 'sem comentario')";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $nota = 10;
        $id_usuario = 1; // Substitua pelo ID do usuário apropriado
        $stmt->bind_param("iii", $id_projeto, $id_usuario, $nota);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Nota registrada com sucesso
        } else {
            $stmt->close();
            die("Erro ao registrar a nota: " . $stmt->error);
        }
    }

    public static function buscaTemasDoBanco()
    {
        global $conn;
        $sql = "SELECT id_tema, nome FROM tema;"; // Certifique-se de que o campo 'id' existe na sua tabela
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Algo de errado aconteceu na preparação da consulta de temas: " . $conn->error);
        }

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $listaDeTemas = []; // Array para armazenar os IDs e nomes dos temas
            while ($row = $resultado->fetch_assoc()) {
                $listaDeTemas[$row['id_tema']] = $row['nome']; // Adiciona o ID e o nome ao array
            }
            $stmt->close();
            return $listaDeTemas; // Retorna o array associativo com IDs como chaves e nomes como valores
        } else {
            $stmt->close();
            die("Erro ao buscar os temas: " . $stmt->error);
        }
    }


    public static function buscaCursosDoBanco()
    {
        global $conn;
        $sql = "SELECT id_curso, nome FROM curso;"; // Certifique-se de que o campo 'id' existe na sua tabela
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Algo de errado aconteceu na preparação da consulta de cursos: " . $conn->error);
        }

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $listaDeCursos = []; // Array para armazenar os IDs e nomes dos temas
            while ($row = $resultado->fetch_assoc()) {
                $listaDeCursos[$row['id_curso']] = $row['nome']; // Adiciona o ID e o nome ao array
            }
            $stmt->close();
            return $listaDeCursos; // Retorna o array associativo com IDs como chaves e nomes como valores
        } else {
            $stmt->close();
            die("Erro ao buscar os cursos: " . $stmt->error);
        }
    }

    public static function excluiProjeto($id_projeto)
    {
        global $conn;

        $sql = "UPDATE projeto SET ativo = 0 WHERE id_projeto = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            Logger::log("Erro na preparação da consulta: " . $conn->error, "ERROR");
            die("Erro na preparação da consulta: " . $conn->error);
        }


        $stmt->bind_param("i", $id_projeto);

        if ($stmt->execute()) {
            Logger::log("Projeto $id_projeto foi excluído com sucesso", "DELETE");
            $stmt->close();
        } else {
            $stmt->close();
            Logger::log("Erro ao excluir projeto $id_projeto: " . $stmt->error, "ERROR");
            die("Erro ao excluir projeto $id_projeto: " . $stmt->error);
        }
    }

    public static function carregaComentarios($idProjeto)
    {
        global $conn;

        $sql = "SELECT 
                    a.id_avaliacao,
                    u.nome AS nome_usuario,
                    a.comentario,
                    a.data_avaliacao
                FROM avaliacao a
                JOIN usuario u ON a.id_usuario = u.id_usuario
                WHERE a.id_projeto = ?
                  AND a.comentario IS NOT NULL
                  AND a.comentario != 'sem comentário'
                ORDER BY a.data_avaliacao DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idProjeto);
        $stmt->execute();
        $result = $stmt->get_result();

        $comentarios = [];

        while ($row = $result->fetch_assoc()) {
            $comentarios[] = $row;
        }

        return $comentarios;

    }

    public static function excluiComentario($id_avaliacao)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE avaliacao SET comentario = 'sem comentario' WHERE id_avaliacao = ?
");
        $stmt->bind_param("i", $id_avaliacao);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Comentário excluído com sucesso.'];
        } else {
            Logger::log("Erro ao excluir comentário: " . $stmt->error, "ERROR");
            die("Erro ao excluir comentário: " . $stmt->error);
        }
    }

    public static function buscaAlunosDoProjeto($id_projeto)
    {
        global $conn;
        $alunosDoProjeto = []; // array associativo com id => nome

        $stmt = $conn->prepare("SELECT aluno.id_aluno, aluno.nome 
                        FROM aluno
                        JOIN aluno_has_projeto ON aluno.id_aluno = aluno_has_projeto.id_aluno
                        WHERE aluno_has_projeto.id_projeto = ?");
        $stmt->bind_param("i", $id_projeto);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $alunosDoProjeto[$row['id_aluno']] = $row['nome'];
        }

        return $alunosDoProjeto;
    }

    public function editaProjeto()
    {
        global $conn;

        // Inicia uma transação
        $conn->begin_transaction();

        try {
            if ($this->projetoJaExiste()) {

                $this->atualizaProjeto();


                $this->atualizaCursosDoProjeto();
                $this->atualizaTemasDoProjeto();
                $this->atualizaAlunosDoProjeto();

                // Se tudo deu certo, fazemos o commit da transação
                $conn->commit();
                Logger::log("Projeto " . $this->id_projeto . " editado com sucesso! ", "ADD");
            } else {
                header("Location: ./editarProjeto.php?erro=projeto-nao-existe");
            }
        } catch (Exception $e) {
            // Se qualquer erro ocorrer, desfazemos a transação
            $conn->rollback();
            Logger::log("Erro ao editar projeto" . $this->id_projeto . " : " . $e->getMessage(), "ERROR");
            header("Location: ./editarProjetos.php?projeto=" . $this->id_projeto . "&&erro=nao-foi-possivel-adicionar");
        }
    }

    private function atualizaSolicitacao()
    {
        $nomeDoProjeto = $this->nome;
        $resumoDoProjeto = $this->resumo;
        $descricaoDoProjeto = $this->descricao;
        $materialApoio = $this->materialApoio;
        $idProjeto = $this->id_projeto;
        $status = 1;

        global $conn;

        $stmt = $conn->prepare("UPDATE solicitacao_projeto SET nome_projeto = ?, resumo = ?, descricao = ?, material_apoio = ?, status = ? WHERE id_solicitacao = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssii", $nomeDoProjeto, $resumoDoProjeto, $descricaoDoProjeto, $materialApoio, $status, $idProjeto);

        $stmt->execute();
        $stmt->close();

    }
    private function atualizaProjeto()
    {
        $nomeDoProjeto = $this->nome;
        $resumoDoProjeto = $this->resumo;
        $descricaoDoProjeto = $this->descricao;
        $materialApoio = $this->materialApoio;
        $idProjeto = $this->id_projeto;

        global $conn;

        $stmt = $conn->prepare("UPDATE projeto SET nome = ?, resumo = ?, descricao = ?, material_apoio = ? WHERE id_projeto = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssssi", $nomeDoProjeto, $resumoDoProjeto, $descricaoDoProjeto, $materialApoio, $idProjeto);

        $stmt->execute();
        $stmt->close();

    }

    private function atualizaCursosDoProjeto()
    {
        global $conn;

        $idProjeto = $this->id_projeto;
        $cursos = $this->cursos;

        // Primeiro, apaga todos os cursos atuais associados ao projeto
        $sqlDelete = "DELETE FROM curso_has_projeto WHERE projeto_id_projeto = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if (!$stmtDelete) {
            Logger::log("Erro ao preparar DELETE na tabela curso_has_projeto: " . $conn->error, "ERROR");
            return;
        }

        $stmtDelete->bind_param("i", $idProjeto);

        if (!$stmtDelete->execute()) {
            Logger::log("Erro ao executar DELETE na tabela curso_has_projeto: " . $stmtDelete->error, "ERROR");
            return;
        }

        $stmtDelete->close();

        // Depois, insere novamente os cursos atualizados
        $sqlInsert = "INSERT INTO curso_has_projeto (curso_id_curso, projeto_id_projeto) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if (!$stmtInsert) {
            Logger::log("Erro ao preparar INSERT na curso_has_projeto: " . $conn->error, "ERROR");
            return;
        }

        foreach ($cursos as $idcurso) {
            $stmtInsert->bind_param("ii", $idcurso, $idProjeto);
            if (!$stmtInsert->execute()) {
                Logger::log("Erro ao inserir curso na tabela curso_has_projeto:" . $stmtInsert->error, "ERROR");
            }
        }

        $stmtInsert->close();
    }

    private function atualizaTemasDoProjeto()
    {
        global $conn;
        $idProjeto = $this->id_projeto;
        $temas = $this->temas;

        // Primeiro, apaga todos os temas atuais associados ao projeto
        $sqlDelete = "DELETE FROM tema_has_projeto WHERE projeto_id_projeto = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if (!$stmtDelete) {
            Logger::log("Erro ao preparar DELETE na tabela tema_has_projeto: " . $conn->error, "ERROR");
            return;
        }

        $stmtDelete->bind_param("i", $idProjeto);

        if (!$stmtDelete->execute()) {
            Logger::log("Erro ao executar DELETE na tabela tema_has_projeto: " . $stmtDelete->error, "ERROR");
            return;
        }

        $stmtDelete->close();

        // Depois, insere novamente os temas atualizados
        $sqlInsert = "INSERT INTO tema_has_projeto (tema_id_tema, projeto_id_projeto) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if (!$stmtInsert) {
            Logger::log("Erro ao preparar INSERT na tema_has_projeto: " . $conn->error, "ERROR");
            return;
        }

        foreach ($temas as $idTema) {
            $stmtInsert->bind_param("ii", $idTema, $idProjeto);
            if (!$stmtInsert->execute()) {
                Logger::log("Erro ao inserir tema na tabela tema_has_projeto:" . $stmtInsert->error, "ERROR");
            }
        }

        $stmtInsert->close();
    }

    private function atualizaAlunosDoProjeto()
    {
        global $conn;
        $idProjeto = $this->id_projeto;
        $alunos = $this->alunos;

        // Primeiro, apaga todas as associações atuais de alunos com o projeto
        $sqlDelete = "DELETE FROM aluno_has_projeto WHERE id_projeto = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if (!$stmtDelete) {
            Logger::log("Erro na preparação do DELETE (atualizaAlunosDoProjeto): " . $conn->error, "ERROR");
            return;
        }

        $stmtDelete->bind_param("i", $idProjeto);

        if (!$stmtDelete->execute()) {
            Logger::log("Erro ao executar DELETE (atualizaAlunosDoProjeto): " . $stmtDelete->error, "ERROR");
            $stmtDelete->close();
            return;
        }

        $stmtDelete->close();

        // Agora insere as novas associações
        $sqlInsert = "INSERT INTO aluno_has_projeto (id_aluno, id_projeto) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if (!$stmtInsert) {
            Logger::log("Erro na preparação do INSERT (atualizaAlunosDoProjeto): " . $conn->error, "ERROR");
            return;
        }

        foreach ($alunos as $idAluno) {
            if ($idAluno) {
                $stmtInsert->bind_param("ii", $idAluno, $idProjeto);

                if (!$stmtInsert->execute()) {
                    Logger::log("Erro ao inserir aluno na tabela de relacionamentos (atualizaAlunosDoProjeto): " . $stmtInsert->error, "ERROR");
                }
            } else {
                Logger::log("ID de aluno inválido encontrado (atualizaAlunosDoProjeto).", "ERROR");
            }
        }

        $stmtInsert->close();
    }

    public function cadastraSolicitacaoProjeto($idUsuarioSolicitante)
    {
        global $conn;

        // Pega o id_aluno correspondente ao id_usuario
        $alunoId = Aluno::existeNoBanco($conn, $idUsuarioSolicitante);
        if (!$alunoId) {
            Logger::log("Erro: usuário solicitante não é um aluno válido", "ERROR");
            header("Location: ./solicitarProjeto.php?erro=solicitante-nao-existe");
            return false;
        }

        // Verifica se ele está incluído nos participantes
        if (!in_array($alunoId, $this->alunos)) {
            Logger::log("Solicitação rejeitada: aluno solicitante não está entre os participantes.", "WARN");
            header("Location: ./solicitarProjeto.php?erro=solicitante-nao-incluido");
            return false;
        }

        $conn->begin_transaction();

        try {
            if (!$this->solicitacaoJaExiste()) {
                $solicitacaoId = $this->criaSolicitacao($alunoId);

                if (!$solicitacaoId) {
                    Logger::log("Erro ao criar a solicitação.", "ERROR");
                    throw new Exception("Erro ao criar solicitação");
                }

                $this->registraCursosDaSolicitacao($solicitacaoId);
                $this->registraTemasDaSolicitacao($solicitacaoId);
                $this->registraAlunoDaSolicitacao($solicitacaoId);

                $conn->commit();
                Logger::log("Solicitação $solicitacaoId cadastrada com sucesso!", "ADD");
                return $solicitacaoId;
            } else {
                Logger::log("Solicitação já existe.", "WARN");
                return false;
            }
        } catch (Exception $e) {
            $conn->rollback();
            Logger::log("Erro ao cadastrar solicitação: " . $e->getMessage(), "ERROR");
            return false;
        }
    }


    // Método para verificar se a solicitação já existe (exemplo)
    private function solicitacaoJaExiste()
    {
        global $conn;

        $sql = "SELECT id_solicitacao FROM solicitacao_projeto WHERE nome_projeto = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            Logger::log("Erro ao preparar consulta solicitacaoJaExiste: " . $conn->error, "ERROR");
            return true; // assume que existe para evitar duplicidade
        }

        $stmt->bind_param("s", $this->nome);
        $stmt->execute();
        $stmt->store_result();

        $existe = $stmt->num_rows > 0;
        $stmt->close();

        return $existe;
    }

    // Cria a solicitação no banco e retorna o ID inserido
    private function criaSolicitacao($idUsuarioSolicitante)
    {
        global $conn;

        $dataSolicitacao = date('Y-m-d H:i:s');
        $status = 'pendente'; // exemplo de status inicial

        $sql = "INSERT INTO solicitacao_projeto (nome_projeto, resumo, descricao, material_apoio,  solicitado_por, data_solicitacao, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            Logger::log("Erro ao preparar consulta criaSolicitacao: " . $conn->error, "ERROR");
            return false;
        }

        $stmt->bind_param("sssssss", $this->nome, $this->resumo, $this->descricao, $this->materialApoio, $idUsuarioSolicitante, $dataSolicitacao, $status);

        if ($stmt->execute()) {
            $insertId = $conn->insert_id;
            $stmt->close();
            return $insertId;
        } else {
            Logger::log("Erro ao executar consulta criaSolicitacao: " . $stmt->error, "ERROR");
            $stmt->close();
            return false;
        }
    }


    private function registraCursosDaSolicitacao($idSolicitacao)
    {
        if (empty($this->cursos))
            return;

        global $conn;
        $sql = "INSERT INTO curso_has_solicitacao (curso_id_curso, solicitacao_id_solicitacao) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            Logger::log("Erro ao preparar consulta registraCursosDaSolicitacao: " . $conn->error, "ERROR");
            return;
        }

        foreach ($this->cursos as $idCurso) {
            $stmt->bind_param("ii", $idCurso, $idSolicitacao);
            if (!$stmt->execute()) {
                Logger::log("Erro ao registrar curso da solicitação: " . $stmt->error, "ERROR");
            }
        }

        $stmt->close();
    }

    private function registraTemasDaSolicitacao($idSolicitacao)
    {
        if (empty($this->temas))
            return;

        global $conn;
        $sql = "INSERT INTO tema_has_solicitacao (tema_id_tema, solicitacao_id_solicitacao) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            Logger::log("Erro ao preparar consulta registraTemasDaSolicitacao: " . $conn->error, "ERROR");
            return;
        }

        foreach ($this->temas as $idTema) {
            $stmt->bind_param("ii", $idTema, $idSolicitacao);
            if (!$stmt->execute()) {
                Logger::log("Erro ao registrar tema da solicitação: " . $stmt->error, "ERROR");
            }
        }

        $stmt->close();
    }

    private function registraAlunoDaSolicitacao($idSolicitacao)
    {
        if (empty($this->alunos))
            return;

        global $conn;
        $sql = "INSERT INTO aluno_has_solicitacao (aluno_id_aluno, solicitacao_id_solicitacao) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            Logger::log("Erro ao preparar consulta registraAlunoDaSolicitacao: " . $conn->error, "ERROR");
            return;
        }

        foreach ($this->alunos as $idAluno) {
            $stmt->bind_param("ii", $idAluno, $idSolicitacao);
            if (!$stmt->execute()) {
                Logger::log("Erro ao registrar usuário da solicitação: " . $stmt->error, "ERROR");
            }
        }

        $stmt->close();
    }

    public static function carregaSolicitacoes(int $status = 1, int $idUsuarioSolicitante = null)
    {
        global $conn;
        $sql = "
    SELECT 
        p.id_solicitacao,
        p.nome_projeto AS projeto_nome,
        p.resumo AS projeto_resumo,
        p.descricao AS projeto_descricao,
        GROUP_CONCAT(DISTINCT c.nome) AS cursos,
        GROUP_CONCAT(DISTINCT i.nome) AS alunos,
        GROUP_CONCAT(DISTINCT t.nome) AS temas
    FROM 
        solicitacao_projeto p
        LEFT JOIN curso_has_solicitacao chp ON p.id_solicitacao = chp.solicitacao_id_solicitacao
        LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
        LEFT JOIN aluno_has_solicitacao ihp ON p.id_solicitacao = ihp.solicitacao_id_solicitacao
        LEFT JOIN aluno i ON ihp.aluno_id_aluno = i.id_aluno
        LEFT JOIN tema_has_solicitacao pht ON p.id_solicitacao = pht.solicitacao_id_solicitacao
        LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema
    WHERE p.status = ?
    ";

        // Armazena os tipos e valores para bind_param
        $types = "i";
        $params = [$status];

        // Filtra por usuário solicitante, se fornecido
        if ($idUsuarioSolicitante !== null) {
            $sql .= " AND p.solicitado_por = ?";
            $types .= "i";
            $params[] = $idUsuarioSolicitante;
        }

        $sql .= " GROUP BY p.id_solicitacao, p.nome_projeto, p.resumo, p.descricao";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            Logger::log("Erro ao preparar consulta das solicitações: " . $conn->error, "ERROR");
            return [];
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $projetos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $projetos = array_reverse($projetos);
        return $projetos;
    }


    public static function obterSolicitacaoPeloId($id)
    {
        global $conn;

        $sql = "SELECT * FROM solicitacao_projeto WHERE id_solicitacao = ?;";
        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param("i", $id);
            $stmt->execute();


            $result = $stmt->get_result();
            if ($result) {
                $projeto = $result->fetch_assoc();
                return $projeto;
            } else {
                die("Solicitação com ID $id não encontrado.");
            }
        } else {
            die("Erro na preparação da consulta: " . $conn->error);
        }
    }

    public static function obterDetalhesDaSolicitacao($id)
    {
        global $conn;
        $sql = "SELECT 
        p.id_solicitacao,
        p.nome_projeto AS projeto_nome,
        p.descricao AS projeto_descricao,
        p.resumo AS projeto_resumo,
        p.material_apoio AS projeto_material_apoio,
        GROUP_CONCAT(DISTINCT c.nome) AS cursos,
        GROUP_CONCAT(DISTINCT i.nome) AS alunos,
        GROUP_CONCAT(DISTINCT t.nome) AS temas

    FROM 
        solicitacao_projeto p
        LEFT JOIN curso_has_solicitacao chp ON p.id_solicitacao = chp.solicitacao_id_solicitacao
        LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
        LEFT JOIN aluno_has_solicitacao ihp ON p.id_solicitacao = ihp.solicitacao_id_solicitacao
        LEFT JOIN aluno i ON ihp.aluno_id_aluno = i.id_aluno
        LEFT JOIN tema_has_solicitacao pht ON p.id_solicitacao = pht.solicitacao_id_solicitacao
        LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema
        
        


    WHERE 
        p.id_solicitacao = ? 

    GROUP BY 
        p.id_solicitacao, p.nome_projeto, p.descricao, p.resumo, p.material_apoio;";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $projeto = $result->fetch_assoc();

                return $projeto;
            } else {
                die("Algo deu errado na consulta do projeto");
            }
        } else {
            die("Algo deu errado na preparação da consulta do projeto");
        }
    }

    public static function registrarRevisaoComReprovacao($id, $comentarios)
    {
        global $conn;

        // Verifica se os comentários são válidos
        if (!is_array($comentarios) || empty($comentarios)) {
            Logger::log("Tentativa de registrar revisão com comentários inválidos para solicitação $id", "WARN");
            return;
        }

        // Atualiza status da solicitação
        $stmt = $conn->prepare("UPDATE solicitacao_projeto SET status = 'rejeitado' WHERE id_solicitacao = ?");
        if (!$stmt) {
            Logger::log("Erro ao preparar UPDATE para status 'rejeitado': " . $conn->error, "ERROR");
            return;
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            Logger::log("Erro ao executar UPDATE para status 'rejeitado' da solicitação $id: " . $stmt->error, "ERROR");
            $stmt->close();
            return;
        }
        $stmt->close();

        // Registra cada observação reprovada
        foreach ($comentarios as $campo => $dados) {
            if ($dados['status'] === 'reprovado' && !empty(trim($dados['comentario']))) {
                $comentario = $dados['comentario'];

                $stmtObs = $conn->prepare("INSERT INTO observacao_revisao (solicitacao_id, campo, comentario) VALUES (?, ?, ?)");
                if (!$stmtObs) {
                    Logger::log("Erro ao preparar INSERT para campo '$campo' da solicitação $id: " . $conn->error, "ERROR");
                    continue;
                }

                $stmtObs->bind_param("iss", $id, $campo, $comentario);
                if (!$stmtObs->execute()) {
                    Logger::log("Erro ao executar INSERT da observação no campo '$campo' da solicitação $id: " . $stmtObs->error, "ERROR");
                }

                $stmtObs->close();
            }
        }

        Logger::log("Solicitação $id rejeitada com observações registradas com sucesso", "INFO");
    }



    public static function aprovarSolicitacao($id)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE solicitacao_projeto SET status = 'aprovado' WHERE id_solicitacao = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Aqui você pode transferir os dados para a tabela `projeto` definitiva se quiser
    }

    public static function obterDetalhesDaSolicitacaoComComentarios($idSolicitacao)
    {
        global $conn;

        $sql = "SELECT 
        p.id_solicitacao,
        p.nome_projeto AS projeto_nome,
        p.resumo AS projeto_resumo,
        p.descricao AS projeto_descricao,
        p.material_apoio AS projeto_material_apoio,
        GROUP_CONCAT(DISTINCT c.nome) AS cursos,
        GROUP_CONCAT(DISTINCT a.nome) AS alunos,
        GROUP_CONCAT(DISTINCT t.nome) AS temas
    FROM solicitacao_projeto p
    LEFT JOIN curso_has_solicitacao chs ON p.id_solicitacao = chs.solicitacao_id_solicitacao
    LEFT JOIN curso c ON chs.curso_id_curso = c.id_curso
    LEFT JOIN aluno_has_solicitacao ahs ON p.id_solicitacao = ahs.solicitacao_id_solicitacao
    LEFT JOIN aluno a ON ahs.aluno_id_aluno = a.id_aluno
    LEFT JOIN tema_has_solicitacao ths ON p.id_solicitacao = ths.solicitacao_id_solicitacao
    LEFT JOIN tema t ON ths.tema_id_tema = t.id_tema
    WHERE p.id_solicitacao = ?
    GROUP BY p.id_solicitacao";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idSolicitacao);
        $stmt->execute();
        $result = $stmt->get_result();
        $dadosProjeto = $result->fetch_assoc();

        if (!$dadosProjeto)
            return null;

        // Agora buscamos os comentários da tabela observacao_revisao
        $sqlComentarios = "SELECT campo, comentario FROM observacao_revisao WHERE solicitacao_id = ?";
        $stmtComentarios = $conn->prepare($sqlComentarios);
        $stmtComentarios->bind_param("i", $idSolicitacao);
        $stmtComentarios->execute();
        $resultComentarios = $stmtComentarios->get_result();

        $comentarios = [];
        while ($linha = $resultComentarios->fetch_assoc()) {
            $comentarios[$linha['campo']] = $linha['comentario'];
        }

        // Anexamos os comentários ao retorno principal
        $dadosProjeto['comentarios'] = $comentarios;

        return $dadosProjeto;
    }

    public function editaSolicitacao()
    {
        global $conn;

        // Inicia uma transação
        $conn->begin_transaction();

        try {


            $this->atualizaSolicitacao();


            $this->atualizaCursosDaSolicitacao();
            $this->atualizaTemasDaSolicitacao();
            $this->atualizaAlunosDaSolicitacao();

            // Se tudo deu certo, fazemos o commit da transação
            $conn->commit();
            Logger::log("Solicitacao " . $this->id_projeto . " editado com sucesso! ", "ADD");

        } catch (Exception $e) {
            // Se qualquer erro ocorrer, desfazemos a transação
            $conn->rollback();
            Logger::log("Erro ao editar solicitacao" . $this->id_projeto . " : " . $e->getMessage(), "ERROR");
            header("Location: ./editarSolicitacao.php?projeto=" . $this->id_projeto . "&&erro=nao-foi-possivel-adicionar");
        }
    }

    private function atualizaCursosDaSolicitacao()
    {
        global $conn;

        $idProjeto = $this->id_projeto;
        $cursos = $this->cursos;

        // Primeiro, apaga todos os cursos atuais associados ao projeto
        $sqlDelete = "DELETE FROM curso_has_solicitacao WHERE solicitacao_id_solicitacao = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if (!$stmtDelete) {
            Logger::log("Erro ao preparar DELETE na tabela curso_has_solicitacao: " . $conn->error, "ERROR");
            return;
        }

        $stmtDelete->bind_param("i", $idProjeto);

        if (!$stmtDelete->execute()) {
            Logger::log("Erro ao executar DELETE na tabela curso_has_solicitacao: " . $stmtDelete->error, "ERROR");
            return;
        }

        $stmtDelete->close();

        // Depois, insere novamente os cursos atualizados
        $sqlInsert = "INSERT INTO curso_has_solicitacao (curso_id_curso, solicitacao_id_solicitacao) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if (!$stmtInsert) {
            Logger::log("Erro ao preparar INSERT na curso_has_solicitacao: " . $conn->error, "ERROR");
            return;
        }

        foreach ($cursos as $idcurso) {
            $stmtInsert->bind_param("ii", $idcurso, $idProjeto);
            if (!$stmtInsert->execute()) {
                Logger::log("Erro ao inserir curso na tabela curso_has_solicitacao:" . $stmtInsert->error, "ERROR");
            }
        }

        $stmtInsert->close();
    }

    private function atualizaTemasDaSolicitacao()
    {
        global $conn;
        $idProjeto = $this->id_projeto;
        $temas = $this->temas;

        // Primeiro, apaga todos os temas atuais associados ao projeto
        $sqlDelete = "DELETE FROM tema_has_solicitacao WHERE solicitacao_id_solicitacao = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if (!$stmtDelete) {
            Logger::log("Erro ao preparar DELETE na tabela tema_has_solicitacao: " . $conn->error, "ERROR");
            return;
        }

        $stmtDelete->bind_param("i", $idProjeto);

        if (!$stmtDelete->execute()) {
            Logger::log("Erro ao executar DELETE na tabela tema_has_solicitacao: " . $stmtDelete->error, "ERROR");
            return;
        }

        $stmtDelete->close();

        // Depois, insere novamente os temas atualizados
        $sqlInsert = "INSERT INTO tema_has_solicitacao (tema_id_tema, solicitacao_id_solicitacao) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if (!$stmtInsert) {
            Logger::log("Erro ao preparar INSERT na tema_has_solicitacao: " . $conn->error, "ERROR");
            return;
        }

        foreach ($temas as $idTema) {
            $stmtInsert->bind_param("ii", $idTema, $idProjeto);
            if (!$stmtInsert->execute()) {
                Logger::log("Erro ao inserir tema na tabela tema_has_solicitacao:" . $stmtInsert->error, "ERROR");
            }
        }

        $stmtInsert->close();
    }

    private function atualizaAlunosDaSolicitacao()
    {
        global $conn;
        $idProjeto = $this->id_projeto;
        $alunos = $this->alunos;

        // Primeiro, apaga todas as associações atuais de alunos com o projeto
        $sqlDelete = "DELETE FROM aluno_has_solicitacao WHERE solicitacao_id_solicitacao = ?";
        $stmtDelete = $conn->prepare($sqlDelete);

        if (!$stmtDelete) {
            Logger::log("Erro na preparação do DELETE (atualizaAlunosDosolicitacao): " . $conn->error, "ERROR");
            return;
        }

        $stmtDelete->bind_param("i", $idProjeto);

        if (!$stmtDelete->execute()) {
            Logger::log("Erro ao executar DELETE (atualizaAlunosDosolicitacao): " . $stmtDelete->error, "ERROR");
            $stmtDelete->close();
            return;
        }

        $stmtDelete->close();

        // Agora insere as novas associações
        $sqlInsert = "INSERT INTO aluno_has_solicitacao (aluno_id_aluno, solicitacao_id_solicitacao) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        if (!$stmtInsert) {
            Logger::log("Erro na preparação do INSERT (atualizaAlunosDosolicitacao): " . $conn->error, "ERROR");
            return;
        }

        foreach ($alunos as $idAluno) {
            if ($idAluno) {
                $stmtInsert->bind_param("ii", $idAluno, $idProjeto);

                if (!$stmtInsert->execute()) {
                    Logger::log("Erro ao inserir aluno na tabela de relacionamentos (atualizaAlunosDosolicitacao): " . $stmtInsert->error, "ERROR");
                }
            } else {
                Logger::log("ID de aluno inválido encontrado (atualizaAlunosDosolicitacao).", "ERROR");
            }
        }

        $stmtInsert->close();
    }

    public static function obterDetalhesDaSolicitacaoComOsIDS($id)
    {
        global $conn;
        $sql = "SELECT 
        p.id_solicitacao,
        p.nome_projeto AS projeto_nome,
        p.descricao AS projeto_descricao,
        p.resumo AS projeto_resumo,
        p.material_apoio AS projeto_material_apoio,
        GROUP_CONCAT(DISTINCT CONCAT(c.id_curso, ':', c.nome)) AS cursos,
        GROUP_CONCAT(DISTINCT CONCAT(i.id_aluno, ':', i.nome)) AS alunos,
        GROUP_CONCAT(DISTINCT CONCAT(t.id_tema, ':', t.nome)) AS temas
    FROM 
        solicitacao_projeto p
        LEFT JOIN curso_has_solicitacao chp ON p.id_solicitacao = chp.solicitacao_id_solicitacao
        LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
        LEFT JOIN aluno_has_solicitacao ihp ON p.id_solicitacao = ihp.solicitacao_id_solicitacao
        LEFT JOIN aluno i ON ihp.aluno_id_aluno = i.id_aluno
        LEFT JOIN tema_has_solicitacao pht ON p.id_solicitacao = pht.solicitacao_id_solicitacao
        LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema
    WHERE 
        p.id_solicitacao = ? 
    GROUP BY 
        p.id_solicitacao, p.nome_projeto, p.descricao, p.resumo, p.material_apoio;";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $projeto = $result->fetch_assoc();

                // Convertendo os campos concatenados em arrays associativos
                $projeto['cursos'] = array_map(function ($item) {
                    [$id, $nome] = explode(':', $item);
                    return ['id' => (int) $id, 'nome' => $nome];
                }, $projeto['cursos'] ? explode(',', $projeto['cursos']) : []);

                $projeto['alunos'] = array_map(function ($item) {
                    [$id, $nome] = explode(':', $item);
                    return ['id' => (int) $id, 'nome' => $nome];
                }, $projeto['alunos'] ? explode(',', $projeto['alunos']) : []);

                $projeto['temas'] = array_map(function ($item) {
                    [$id, $nome] = explode(':', $item);
                    return ['id' => (int) $id, 'nome' => $nome];
                }, $projeto['temas'] ? explode(',', $projeto['temas']) : []);

                return $projeto;
            } else {
                die("Algo deu errado na consulta do projeto");
            }
        } else {
            die("Algo deu errado na preparação da consulta do projeto");
        }
    }

    public function aprovaSolicitacao($projetoId)
    {
        global $conn;

        // Verifica a conexão
        if ($conn->connect_error) {
            echo "Falha na conexão: " . $conn->connect_error;
            return false;
        }

        // Prepara a query
        $stmt = $conn->prepare("UPDATE solicitacao_projeto SET status = 2 WHERE id_solicitacao = ?");
        if (!$stmt) {
            echo "Erro ao preparar a query: " . $conn->error;
            $conn->close();
            return false;
        }

        // Faz o bind do parâmetro
        $stmt->bind_param("i", $projetoId);

        // Executa a query
        if ($stmt->execute()) {
            echo "Projeto aprovado com sucesso.";
        } else {
            echo "Erro ao aprovar projeto: " . $stmt->error;
        }

        // Fecha as conexões
        $stmt->close();
        $conn->close();

        return true;
    }
}
