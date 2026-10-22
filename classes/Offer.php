<?php
    class Offer {
        private PDO $db;

        public function __construct(?PDO $db = null) {
            if ($db === null) {
                $this->db = Database::getConnection();
            } else {
                $this->db = $db;
            }
        }

        /** RE-12: ofertas de hoje de uma entidade. */
        public function todayByEntity(int $entityId): array {
            $stmt = $this->db->prepare(
                'SELECT * FROM oferta WHERE entidade_id = ? AND data = CURDATE() ORDER BY nome'
            );
            $stmt->execute([$entityId]);

            return $stmt->fetchAll();
        }

        /** RE-13: cria uma oferta válida para hoje. */
        public function create(int $entityId, array $dados): int {
            $stmt = $this->db->prepare(
                'INSERT INTO oferta (entidade_id, nome, descricao, fotografia, preco, data, disponivel)
                VALUES (?, ?, ?, ?, ?, CURDATE(), 1)'
            );
            $stmt->execute([
                $entityId,
                $dados['nome'],
                $dados['descricao'],
                $dados['fotografia'],
                $dados['preco']
            ]);

            return (int) $this->db->lastInsertId();
        }

        /** RE-14 / RE-15: só devolve a oferta se pertencer à entidade. */
        public function findByIdAndEntity(int $id, int $entityId): ?array {
            $stmt = $this->db->prepare('SELECT * FROM oferta WHERE id = ? AND entidade_id = ?');
            $stmt->execute([$id, $entityId]);
            $row = $stmt->fetch();

            if ($row === false) {
                return null;
            }
            return $row;
        }

        /** RE-15: atualiza a oferta (só se for da entidade). A fotografia só muda se vier preenchida. */
        public function update(int $id, int $entityId, array $dados): bool {
            $sql = 'UPDATE oferta SET nome = ?, descricao = ?, preco = ?';
            $params = [
                $dados['nome'],
                $dados['descricao'],
                $dados['preco']
            ];

            if (!empty($dados['fotografia'])) {
                $sql .= ', fotografia = ?';
                $params[] = $dados['fotografia'];
            }

            $sql .= ' WHERE id = ? AND entidade_id = ?';
            $params[] = $id;
            $params[] = $entityId;

            $stmt = $this->db->prepare($sql);

            return $stmt->execute($params);
        }

        /** RE-16: remove a oferta (só se for da entidade) e apaga a fotografia. */
        public function delete(int $id, int $entityId): bool {
            $oferta = $this->findByIdAndEntity($id, $entityId);

            if ($oferta === null) {
                return false;
            }

            $stmt = $this->db->prepare('DELETE FROM oferta WHERE id = ? AND entidade_id = ?');
            $ok = $stmt->execute([$id, $entityId]);

            if ($ok && !empty($oferta['fotografia'])) {
                $ficheiro = ROOT . '/uploads/offers/' . basename($oferta['fotografia']);
                if (is_file($ficheiro)) {
                    unlink($ficheiro);
                }
            }

            return $ok;
        }
    }