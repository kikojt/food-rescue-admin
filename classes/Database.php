<?php
    class Database {
        private static ? PDO $instance = null;

        public static function getConnection(): PDO
        {
            if (self::$instance === null) {
                $cfg = require __DIR__ . '/../config/database.php';

                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $cfg['host'], $cfg['port'], $cfg['dbname'], $cfg['charset']
                );

                try {
                    self::$instance = new PDO($dsn, $cfg['user'], $cfg['pass'], [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    die('Erro ao ligar à base de dados.');
                }
            }
            return self::$instance;
        }
    }

?>