<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/db_connect.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
                throw new Exception("Erro ao preparar a query: " . $this->conn->error);
            }

            $stmt->bind_param(
                "sssssss",
                $this->nome,
                $this->email,
                $this->fraseSeguranca,
                $this->sexo,
                $this->dataNasc,
                $this->foto,
                $this->tipo_usuario
            );
            $stmt->execute();
            $stmt->close();
            return true;

        } catch (Exception $e) {
            error_log("Erro ao salvar usuário no banco: " . $e->getMessage());
            return false;
        }
    }

    public static function existeNoBanco($conn, $email)
    {
        try {
            $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
            if (!$stmt) {
                throw new Exception("Erro ao preparar a consulta: " . $conn->error);
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
            error_log("Erro na consulta de usuário: " . $e->getMessage());
            return null;
        }
    }

    public static function validaAcesso($conn, $id_usuario, $frase)
    {
        try {
            $stmt = $conn->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
            if (!$stmt) {
                throw new Exception("Erro ao preparar a consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $usuario = $result->fetch_assoc()) {
                if ($usuario['frase_seguranca'] === $frase) {
                    self::iniciarSessao($usuario); // 🔹 Inicia a sessão ao validar o login
                    return $usuario;
                }
            }

            return false;

        } catch (Exception $e) {
            error_log("Erro na validação de acesso: " . $e->getMessage());
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

    public static function verificaSessao()
    {
        return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header("Location: login.php"); // 🔹 Redireciona para a página de login após logout
        exit;
    }
}
