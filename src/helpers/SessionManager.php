<?php



class SessionManager
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        self::start();
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn()
    {
        self::start();
        return isset($_SESSION['usuario']);
    }

    public static function requireLogin($tipoUsuario = null)
    {
        self::start();

        if (!isset($_SESSION['usuario'])) {
            header("Location: ../../index.php?acesso-negado");
            exit();
        }

        if ($tipoUsuario !== null && $_SESSION['usuario']['tipo_usuario'] != $tipoUsuario) {
            header("Location: ../../index.php?acesso-negado");
            exit();
        }
    }
}
