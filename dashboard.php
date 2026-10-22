<?php
    include('config/conf.php');
    Auth::requireAdmin();

    // Idioma e textos
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }
    require_once ROOT . './Languages/' . $_SESSION['lang'] . '.php';

    $adminModel = new Admin();
    $entityModel = new Entity();

    // Nome do admin autenticado (o id vem da sessão)
    $admin = $adminModel->findById(Auth::id());
    if ($admin === null) {
        Auth::logout();
        header('Location: index.php');
        exit();
    }
    $adminName = $admin['nome'];

    $errorMsg = '';
    $successMsg = '';
    $abrirModal = '';

    // Valores do formulário "adicionar entidade" (para não se perderem em caso de erro)
    $novo = ['nome' => '', 'descricao' => '', 'morada' => '', 'telefone' => '', 'email' => ''];

    // Entidade adicionada com sucesso
    if (isset($_GET['success']) && $_GET['success'] === 'true') {
        $successMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_SUCCESS;
    }

    // RE-3: alterar a password do admin
    if (isset($_POST['alteraPassword'])) {
        $oldPassword = $_POST['oldPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';

        if ($oldPassword === '') {
            $errorMsg = DASHBOARD_PASSWORD_MSG_ERROR_EMPTY_OLD_PASSWORD;
        } elseif ($newPassword === '') {
            $errorMsg = DASHBOARD_PASSWORD_MSG_ERROR_EMPTY_NEW_PASSWORD;
        } elseif (strlen($newPassword) < 8) {
            $errorMsg = PASSWORD_MSG_ERROR_SHORT;
        } elseif ($oldPassword === $newPassword) {
            $errorMsg = DASHBOARD_PASSWORD_MSG_ERROR_SAME_PASSWORD;
        } elseif ($adminModel->changePassword(Auth::id(), $oldPassword, $newPassword)) {
            $successMsg = DASHBOARD_PASSWORD_MSG_SUCCESS;
        } else {
            $errorMsg = DASHBOARD_PASSWORD_MSG_ERROR_BAD_PASSWORD;
        }

        if ($errorMsg !== '') {
            $abrirModal = 'modalChangePassword';
        }
    }

    // RE-10: ativar / desativar
    if (isset($_POST['toggleConta'])) {
        $entityModel->toggleAtivo((int) $_POST['toggleConta']);
        header('Location: dashboard.php');
        exit();
    }

    // RE-7: adicionar entidade
    if (isset($_POST['adicionaEntidade'])) {
        $novo['nome'] = trim($_POST['nome'] ?? '');
        $novo['descricao'] = trim($_POST['descricao'] ?? '');
        $novo['morada'] = trim($_POST['morada'] ?? '');
        $novo['telefone'] = trim($_POST['telefone'] ?? '');
        $novo['email'] = trim($_POST['email'] ?? '');
        $novaPassword = $_POST['password'] ?? '';

        if ($novo['nome'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_NAME;
        } elseif ($novo['descricao'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_DESCRIPTION;
        } elseif ($novo['morada'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_ADDRESS;
        } elseif ($novo['telefone'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PHONE;
        } elseif ($novo['email'] === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_EMAIL;
        } elseif (!filter_var($novo['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_INVALID;
        } elseif ($novaPassword === '') {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PASSWORD;
        } elseif (strlen($novaPassword) < 8) {
            $errorMsg = PASSWORD_MSG_ERROR_SHORT;
        } elseif (empty($_FILES['logoEntidade']['name'])) {
            $errorMsg = DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_FOTO;
        } elseif ($entityModel->emailExists($novo['email'])) {
            $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_ALREADY_EXISTS;
        } else {
            $logotipo = Upload::image($_FILES['logoEntidade'], 'logos');

            if ($logotipo === null) {
                $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_LOGO_INVALID;
            } else {
                $dados = $novo;
                $dados['password'] = $novaPassword;
                $dados['logotipo'] = $logotipo;

                $idNovo = $entityModel->create($dados);

                if ($idNovo !== null) {
                    header('Location: dashboard.php?success=true');
                    exit();
                }
                $errorMsg = DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_ALREADY_EXISTS;
            }
        }

        if ($errorMsg !== '') {
            $abrirModal = 'modalAddEntidade';
        }
    }

    // RE-6: listagem
    $entidades = $entityModel->all();
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
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 mb-4 border-bottom" style="background-color: #056365;">
            <div class="col-md-2 text-end d-flex align-items-center justify-content-center">
                <img style="margin-left: 30px;" src="Images/Logo.svg" alt="logo">
            </div>
            <div class="col-md-auto text-end d-flex align-items-center">
                <h4 style="color: #ffff"><?php echo DASHBOARD_SALUTATION . htmlspecialchars($adminName) . "!"; ?></h4>
            </div>
            <div class="col-md-2 text-end d-flex align-items-center">
                <button type="button" class="btn btn-light btn-menu" name="changePassword" style="margin: 10px; background: none; border: none; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalChangePassword">
                    <img src="Images/icon_padlock.png" alt="Password" style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                </button>
                <!-- Modal para alterar a password do 'Admin' -->
                <div class="modal fade" id="modalChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="titleChangePassword" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="titleChangePassword"><?php echo DASHBOARD_MODAL_TITLE ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="">
                                <form action="" method="POST">
                                    <div class="row justify-content-center text-align-center">
                                        <div class="form-group col-sm-8 flex-column d-flex my-1">
                                            <label for="oldPassword" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_OLD_PASSWORD ?><span class="text-danger">*</span></label>
                                            <input type="password" id="oldPassword" name="oldPassword" placeholder="<?php echo DASHBOARD_TEXT_FIELD_OLD_PASSWORD ?>" required>
                                        </div>
                                        <div class="form-group col-sm-8 flex-column d-flex mb-3">
                                            <label for="newPassword" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_NEW_PASSWORD ?><span class="text-danger">*</span></label>
                                            <input type="password" id="newPassword" name="newPassword" minlength="8" placeholder="<?php echo DASHBOARD_TEXT_FIELD_NEW_PASSWORD ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" name="alteraPassword"><?php echo DASHBOARD_TEXT_BUTTON ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- RE-4: logout -->
                <form action="logout.php" method="POST" class="ms-2" onsubmit="return confirm('<?php echo ACCOUNT_LOGOUT_CONFIRM ?>');">
                    <button type="submit" class="btn btn-light btn-menu" style="margin: 10px; background: none; border: none; cursor: pointer;">
                        <img src="Images/icon_logout.png" alt="Logout" style="width: 25px; height: 25px; filter: brightness(0) invert(1);">
                    </button>
                </form>
            </div>
        </header>
        <main>
            <!-- Secção para exibir as mensagens de erro/sucesso -->
            <div class="container d-flex justify-content-center align-items-center">
                <?php if ($successMsg !== '' || $errorMsg !== '') : ?>
                    <div id="notification" class="alert <?php echo $successMsg !== '' ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                        <?php echo $successMsg !== '' ? $successMsg : $errorMsg; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (empty($entidades)) { ?>
                <h2 class="text-center mb-5"><?php echo ENTITIES_MSG_INFORM_EMPTY_LIST; ?></h2>
            <?php } else { ?>
                <h3 class="text-center mb-5"><?php echo DASHBOARD_ENTITIES_LIST_TITLE; ?></h3>

                <div class="container d-flex justify-content-center align-items-center">
                    <table class="table table-hover">
                        <thead class="table-info text-center align-middle">
                            <tr>
                                <th scope="col"><h5 class="m-0"><b><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_NAME; ?></b></h5></th>
                                <th scope="col"><h5 class="m-0"><b><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_DESCRIPTION; ?></b></h5></th>
                                <th scope="col"><h5 class="m-0"><b><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_ADDRESS; ?></b></h5></th>
                                <th scope="col"><h5 class="m-0"><b><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_EMAIL; ?></b></h5></th>
                                <th scope="col"><h5 class="m-0"><b><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_ACCOUNT_STATUS; ?></b></h5></th>
                                <th scope="col"><h5 class="m-0"><b><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_INFO; ?></b></h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entidades as $entidade) { ?>
                                <tr class="text-center align-middle">
                                    <td><?php echo htmlspecialchars($entidade['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($entidade['descricao']); ?></td>
                                    <td><?php echo htmlspecialchars($entidade['morada']); ?></td>
                                    <td><?php echo htmlspecialchars($entidade['email']); ?></td>
                                    <!-- RE-10: ativar/desativar -->
                                    <td>
                                        <?php if ($entidade['ativo'] == 1) { ?>
                                            <form action="" method="POST" onsubmit="return confirm('<?php echo ACCOUNT_STATUS_CONFIRM[1] ?>');">
                                                <button type="submit" class="btn btn-success my-2 py-1 px-2" name="toggleConta" value="<?php echo (int) $entidade['id']; ?>"><?php echo ACCOUNT_STATUS[0] ?></button>
                                            </form>
                                        <?php } else { ?>
                                            <form action="" method="POST" onsubmit="return confirm('<?php echo ACCOUNT_STATUS_CONFIRM[0] ?>');">
                                                <button type="submit" class="btn btn-danger my-2 py-1 px-2" name="toggleConta" value="<?php echo (int) $entidade['id']; ?>"><?php echo ACCOUNT_STATUS[1] ?></button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                    <!-- RE-8: ver detalhes -->
                                    <td>
                                        <a href="detailsEntity.php?id=<?php echo (int) $entidade['id']; ?>" class="btn btn-secondary py-1 px-2"><?php echo DASHBOARD_ENTITIES_ATTRIBUTES_DETAILS ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

            <div class="text-center">
                <button type="button" class="btn btn-secondary my-5" name="addEntidade" data-bs-toggle="modal" data-bs-target="#modalAddEntidade"><?php echo DASHBOARD_MODAL_ADD_ENTITY_TITLE ?></button>
            </div>

            <!-- Modal para adicionar uma Entidade -->
            <div class="modal fade" id="modalAddEntidade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="titleAddEntidade" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titleAddEntidade"><?php echo DASHBOARD_MODAL_ADD_ENTITY_TITLE ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row justify-content-center text-align-center">
                                    <div class="form-group col-sm-11 flex-column d-flex">
                                        <label for="nome" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_NAME ?><span class="text-danger">*</span></label>
                                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($novo['nome']); ?>" placeholder="<?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_NAME ?>" required>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="descricao" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_DESCRIPTION ?><span class="text-danger">*</span></label>
                                        <textarea id="descricao" name="descricao" placeholder="<?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_DESCRIPTION ?>" required><?php echo htmlspecialchars($novo['descricao']); ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="logoEntidade" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_LOGOTIPO ?><span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="logoEntidade" name="logoEntidade" accept=".jpeg, .jpg, .png, .gif" required>
                                        <small class="form-text text-muted text-center"><?php echo DASHBOARD_MODAL_ADD_ENTITY_INFO_LOGOTIPO ?></small>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="morada" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_ADDRESS ?><span class="text-danger">*</span></label>
                                        <input type="text" id="morada" name="morada" value="<?php echo htmlspecialchars($novo['morada']); ?>" placeholder="<?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_ADDRESS ?>" required>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="telefone" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_PHONE ?><span class="text-danger">*</span></label>
                                        <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($novo['telefone']); ?>" placeholder="<?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_PHONE ?>" required>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="email" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_EMAIL ?><span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($novo['email']); ?>" placeholder="<?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_EMAIL ?>" required>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex mb-3">
                                        <label for="password" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_MODAL_ADD_ENTITY_PASSWORD ?><span class="text-danger">*</span></label>
                                        <input type="password" id="password" name="password" minlength="8" placeholder="<?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_PASSWORD ?>" required>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success" name="adicionaEntidade"><?php echo DASHBOARD_MODAL_ADD_ENTITY_TEXT_BUTTON ?></button>
                                </div>
                            </form>
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
        <?php if ($abrirModal !== '') { ?>
            <script>
                new bootstrap.Modal(document.getElementById('<?php echo $abrirModal; ?>')).show();
            </script>
        <?php } ?>
    </body>
</html>