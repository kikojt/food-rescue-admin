<?php
    include('./config/conf.php');

    // 1. Mudar o idioma (antes de carregar os textos)
    if (isset($_POST['pt']) || isset($_POST['en'])) {
        if (isset($_POST['pt'])) {
            $_SESSION['lang'] = 'pt';
        } else {
            $_SESSION['lang'] = 'en';
        }
        header('Location: addAdmin.php');
        exit();
    }

    // 2. Idioma por omissão e carregamento dos textos
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }
    require_once ROOT . './Languages/' . $_SESSION['lang'] . '.php';

    $adminModel = new Admin();

    // 3. Se já existe admin, esta página deixa de estar disponível (RE-1)
    if ($adminModel->exists()) {
        header('Location: index.php');
        exit();
    }

    // 4. Criar o administrador
    $errorMsg = '';
    $successMsg = '';
    $newAdminUsername = '';
    $newAdminName = '';

    if (isset($_POST['adicionarAdmin'])) {
        $newAdminUsername = trim($_POST['newAdminUsername'] ?? '');
        $newAdminName = trim($_POST['newAdminName'] ?? '');
        $newAdminPassword = $_POST['newAdminPassword'] ?? '';
        $newAdminPasswordConfirm = $_POST['newAdminPasswordConfirm'] ?? '';

        if ($newAdminUsername === '') {
            $errorMsg = ADD_ADMIN_MSG_ERROR_EMPTY_USERNAME;
        } elseif ($newAdminName === '') {
            $errorMsg = ADD_ADMIN_MSG_ERROR_EMPTY_NAME;
        } elseif ($newAdminPassword === '') {
            $errorMsg = ADD_ADMIN_MSG_ERROR_EMPTY_PASSWORD;
        } elseif (strlen($newAdminPassword) < 8) {
            $errorMsg = ADD_ADMIN_MSG_ERROR_PASSWORD_SHORT;
        } elseif ($newAdminPassword !== $newAdminPasswordConfirm) {
            $errorMsg = ADD_ADMIN_MSG_ERROR_PASSWORD_MISMATCH;
        } else {
            $criado = $adminModel->create($newAdminUsername, $newAdminName, $newAdminPassword);

            if ($criado) {
                header('Location: index.php');
                exit();
            } else {
                $errorMsg = ADD_ADMIN_MSG_ERROR_CREATE;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Too Good To Go</title>
        <link rel="stylesheet" href="Styles/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="https://play-lh.googleusercontent.com/Ht7OXfuYPvtSdFl7PnuX6KisTLgSceF9krOmxof7klTgqNR7UBVc53z63Vm3NuOQ0eo=w240-h480-rw" type="image/x-icon">
    </head>
    <body class="body-login">
        <div class="container-fluid px-1 mx-auto">
            <div class="d-flex justify-content-center align-items-center">
                <div class="col-xl-6 col-lg-7 col-md-8 col-12 text-center">
                    <img src="Images/logo.svg" alt="logo" class="logotipo" width="150px" height="150px">
                    <div class="change-lang">
                        <form action="" method="POST">
                            <?php if ($_SESSION['lang'] == 'en') { ?>
                                <button type="submit" name="pt" class="btn btn-dark">PT</button>
                                <button type="submit" name="en" class="btn btn-dark disabled">EN</button>
                            <?php } else { ?>
                                <button type="submit" name="pt" class="btn btn-dark disabled">PT</button>
                                <button type="submit" name="en" class="btn btn-dark">EN</button>
                            <?php } ?>
                        </form>
                    </div>
                    <div class="card" id="login" style="display: block">
                        <h5 class="mb-3"><b><?php echo ADD_ADMIN_TEXT ?></b></h5>
                        <!-- Secção para exibir as mensagens de erro/sucesso -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <?php if (!empty($successMsg) || !empty($errorMsg)) : ?>
                                <div id="notification" class="alert <?php echo !empty($successMsg) ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                    <?php echo !empty($successMsg) ? $successMsg : $errorMsg; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <form action="" method="POST">
                            <div class="row justify-content-center">
                                <div class="form-group col-sm-7 flex-column d-flex my-1">
                                    <label for="newAdminUsername" class="form-control-label px-3 py-1"><?php echo ADD_ADMIN_TEXT_USERNAME ?><span class="text-danger">*</span></label>
                                    <input type="text" id="newAdminUsername" name="newAdminUsername" value="<?php echo htmlspecialchars($newAdminUsername); ?>" placeholder="<?php echo ADD_ADMIN_TEXT_FIELD_USERNAME ?>" required>
                                </div>
                                <div class="form-group col-sm-7 flex-column d-flex my-1">
                                    <label for="newAdminName" class="form-control-label px-3 py-1"><?php echo ADD_ADMIN_TEXT_NAME ?><span class="text-danger">*</span></label>
                                    <input type="text" id="newAdminName" name="newAdminName" value="<?php echo htmlspecialchars($newAdminName); ?>" placeholder="<?php echo ADD_ADMIN_TEXT_FIELD_NAME ?>" required>
                                </div>
                                <div class="form-group col-sm-7 flex-column d-flex my-1">
                                    <label for="newAdminPassword" class="form-control-label px-3 py-1"><?php echo ADD_ADMIN_TEXT_PASSWORD ?><span class="text-danger">*</span></label>
                                    <input type="password" id="newAdminPassword" name="newAdminPassword" minlength="8" placeholder="<?php echo ADD_ADMIN_TEXT_FIELD_PASSWORD ?>" required>
                                </div>
                                <div class="form-group col-sm-7 flex-column d-flex my-1 mb-3">
                                    <label for="newAdminPasswordConfirm" class="form-control-label px-3 py-1"><?php echo ADD_ADMIN_TEXT_PASSWORD_CONFIRM ?><span class="text-danger">*</span></label>
                                    <input type="password" id="newAdminPasswordConfirm" name="newAdminPasswordConfirm" minlength="8" placeholder="<?php echo ADD_ADMIN_TEXT_FIELD_PASSWORD_CONFIRM ?>" required>
                                </div>
                                <div class="pt-3 pb-3 form-group col-sm-12">
                                    <button type="submit" class="btn btn-success" name="adicionarAdmin"><?php echo ADD_ADMIN_TEXT_BUTTON ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var notification = document.getElementById('notification');
            if (notification) {
                setTimeout(function () {
                    notification.style.display = 'none';
                }, 2000);
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>