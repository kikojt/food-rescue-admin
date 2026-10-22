<?php
    class Entity {
        private PDO $db;

        public function __construct(?PDO $db = null) {
            if ($db === null) {
                $this->db = Database::getConnection();
            } else {
                $this->db = $db;
            }
        }

        /** RE-6: lista todas as entidades. */
        public function all(): array {
            $stmt = $this->db->query('SELECT * FROM entidade ORDER BY nome');

            return $stmt->fetchAll();
        }

        /** RE-8 / RE-9: procura uma entidade pelo id. */
        public function findById(int $id): ?array {
            $stmt = $this->db->prepare('SELECT * FROM entidade WHERE id = ?');
            $stmt->execute([$id]);
            $row = $stmt->fetch();

            if ($row === false) {
                return null;
            }
            return $row;
        }

        /** RE-11: procura uma entidade pelo email (login). */
        public function findByEmail(string $email): ?array {
            $stmt = $this->db->prepare('SELECT * FROM entidade WHERE email = ?');
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            if ($row === false) {
                return null;
            }
            return $row;
        }

        /** RE-7: verifica se o email já existe. Ao editar, ignora a própria entidade. */
        public function emailExists(string $email, ?int $ignoreId = null): bool {
            if ($ignoreId === null) {
                $stmt = $this->db->prepare('SELECT COUNT(*) FROM entidade WHERE email = ?');
                $stmt->execute([$email]);
            } else {
                $stmt = $this->db->prepare('SELECT COUNT(*) FROM entidade WHERE email = ? AND id <> ?');
                $stmt->execute([$email, $ignoreId]);
            }

            $total = (int) $stmt->fetchColumn();

            if ($total > 0) {
                return true;
            } else {
                return false;
            }
        }

        /** RE-7: cria a entidade (ativa por omissão). Devolve o id novo ou null se o email já existe. */
        public function create(array $dados): ?int {
            if ($this->emailExists($dados['email'])) {
                return null;
            }

            $hash = password_hash($dados['password'], PASSWORD_DEFAULT);

            $stmt = $this->db->prepare(
                'INSERT INTO entidade (nome, descricao, logotipo, morada, telefone, email, password, ativo)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)'
            );
            $stmt->execute([
                $dados['nome'],
                $dados['descricao'],
                $dados['logotipo'],
                $dados['morada'],
                $dados['telefone'],
                $dados['email'],
                $hash
            ]);

            return (int) $this->db->lastInsertId();
        }

        /** RE-9: atualiza os dados. Logotipo e password só mudam se vierem preenchidos. */
        public function update(int $id, array $dados): bool {
            if ($this->emailExists($dados['email'], $id)) {
                return false;
            }

            $sql = 'UPDATE entidade SET nome = ?, descricao = ?, morada = ?, telefone = ?, email = ?';
            $params = [
                $dados['nome'],
                $dados['descricao'],
                $dados['morada'],
                $dados['telefone'],
                $dados['email']
            ];

            if (!empty($dados['logotipo'])) {
                $sql .= ', logotipo = ?';
                $params[] = $dados['logotipo'];
            }

            if (!empty($dados['password'])) {
                $sql .= ', password = ?';
                $params[] = password_hash($dados['password'], PASSWORD_DEFAULT);
            }

            $sql .= ' WHERE id = ?';
            $params[] = $id;

            $stmt = $this->db->prepare($sql);

            return $stmt->execute($params);
        }

        /** RE-10: inverte o estado ativo/inativo. */
        public function toggleAtivo(int $id): bool {
            $stmt = $this->db->prepare('UPDATE entidade SET ativo = 1 - ativo WHERE id = ?');

            return $stmt->execute([$id]);
        }

        public function verifyPassword(array $entity, string $password): bool {
            $hashGuardado = $entity['password'];
            $correta = password_verify($password, $hashGuardado);

            return $correta;
        }
    }