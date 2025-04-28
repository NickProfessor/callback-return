<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";
require_once __DIR__ . "/../helpers/Logger.php";


class User
{
    private $conn;
    private $nome;
    private $email;
    private $dataNasc;
    private $foto;
    private $sexo;
    private $fraseSeguranca;
    private $tipo_usuario;

    public function __construct($conn, string $nome, string $email, string $dataNasc, string $sexo, string $fraseSeguranca, string $foto = null, int $tipo_usuario = 1)
    {
        $this->conn = $conn;
        $this->nome = $nome;
        $this->dataNasc = $dataNasc;
        $this->foto = $foto;
        $this->sexo = $sexo;
        $this->fraseSeguranca = $fraseSeguranca;
        $this->email = $email;
        $this->tipo_usuario = $tipo_usuario;
    }

    public function salvarNoBanco()
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO usuario (nome, email, frase_seguranca, sexo, data_nascimento, foto, tipo_usuario ) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                Logger::log("Erro ao preparar a query: " . $this->conn->error);
            }

            $senhaCriptografada = password_hash($this->fraseSeguranca, PASSWORD_DEFAULT);


            $stmt->bind_param(
                "sssssss",
                $this->nome,
                $this->email,
                $senhaCriptografada,
                $this->sexo,
                $this->dataNasc,
                $this->foto,
                $this->tipo_usuario
            );
            $stmt->execute();
            $stmt->close();

            Logger::log("Criou um novo usuário no banco", "ADD");

            return true;

        } catch (Exception $e) {
            Logger::log("Erro ao criar usuário: " . $e->getMessage(), "ERROR");
            return false;
        }
    }

    public static function existeNoBanco($conn, $email)
    {
        try {
            $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
            if (!$stmt) {
                Logger::log("Erro ao preparar a consulta: " . $conn->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id);

            if ($stmt->fetch()) {
                $stmt->close();
                return $id;
            }

            $stmt->close();


            return null;

        } catch (Exception $e) {
            Logger::log("Erro ao consultar usuário: " . $e->getMessage(), "ERROR");
            return null;
        }
    }

    public static function validaAcesso($conn, $id_usuario, $frase)
    {
        try {
            $stmt = $conn->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
            if (!$stmt) {
                Logger::log("Erro ao preparar a consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $usuario = $result->fetch_assoc()) {
                if (password_verify($frase, $usuario['frase_seguranca'])) {
                    self::iniciarSessao($usuario); // 🔹 Inicia a sessão ao validar o login
                    return $usuario;
                }
            }

            return false;

        } catch (Exception $e) {
            Logger::log("Erro ao validar acesso: " . $e->getMessage(), "ERROR");
            return false;
        }
    }

    public static function iniciarSessao($usuario)
    {
        $_SESSION['usuario'] = [
            'id' => $usuario['id_usuario'],
            'nome' => $usuario['nome'],
            'sexo' => $usuario['sexo'],
            'data_nascimento' => $usuario['data_nascimento'],
        ];
    }

    public static function consultaDados($conn, $id_usuario)
    {
        try {
            $stmt = $conn->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
            if (!$stmt) {
                Logger::log("Erro ao preparar a consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $usuario = $result->fetch_assoc()) {
                return $usuario;
            }

            return false;

        } catch (Exception $e) {
            Logger::log("Erro ao consultar dados: " . $e->getMessage(), "ERROR");
            return false;
        }
    }

}
