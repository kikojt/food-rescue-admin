<?php
    include('config/conf.php');
    Auth::requireAdmin();

    // Idioma e textos
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }
    require_once ROOT . './Languages/' . $_SESSION['lang'] . '.php';

    $entityModel = new Entity();

    // O id vem do URL, por isso é convertido e validado
    $id = (int) ($_GET['id'] ?? 0);
    $entidade = $entityModel->findById($id);

    if ($entidade === null) {
        header('Location: dashboard.php');
        exit();
    }

    $errorMsg = '';
    $successMsg = '';
    $abrirModal = false;

    // Valores do formulário de edição (RE-9: preenchidos com os valores atuais)
    $form = [
        'nome' => $entidade['nome'],
        'descricao' => $entidade['descricao'],
        'morada' => $entidade['morada'],
        'telefone' => $entidade['telefone'],
        'email' => $entidade['email']
    ];

    // Entidade editada com sucesso
    if (isset($_GET['success']) && $_GET['success'] === 'true') {
        $successMsg = DETAILS_MODAL_EDIT_ENTITY_MSG_SUCCESS;
    }

    // RE-9: editar a entidade
    if (isset($_POST['editarEntidade'])) {
        $form['nome'] = trim($_POST['nome'] ?? '');
        $form['descricao'] = trim($_POST['descricao'] ?? '');
        $form['morada'] = trim($_POST['morada'] ?? '');
        $form['telefone'] = trim($_POST['telefone'] ?? '');
        $form['email'] = trim($_POST['email'] ?? '');
        $novaPassword = $_POST['password'] ?? '';
        $enviouLogo = !empty($_FILES['logoEntidade']['name']);

        if ($form['nome'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_NAME;
        } elseif ($form['descricao'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_DESCRIPTION;
        } elseif ($form['morada'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_ADDRESS;
        } elseif ($form['telefone'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PHONE;
        } elseif ($form['email'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_EMAIL;
        } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_INVALID;
        } elseif ($novaPassword !== '' && strlen($novaPassword) < 8) {
            $errorMsg = PASSWORD_MSG_ERROR_SHORT;
        } elseif ($entityModel->emailExists($form['email'], $id)) {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_ALREADY_EXISTS;
        } else {
            $dados = $form;
            $dados['password'] = $novaPassword;   // vazia = mantém a atual
            $dados['logotipo'] = '';              // vazio = mantém o atual
            $logoAntigo = $entidade['logotipo'];
            $logoNovo = null;

            if ($enviouLogo) {
                $logoNovo = Upload::image($_FILES['logoEntidade'], 'logos');

                if ($logoNovo === null) {
                    $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_LOGO_INVALID;
                } else {
                    $dados['logotipo'] = $logoNovo;
                }
            }

            if ($errorMsg === '') {
                if ($entityModel->update($id, $dados)) {
                    // Apaga o logotipo antigo, se foi substituído
                    if ($logoNovo !== null && !empty($logoAntigo)) {
                        $ficheiro = ROOT . '/uploads/logos/' . basename($logoAntigo);
                        if (is_file($ficheiro)) {
                            unlink($ficheiro);
                        }
                    }
                    header('Location: detailsEntity.php?id=' . $id . '&success=true');
                    exit();
                }
                $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_ALREADY_EXISTS;
            }
        }

        if ($errorMsg !== '') {
            $abrirModal = true;
        }
    }

    // Logotipo: só mostra se o ficheiro existir
    $logoNome = basename((string) ($entidade['logotipo'] ?? ''));
    $temLogo = $logoNome !== '' && is_file(ROOT . '/uploads/logos/' . $logoNome);
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Too Good To Go - Admin</title>
        <link rel="stylesheet" href="Styles/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="https://play-lh.googleusercontent.com/Ht7OXfuYPvtSdFl7PnuX6KisTLgSceF9krOmxof7klTgqNR7UBVc53z63Vm3NuOQ0eo=w240-h480-rw" type="image/x-icon">
    </head>
    <body style="background-color: #b2d0d1">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 border-bottom" style="background-color: #056365;">
            <div class="col-md-2 text-end d-flex align-items-center justify-content-center">
                <img style="margin-left: 30px;" src="Images/Logo.svg" alt="logo">
            </div>
            <div class="col-md-auto text-end d-flex align-items-center">
                <h4 style="color: #ffff"><?php echo ENTITIES_DETAILS_TITLE . " - '" . htmlspecialchars($entidade['nome']) . "'"; ?></h4>
            </div>
            <div class="col-md-2 text-end d-flex align-items-center justify-content-center">
                <a href="dashboard.php" class="btn btn-light btn-menu" style="margin: 10px; background: none; border: none;">
                    <img src="Images/icon_back.png" alt="Voltar" style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                </a>
            </div>
        </header>
        <main>
            <!-- Mensagens de erro/sucesso -->
            <div class="container d-flex justify-content-center align-items-center">
                <?php if ($successMsg !== '' || $errorMsg !== '') : ?>
                    <div id="notification" class="alert <?php echo $successMsg !== '' ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                        <?php echo $successMsg !== '' ? $successMsg : $errorMsg; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RE-8: detalhes da entidade -->
            <div class="row mx-1 d-flex justify-content-center align-items-center text-align-center">
                <div class="text-center">
                    <?php if ($temLogo) { ?>
                        <img class="m-4" src="uploads/logos/<?php echo htmlspecialchars($logoNome); ?>" alt="logotipo" height="200px">
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_NAME ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5 class="mb-0"><?php echo htmlspecialchars($entidade['nome']); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_DESCRIPTION ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo nl2br(htmlspecialchars((string) $entidade['descricao'])); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_ADDRESS ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo htmlspecialchars((string) $entidade['morada']); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_PHONE ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo htmlspecialchars((string) $entidade['telefone']); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_EMAIL ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo htmlspecialchars($entidade['email']); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_PASSWORD ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5>**********</h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo ENTITIES_DETAILS_ACCOUNT_STATUS ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo htmlspecialchars($entidade['ativo'] == 1 ? ACCOUNT_STATUS[0] : ACCOUNT_STATUS[1]); ?></h5></div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-secondary my-3" data-bs-toggle="modal" data-bs-target="#modalEditEntidade"><?php echo DASHBOARD_MODAL_EDIT_ENTITY_TITLE ?></button>
                </div>

                <!-- RE-9: modal para editar a entidade -->
                <div class="modal fade" id="modalEditEntidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editEntityModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editEntityModalLabel"><?php echo DASHBOARD_MODAL_EDIT_ENTITY_TITLE ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row justify-content-center text-align-center">
                                        <div class="form-group col-sm-11 flex-column d-flex">
                                            <label for="nome" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_NAME ?><span class="text-danger">*</span></label>
                                            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($form['nome']); ?>" required>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="descricao" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_DESCRIPTION ?><span class="text-danger">*</span></label>
                                            <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars((string) $form['descricao']); ?></textarea>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="logoEntidade" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_LOGOTIPO ?></label>
                                            <input class="form-control" type="file" id="logoEntidade" name="logoEntidade" accept=".jpeg, .jpg, .png, .gif">
                                            <small class="form-text text-muted text-center"><?php echo DASHBOARD_MODAL_ADD_ENTITY_INFO_LOGOTIPO ?></small>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="morada" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_ADDRESS ?><span class="text-danger">*</span></label>
                                            <input type="text" id="morada" name="morada" value="<?php echo htmlspecialchars((string) $form['morada']); ?>" required>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="telefone" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_PHONE ?><span class="text-danger">*</span></label>
                                            <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars((string) $form['telefone']); ?>" required>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="email" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_EMAIL ?><span class="text-danger">*</span></label>
                                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form['email']); ?>" required>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex mb-3">
                                            <label for="password" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DETAILS_MODAL_EDIT_ENTITY_PASSWORD ?></label>
                                            <input type="password" id="password" name="password" minlength="8" placeholder="***********">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success" name="editarEntidade"><?php echo DETAILS_MODAL_EDIT_ENTITY_TEXT_BUTTON ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            var notification = document.getElementById('notification');
            if (notification) {
                setTimeout(function () {
                    notification.style.display = 'none';
                }, 2000);
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <?php if ($abrirModal) { ?>
            <script>
                new bootstrap.Modal(document.getElementById('modalEditEntidade')).show();
            </script>
        <?php } ?>
    </body>
</html>