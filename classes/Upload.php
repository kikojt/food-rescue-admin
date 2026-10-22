<?php
    class Upload {

        /**
         * Guarda uma imagem em uploads/<pasta>/ com nome seguro.
         * Devolve o nome do ficheiro, ou null se for inválida.
         */
        public static function image(array $file, string $folder): ? string {
            if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }

            // Tamanho máximo: 2 MB
            if ($file['size'] > 2 * 1024 * 1024) {
                return null;
            }

            // Tipo real do ficheiro (não confiar na extensão enviada pelo browser)
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);

            $permitidos = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
            ];

            if (!isset($permitidos[$mime])) {
                return null;
            }

            $nome = bin2hex(random_bytes(16)) . '.' . $permitidos[$mime];
            $destino = ROOT . './uploads/' . $folder . '/' . $nome;

            if (!move_uploaded_file($file['tmp_name'], $destino)) {
                return null;
            }

            return $nome;
        }
    }