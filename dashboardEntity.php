<?php
    include('config/conf.php');
    Auth::requireEntity();

    // Idioma e textos
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }
    require_once ROOT . './Languages/' . $_SESSION['lang'] . '.php';

    $entityModel = new Entity();
    $offerModel = new Offer();

    $entidade = $entityModel->findById(Auth::id());
    $entityName = $entidade['nome'];   // requireEntity() já garantiu que existe

    $errorMsg = '';
    $successMsg = '';
    $abrirModal = '';
    $novo = ['nome' => '', 'descricao' => '', 'preco' => ''];

    if (isset($_GET['success'])) {
        if ($_GET['success'] === 'added') {
            $successMsg = ENTITY_DASH_MSG_ADDED;
        } elseif ($_GET['success'] === 'deleted') {
            $successMsg = ENTITY_DASH_MSG_DELETED;
        } elseif ($_GET['success'] === 'edited') {
            $successMsg = ENTITY_DASH_MSG_EDITED;
        }
    }

    // RE-16: remover oferta (por POST; o id da entidade vem da sessão)
    if (isset($_POST['removerOferta'])) {
        $offerModel->delete((int) $_POST['removerOferta'], Auth::id());
        header('Location: dashboardEntity.php?success=deleted');
        exit();
    }

    // RE-13: adicionar oferta
    if (isset($_POST['adicionaOferta'])) {
        $novo['nome'] = trim($_POST['nome'] ?? '');
        $novo['descricao'] = trim($_POST['descricao'] ?? '');
        $novo['preco'] = trim($_POST['preco'] ?? '');
        $preco = str_replace(',', '.', $novo['preco']);

        if ($novo['nome'] === '') {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_NAME;
        } elseif ($novo['descricao'] === '') {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_DESCRIPTION;
        } elseif ($novo['preco'] === '') {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_PRICE;
        } elseif (!is_numeric($preco) || (float) $preco < 0 || (float) $preco > 99999) {
            $errorMsg = ENTITY_DASH_ERROR_INVALID_PRICE;
        } elseif (empty($_FILES['fotografia']['name'])) {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_PHOTO;
        } else {
            $fotografia = Upload::image($_FILES['fotografia'], 'offers');

            if ($fotografia === null) {
                $errorMsg = ENTITY_DASH_ERROR_INVALID_PHOTO;
            } else {
                $offerModel->create(Auth::id(), [
                    'nome' => $novo['nome'],
                    'descricao' => $novo['descricao'],
                    'fotografia' => $fotografia,
                    'preco' => round((float) $preco, 2)
                ]);
                header('Location: dashboardEntity.php?success=added');
                exit();
            }
        }

        if ($errorMsg !== '') {
            $abrirModal = 'modalAddOferta';
        }
    }

    // RE-12: ofertas de hoje
    $ofertas = $offerModel->todayByEntity(Auth::id());
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
    <body style="background-color: #b2d0d1">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 mb-4 border-bottom" style="background-color: #056365;">
            <div class="col-md-2 text-end d-flex align-items-center justify-content-center">
                <img style="margin-left: 30px;" src="Images/Logo.svg" alt="logo">
            </div>
            <div class="col-md-auto text-end d-flex align-items-center">
                <h4 style="color: #ffff"><?php echo DASHBOARD_SALUTATION . htmlspecialchars($entityName) . "!"; ?></h4>
            </div>
            <div class="col-md-2 text-end d-flex align-items-center">
                <!-- RE-17: logout -->
                <form action="logout.php" method="POST" class="ms-2" onsubmit="return confirm('<?php echo ACCOUNT_LOGOUT_CONFIRM ?>');">
                    <button type="submit" class="btn btn-light btn-menu" style="margin: 10px; background: none; border: none; cursor: pointer;">
                        <img src="Images/icon_logout.png" alt="Logout" style="width: 25px; height: 25px; filter: brightness(0) invert(1);">
                    </button>
                </form>
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

            <?php if (empty($ofertas)) { ?>
                <h2 class="text-center mb-5"><?php echo ENTITY_DASH_EMPTY_LIST; ?></h2>
            <?php } else { ?>
                <h3 class="text-center mb-5"><?php echo ENTITY_DASH_LIST_TITLE; ?></h3>

                <div class="container d-flex justify-content-center align-items-center">
                    <table class="table table-hover">
                        <thead class="table-info text-center align-middle">
                            <tr>
                                <th scope="col"><h5 class="m-0"><b><?php echo ENTITY_DASH_COL_NAME; ?></b></h5></th>
                                <th scope="col"><h5 class="m-0"><b><?php echo ENTITY_DASH_COL_ACTIONS; ?></b></h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ofertas as $oferta) { ?>
                                <tr class="text-center align-middle">
                                    <td><?php echo htmlspecialchars($oferta['nome']); ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- RE-14: detalhes -->
                                            <a href="detailsOffer.php?id=<?php echo (int) $oferta['id']; ?>" class="btn btn-secondary py-1 px-2"><?php echo ENTITY_DASH_BTN_DETAILS ?></a>
                                            <!-- RE-16: remover -->
                                            <form action="" method="POST" onsubmit="return confirm('<?php echo ENTITY_DASH_CONFIRM_DELETE ?>');">
                                                <button type="submit" class="btn btn-danger py-1 px-2" name="removerOferta" value="<?php echo (int) $oferta['id']; ?>"><?php echo ENTITY_DASH_BTN_DELETE ?></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

            <div class="text-center">
                <button type="button" class="btn btn-secondary my-5" data-bs-toggle="modal" data-bs-target="#modalAddOferta"><?php echo ENTITY_DASH_ADD_TITLE ?></button>
            </div>

            <!-- Modal para adicionar uma oferta -->
            <div class="modal fade" id="modalAddOferta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="titleAddOferta" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titleAddOferta"><?php echo ENTITY_DASH_ADD_TITLE ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row justify-content-center text-align-center">
                                    <div class="form-group col-sm-11 flex-column d-flex">
                                        <label for="nome" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo ENTITY_DASH_FIELD_NAME ?><span class="text-danger">*</span></label>
                                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($novo['nome']); ?>" placeholder="<?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_NAME?>" maxlength="100" required>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="descricao" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo ENTITY_DASH_FIELD_DESCRIPTION ?><span class="text-danger">*</span></label>
                                        <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($novo['descricao']); ?>" placeholder="<?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_DESCRIPTION?>" maxlength="100" required>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex my-1">
                                        <label for="fotografia" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo ENTITY_DASH_FIELD_PHOTO ?><span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="fotografia" name="fotografia" accept=".jpeg, .jpg, .png, .gif" required>
                                        <small class="form-text text-muted text-center"><?php echo ENTITY_DASH_PHOTO_INFO ?></small>
                                    </div>
                                    <div class="form-group col-sm-11 flex-column d-flex mb-3">
                                        <label for="preco" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo ENTITY_DASH_FIELD_PRICE ?><span class="text-danger">*</span></label>
                                        <input type="number" id="preco" name="preco" value="<?php echo htmlspecialchars($novo['preco']); ?>" min="0" step="0.01" placeholder="<?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_PRECO?>" required>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success" name="adicionaOferta"><?php echo ENTITY_DASH_ADD_BUTTON ?></button>
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