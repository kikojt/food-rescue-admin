<?php
    class Auth {

        /** Guarda os dados na sessão depois de um login correto. */
        public static function login(string $role, int $id, string $username): void {
            session_regenerate_id(true);

            $_SESSION['role'] = $role;          // 'admin' ou 'entity'
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
        }

        public static function isAdmin(): bool {
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                return true;
            }
            return false;
        }

        public static function isEntity(): bool {
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'entity') {
                return true;
            }
            return false;
        }

        /** Para pôr no topo das páginas do administrador. */
        public static function requireAdmin(): void {
            if (!self::isAdmin()) {
                header('Location: index.php');
                exit();
            }
        }

        /** Para pôr no topo das páginas da entidade. */
        public static function requireEntity(): void {
            if (!self::isEntity()) {
                header('Location: index.php');
                exit();
            }

            // Se o admin desativou a conta enquanto a entidade estava com sessão aberta, expulsa-a
            $entityModel = new Entity();
            $entidade = $entityModel->findById((int) $_SESSION['id']);

            if ($entidade === null || $entidade['ativo'] != 1) {
                self::logout();
                header('Location: index.php');
                exit();
            }
        }

        /** RE-4 / RE-17: termina a sessão, mantendo só o idioma escolhido. */
        public static function logout(): void {
            unset($_SESSION['role']);
            unset($_SESSION['id']);
            unset($_SESSION['username']);

            session_regenerate_id(true);
        }

        public static function id(): int {
            return (int) ($_SESSION['id'] ?? 0);
        }
    }

?>