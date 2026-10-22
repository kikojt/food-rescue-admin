<?php
    include('./config/conf.php');

    // 1. Mudar o idioma (processado primeiro, antes de carregar os textos)
    if (isset($_POST['pt']) || isset($_POST['en'])) {
        if (isset($_POST['pt'])) {
            $_SESSION['lang'] = 'pt';
        } else {
            $_SESSION['lang'] = 'en';
        }
        header('Location: index.php');
        exit();
    }

    // 2. Idioma por omissão (vem do conf.php, RG-1) e carregamento dos textos
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }
    require_once ROOT . './Languages/' . $_SESSION['lang'] . '.php';

    // 3. Se já tem sessão iniciada, vai para o dashboard certo
    if (Auth::isAdmin()) {
        header('Location: dashboard.php');
        exit();
    }
    if (Auth::isEntity()) {
        header('Location: dashboard.php');
        exit();
    }

    $adminModel = new Admin();
    $entityModel = new Entity();

    // 4. Se não existir nenhum Admin, vai criar um (RE-1)
    if (!$adminModel->exists()) {
        header('Location: addAdmin.php');
        exit();
    }

    // 5. Login
    $errorMsg = '';
    $successMsg = '';

    if (isset($_POST['login'])) {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '') {
            $errorMsg = LOGIN_MSG_ERROR_EMPTY_USERNAME;
        } elseif ($password === '') {
            $errorMsg = LOGIN_MSG_ERROR_EMPTY_PASSWORD;
        } else {
            // Primeiro tenta como Admin
            $admin = $adminModel->findByUsername($username);

            if ($admin !== null) {
                if ($adminModel->verifyPassword($admin, $password)) {
                    Auth::login('admin', (int) $admin['id'], $admin['username']);
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $errorMsg = LOGIN_MSG_ERROR_BAD_PASSWORD;
                }
            } else {
                // Se não é Admin, o username é tratado como email da Entidade
                $entidade = $entityModel->findByEmail($username);

                if ($entidade === null) {
                    $errorMsg = LOGIN_MSG_ERROR_BAD_USERNAME_EMAIL;
                } elseif ($entidade['ativo'] != 1) {
                    $errorMsg = LOGIN_MSG_ERROR_ACCOUNT_INACTIVE;
                } elseif (!$entityModel->verifyPassword($entidade, $password)) {
                    $errorMsg = LOGIN_MSG_ERROR_BAD_PASSWORD;
                } else {
                    Auth::login('entity', (int) $entidade['id'], $entidade['email']);
                    header('Location: dashboardEntity.php');
                    exit();
                }
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
                    <img src="Images/logo.svg" alt="logo" class="logotipo" width="200px" height="200px">
                    <div class="card" id="login" style="display: block">
                        <h3 class="mb-3"><b><?php echo LOGIN_TEXT ?></b></h3>
                        <!-- Secção para exibir as mensagens de erro/sucesso -->
                        <?php if (!empty($successMsg) || !empty($errorMsg)) : ?>
                            <div id="notification" class="alert <?php echo !empty($successMsg) ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                <?php echo !empty($successMsg) ? $successMsg : $errorMsg; ?>
                            </div>
                        <?php endif; ?>
                        <form class="form-login" action="" method="POST">
                            <div class="row justify-content-center">
                                <div class="form-group col-sm-7 flex-column d-flex my-1">
                                    <label for="usernameAuth" class="form-control-label px-3 py-1"><?php echo LOGIN_FIELD_USERNAME ?><span class="text-danger">*</span></label>
                                    <input type="text" id="usernameAuth" name="username" placeholder="<?php echo LOGIN_TEXT_FIELD_USERNAME ?>" required>
                                </div>
                                <div class="form-group col-sm-7 flex-column d-flex my-1">
                                    <label for="passwordAuth" class="form-control-label px-3 py-1"><?php echo LOGIN_FIELD_PASSWORD ?><span class="text-danger">*</span></label>
                                    <input type="password" id="passwordAuth" name="password" placeholder="<?php echo LOGIN_TEXT_FIELD_PASSWORD ?>" required>
                                </div>
                                <div class="pt-3 pb-3 form-group col-sm-12">
                                    <button type="submit" class="btn btn-secondary" name="login"><?php echo LOGIN_TEXT_BUTTON ?></button>
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