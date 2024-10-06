<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";

class Projeto
{
    private $nome;
    private $local;
    private $descricao;
    private $temas = [];
    private $cursos = [];
    private $integrantes = [];
    private $listaDeProjetos = [];
    private $listaDeSalas = [];

    public function __construct($nome = null, $local = null, $descricao = null, $temas = null, $cursos = null, $integrantes = null)
    {
        $this->nome = $nome;
        $this->local = $local;
        $this->descricao = $descricao;
        $this->temas = $temas;
        $this->cursos = $cursos;
        $this->integrantes = $integrantes;
    }

    public function carregaProjetos()
    {
        global $conn;
        $sql = "SELECT 
            p.id_projeto,
            p.nome AS projeto_nome,
            p.descricao AS projeto_descricao,
            s.numero AS sala_numero,
            GROUP_CONCAT(DISTINCT c.nome) AS cursos,
            GROUP_CONCAT(DISTINCT i.nome) AS integrantes,
            GROUP_CONCAT(DISTINCT t.nome) AS temas,
            
            COALESCE(a.total_avaliacoes, 0) AS total_avaliacoes,
            COALESCE(a.media_notas, 0) AS media_notas,
            
            COALESCE(a.total_avaliacoes_mulheres, 0) AS total_avaliacoes_mulheres,
            COALESCE(a.media_notas_mulheres, 0) AS media_notas_mulheres,
            
            COALESCE(a.total_avaliacoes_homens, 0) AS total_avaliacoes_homens,
            COALESCE(a.media_notas_homens, 0) AS media_notas_homens,
            
            COALESCE(a.total_avaliacoes_idosos, 0) AS total_avaliacoes_idosos,
            COALESCE(a.media_notas_idosos, 0) AS media_notas_idosos,
            
            COALESCE(a.total_avaliacoes_jovens, 0) AS total_avaliacoes_jovens,
            COALESCE(a.media_notas_jovens, 0) AS media_notas_jovens,
            
            COALESCE(a.total_avaliacoes_adultos, 0) AS total_avaliacoes_adultos,
            COALESCE(a.media_notas_adultos, 0) AS media_notas_adultos

        FROM 
            projeto p
            LEFT JOIN sala s ON p.sala_id_sala = s.id_sala
            LEFT JOIN curso_has_projeto chp ON p.id_projeto = chp.projeto_id_projeto
            LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
            LEFT JOIN integrante_has_projeto ihp ON p.id_projeto = ihp.id_projeto
            LEFT JOIN integrante i ON ihp.id_integrante = i.id_integrante
            LEFT JOIN projeto_has_tema pht ON p.id_projeto = pht.projeto_id_projeto
            LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema
            
            LEFT JOIN (
                SELECT 
                    a.id_projeto,
                    COUNT(a.id_avaliacao) AS total_avaliacoes,
                    AVG(a.nota) AS media_notas,
                    
                    SUM(CASE WHEN u.sexo = 'Feminino' THEN 1 ELSE 0 END) AS total_avaliacoes_mulheres,
                    AVG(CASE WHEN u.sexo = 'Feminino' THEN a.nota ELSE NULL END) AS media_notas_mulheres,
                    
                    SUM(CASE WHEN u.sexo = 'Masculino' THEN 1 ELSE 0 END) AS total_avaliacoes_homens,
                    AVG(CASE WHEN u.sexo = 'Masculino' THEN a.nota ELSE NULL END) AS media_notas_homens,
                    
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) >= 60 THEN 1 ELSE 0 END) AS total_avaliacoes_idosos,
                    AVG(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) >= 60 THEN a.nota ELSE NULL END) AS media_notas_idosos,
                    
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) < 22 THEN 1 ELSE 0 END) AS total_avaliacoes_jovens,
                    AVG(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) < 22 THEN a.nota ELSE NULL END) AS media_notas_jovens,
                    
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) BETWEEN 22 AND 59 THEN 1 ELSE 0 END) AS total_avaliacoes_adultos,
                    AVG(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) BETWEEN 22 AND 59 THEN a.nota ELSE NULL END) AS media_notas_adultos
                FROM 
                    avaliacao a
                    LEFT JOIN usuario u ON a.id_usuario = u.id_usuario
                GROUP BY a.id_projeto
            ) a ON p.id_projeto = a.id_projeto

        GROUP BY 
            p.id_projeto, p.nome, p.descricao, s.numero;
        ";
        $result = $conn->query($sql);

        if ($result) {
            $projetos = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($projetos as &$projeto) {
                $projeto['popular_adultos'] = ($projeto['media_notas_adultos'] >= 8) ? true : false;
                $projeto['popular_jovens'] = ($projeto['media_notas_jovens'] >= 8) ? true : false;
                $projeto['popular_idosos'] = ($projeto['media_notas_idosos'] >= 8) ? true : false;
                $projeto['popular_mulheres'] = ($projeto['media_notas_mulheres'] >= 8) ? true : false;
                $projeto['popular_homens'] = ($projeto['media_notas_homens'] >= 8) ? true : false;
            }

            $this->listaDeProjetos = $projetos;
            return $this->listaDeProjetos;
        } else {
            die("Algo deu errado na consulta dos projetos");
        }
    }

    public function obterProjetos()
    {
        return $this->carregaProjetos();
    }

    private function carregaSalasComProjetos()
    {
        global $conn;
        $sql = "SELECT 
            s.numero AS sala_numero,
            GROUP_CONCAT(DISTINCT p.nome ORDER BY p.nome ASC) AS lista_projetos,
            COUNT(p.id_projeto) AS total_projetos,
            SUM(COALESCE(a.total_avaliacoes, 0)) AS total_avaliacoes,
            AVG(COALESCE(a.media_notas, 0)) AS media_notas
        FROM 
            sala s
            LEFT JOIN projeto p ON s.id_sala = p.sala_id_sala
            LEFT JOIN (
                SELECT 
                    a.id_projeto,
                    COUNT(a.id_avaliacao) AS total_avaliacoes,
                    AVG(a.nota) AS media_notas
                FROM 
                    avaliacao a
                GROUP BY a.id_projeto
            ) a ON p.id_projeto = a.id_projeto
        WHERE a.id_projeto IS NOT NULL  -- Garante que apenas projetos com avaliações são considerados
        GROUP BY s.numero;";
        $result = $conn->query($sql);

        if ($result) {
            $this->listaDeSalas = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Algo deu errado na consulta das salas com projetos");
        }
    }




    public function obterSalasComProjetos()
    {
        if (empty($this->listaDeSalas)) {
            $this->carregaSalasComProjetos();
        }

        return $this->listaDeSalas;
    }

    public function obterProjetosDaSala($sala)
    {
        $projetos = $this->carregaProjetos();
        $projetosDaSala = [];
        foreach ($projetos as $projeto) {
            if ($projeto['sala_numero'] == $sala) {
                $projetosDaSala[] = $projeto;
            }
        }

        return $projetosDaSala;
    }

    public static function obterProjetoPeloId($id)
    {
        global $conn;

        $sql = "SELECT * FROM projeto WHERE id_projeto = ?;";
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
            s.numero AS sala_numero,
            GROUP_CONCAT(DISTINCT c.nome) AS cursos,
            GROUP_CONCAT(DISTINCT i.nome) AS integrantes,
            GROUP_CONCAT(DISTINCT t.nome) AS temas,
            
            COALESCE(ag.total_avaliacoes, 0) AS total_avaliacoes,
            COALESCE(ag.media_notas, 0) AS media_notas,
            
            COALESCE(ag.total_avaliacoes_mulheres, 0) AS total_avaliacoes_mulheres,
            COALESCE(ag.media_notas_mulheres, 0) AS media_notas_mulheres,
            
            COALESCE(ag.total_avaliacoes_homens, 0) AS total_avaliacoes_homens,
            COALESCE(ag.media_notas_homens, 0) AS media_notas_homens,
            
            COALESCE(ag.total_avaliacoes_idosos, 0) AS total_avaliacoes_idosos,
            COALESCE(ag.media_notas_idosos, 0) AS media_notas_idosos,
            
            COALESCE(ag.total_avaliacoes_jovens, 0) AS total_avaliacoes_jovens,
            COALESCE(ag.media_notas_jovens, 0) AS media_notas_jovens,
            
            COALESCE(ag.total_avaliacoes_adultos, 0) AS total_avaliacoes_adultos,
            COALESCE(ag.media_notas_adultos, 0) AS media_notas_adultos,

            GROUP_CONCAT(DISTINCT a.comentario SEPARATOR ' | ') AS comentarios

        FROM 
            projeto p
            LEFT JOIN sala s ON p.sala_id_sala = s.id_sala
            LEFT JOIN curso_has_projeto chp ON p.id_projeto = chp.projeto_id_projeto
            LEFT JOIN curso c ON chp.curso_id_curso = c.id_curso
            LEFT JOIN integrante_has_projeto ihp ON p.id_projeto = ihp.id_projeto
            LEFT JOIN integrante i ON ihp.id_integrante = i.id_integrante
            LEFT JOIN projeto_has_tema pht ON p.id_projeto = pht.projeto_id_projeto
            LEFT JOIN tema t ON pht.tema_id_tema = t.id_tema
            
            LEFT JOIN (
                SELECT 
                    a.id_projeto,
                    COUNT(a.id_avaliacao) AS total_avaliacoes,
                    AVG(a.nota) AS media_notas,
                    
                    SUM(CASE WHEN u.sexo = 'Feminino' THEN 1 ELSE 0 END) AS total_avaliacoes_mulheres,
                    AVG(CASE WHEN u.sexo = 'Feminino' THEN a.nota ELSE NULL END) AS media_notas_mulheres,
                    
                    SUM(CASE WHEN u.sexo = 'Masculino' THEN 1 ELSE 0 END) AS total_avaliacoes_homens,
                    AVG(CASE WHEN u.sexo = 'Masculino' THEN a.nota ELSE NULL END) AS media_notas_homens,
                    
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) >= 60 THEN 1 ELSE 0 END) AS total_avaliacoes_idosos,
                    AVG(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) >= 60 THEN a.nota ELSE NULL END) AS media_notas_idosos,
                    
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) < 22 THEN 1 ELSE 0 END) AS total_avaliacoes_jovens,
                    AVG(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) < 22 THEN a.nota ELSE NULL END) AS media_notas_jovens,
                    
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) BETWEEN 22 AND 59 THEN 1 ELSE 0 END) AS total_avaliacoes_adultos,
                    AVG(CASE WHEN TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) BETWEEN 22 AND 59 THEN a.nota ELSE NULL END) AS media_notas_adultos
                FROM 
                    avaliacao a
                    LEFT JOIN usuario u ON a.id_usuario = u.id_usuario
                GROUP BY a.id_projeto
            ) ag ON p.id_projeto = ag.id_projeto

            LEFT JOIN avaliacao a ON p.id_projeto = a.id_projeto

        WHERE 
            p.id_projeto = ? 

        GROUP BY 
            p.id_projeto, p.nome, p.descricao, s.numero;


        ";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $projeto = $result->fetch_assoc();


                $projeto['popular_adultos'] = ($projeto['media_notas_adultos'] >= 8) ? true : false;
                $projeto['popular_jovens'] = ($projeto['media_notas_jovens'] >= 8) ? true : false;
                $projeto['popular_idosos'] = ($projeto['media_notas_idosos'] >= 8) ? true : false;
                $projeto['popular_mulheres'] = ($projeto['media_notas_mulheres'] >= 8) ? true : false;
                $projeto['popular_homens'] = ($projeto['media_notas_homens'] >= 8) ? true : false;


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

                $this->registraSalaDoProjeto(); // Certifique-se de que este método lance exceções
                $projetoId = $this->criaProjeto();

                if (!$projetoId) {
                    throw new Exception("Erro ao criar o projeto.");
                }

                $this->registraCursosDoProjeto($projetoId);
                $this->registraTemasDoProjeto($projetoId);
                $this->registraIntegrantesDoProjeto($projetoId);

                // Se tudo deu certo, fazemos o commit da transação
                $conn->commit();
                echo "Projeto cadastrado com sucesso!";
                $this->registrarNotaAutomatica($projetoId);
            } else {
                throw new Exception("Esse projeto já existe.");
            }
        } catch (Exception $e) {
            // Se qualquer erro ocorrer, desfazemos a transação
            $conn->rollback();
            echo "Erro no cadastro do projeto: " . $e->getMessage();
        }
    }




    //insere os dados na tabela de relacionamentos integrante_has_projeto

    private function verificarSala()
    {
        global $conn;
        $query = "SELECT COUNT(*) FROM sala WHERE numero = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $this->local);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Verifica se a sala já existe
        return $count > 0;
    }

    private function registraSalaDoProjeto()
    {
        global $conn;
        if (!$this->verificarSala()) {
            $query = "INSERT INTO sala (numero) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $this->local);

            if (!$stmt->execute()) {
                $stmt->close();
                throw new Exception("Erro ao criar a sala: " . $stmt->error);
            }
            $stmt->close();
        }
    }

    private function registraCursosDoProjeto($idProjeto)
    {
        global $conn;
        $sql = "INSERT INTO curso_has_projeto (curso_id_curso, projeto_id_projeto) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $conn->error);
        }

        $cursos = $this->cursos;
        foreach ($cursos as $idCurso) {
            $stmt->bind_param("ii", $idCurso, $idProjeto);
            if (!$stmt->execute()) {
                $stmt->close();
                throw new Exception("Erro ao registrar cursos: " . $stmt->error);
            }
        }

        $stmt->close();
        echo "Cursos registrados com sucesso!";
    }
    private function registraTemasDoProjeto($idProjeto)
    {
        global $conn;
        $sql = "INSERT INTO projeto_has_tema (projeto_id_projeto, tema_id_tema) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $conn->error);
        }

        $temas = $this->temas;
        foreach ($temas as $idTema) {
            $stmt->bind_param("ii", $idProjeto, $idTema);
            if (!$stmt->execute()) {
                $stmt->close();
                throw new Exception("Erro ao registrar temas: " . $stmt->error);
            }
        }

        $stmt->close();
        echo "Temas registrados com sucesso!";
    }

    private function criaProjeto()
    {
        $nomeDoProjeto = $this->nome;
        $descricaoDoProjeto = $this->descricao;
        $salaId = $this->pegaIDSala();

        global $conn;

        $stmt = $conn->prepare("INSERT INTO projeto (nome, descricao, sala_id_sala) VALUES (?, ?, ?)");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ssi", $nomeDoProjeto, $descricaoDoProjeto, $salaId);

        if ($stmt->execute()) {
            $insertId = $conn->insert_id; // Retorna o ID do projeto inserido
            $stmt->close();
            return $insertId;
        } else {
            $stmt->close();
            return false; // Retorna false em caso de erro
        }
    }


    private function pegaIDSala()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id_sala FROM sala WHERE numero = ?");
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $this->local);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $stmt->close();
            return $row['id_sala'];
        } else {
            $stmt->close();
            return null; // Se a sala não for encontrada
        }
    }


    private function registraIntegrantesDoProjeto($id_projeto)
    {
        global $conn;
        $integrantes = $this->integrantes;

        foreach ($integrantes as $nomeIntegrante) {
            if (!$this->verificaIntegrante($nomeIntegrante)) {
                $query = "INSERT INTO integrante (nome) VALUES (?)";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    return "Erro na preparação da consulta: " . $conn->error;
                }
                $stmt->bind_param("s", $nomeIntegrante);

                if (!$stmt->execute()) {
                    $stmt->close();
                    return "Erro ao cadastrar integrante.";
                }
                $stmt->close();
            }

            $idIntegrante = $this->pegaIDIntegrante($nomeIntegrante);
            if ($idIntegrante) {
                $query = "INSERT INTO integrante_has_projeto (id_integrante, id_projeto) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    return "Erro na preparação da consulta: " . $conn->error;
                }
                $stmt->bind_param("ii", $idIntegrante, $id_projeto);

                if (!$stmt->execute()) {
                    $stmt->close();
                    return "Erro ao registrar integrante na tabela de relacionamentos.";
                }
                $stmt->close();
            } else {
                return "Algo deu errado ao encontrar integrante no banco.";
            }
        }
    }


    private function verificaIntegrante($nomeIntegrante)
    {
        global $conn;
        $query = "SELECT COUNT(*) FROM integrante WHERE nome = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $nomeIntegrante);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0; // Verifica se o integrante já existe
    }


    private function pegaIDIntegrante($nomeIntegrante)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id_integrante FROM integrante WHERE nome = ?");
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $nomeIntegrante);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $stmt->close();
            return $row['id_integrante'];
        } else {
            $stmt->close();
            return null; // Se o integrante não for encontrado
        }
    }


    private function projetoJaExiste()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM projeto WHERE nome = ?");
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $this->nome);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
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

}
