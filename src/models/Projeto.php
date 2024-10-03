<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";

class Projeto
{
    private $listaDeProjetos = [];
    private $listaDeSalas = [];

    public function __construct()
    {
        $this->carregaProjetos();
    }

    private function carregaProjetos()
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
        } else {
            die("Algo deu errado na consulta dos projetos");
        }
    }

    public function obterProjetos()
    {
        return $this->listaDeProjetos;
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
        $projetos = $this->listaDeProjetos;
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
            p.id_projeto = $id  

        GROUP BY 
            p.id_projeto, p.nome, p.descricao, s.numero;


        ";
        $result = $conn->query($sql);

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
    }

    public static function cadastraProjeto(
        $nome,
        $local,
        $cursos,
        $temas,
        $descricao,
        $integrantes,
    ) {
        //Verificar se o local ja consta no banco
        //insere os dados na tabela de relacionamentos curso_has_projeto
        //insere os dados na tabela de relacionamentos projeto_has_temas
        //insere os dados na tabela de relacionamentos integrante_has_projeto

    }
}
