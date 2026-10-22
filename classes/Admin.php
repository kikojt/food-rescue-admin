<?php
    class Admin {
        private PDO $db;

        public function __construct(? PDO $db = null) {
            if ($db === null) {
                $this->db = Database::getConnection();
            } else {
                $this->db = $db;
            }
        }

        public function count(): int {
            $stmt = $this->db->query('SELECT COUNT(*) FROM admin');
            $total = $stmt->fetchColumn();

            return (int) $total;
        }

        public function exists(): bool {
            $total = $this->count();   //Quantos admins existem

            if ($total > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function findByUsername(string $username): ? array {
            $stmt = $this->db->prepare('SELECT * FROM admin WHERE username = ?');
            $stmt->execute([$username]);
            $row = $stmt->fetch();

            if ($row === false) {
                return null;
            }
            return $row;
        }

        public function findById(int $id): ? array {
            $stmt = $this->db->prepare('SELECT * FROM admin WHERE id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();

            if ($row === false) {
                return null;
            }
            return $row;
        }

        /** RE-1: só permite criar se ainda não existir nenhum admin. */
        public function create(string $username, string $nome, string $password): bool {
            if ($this->exists()) {
                return false;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                'INSERT INTO admin (username, nome, password) VALUES (?, ?, ?)'
            );

            return $stmt->execute([$username, $nome, $hash]);
        }

        public function verifyPassword(array $admin, string $password): bool {
            $hashGuardado = $admin['password'];
            $correta = password_verify($password, $hashGuardado);

            return $correta;
        }

        /** RE-3: só altera se a password atual estiver correta. */
        public function changePassword(int $id, string $currentPassword, string $newPassword): bool {
            $admin = $this->findById($id);

            if (!$admin) {
                return false;
            }
            if (!$this->verifyPassword($admin, $currentPassword)) {
                return false;
            }

            $hash = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare('UPDATE admin SET password = ? WHERE id = ?');

            return $stmt->execute([$hash, $id]);
        }

    }