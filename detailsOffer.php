<?php
    include('config/conf.php');
    Auth::requireEntity();

    // Idioma e textos
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }
    require_once ROOT . './Languages/' . $_SESSION['lang'] . '.php';

    $offerModel = new Offer();

    // O id vem do URL; só devolve a oferta se for desta entidade
    $id = (int) ($_GET['id'] ?? 0);
    $oferta = $offerModel->findByIdAndEntity($id, Auth::id());

    if ($oferta === null) {
        header('Location: dashboardEntity.php');
        exit();
    }

    $errorMsg = '';
    $successMsg = '';
    $abrirModal = false;

    // Valores do formulário de edição (RE-15: preenchidos com os valores atuais)
    $form = [
        'nome' => $oferta['nome'],
        'descricao' => $oferta['descricao'],
        'preco' => $oferta['preco']
    ];

    // Oferta editada com sucesso
    if (isset($_GET['success']) && $_GET['success'] === 'true') {
        $successMsg = DETAILS_MODAL_EDIT_OFFER_MSG_SUCCESS;
    }

    // RE-15: editar a oferta
    if (isset($_POST['editarOferta'])) {
        $form['nome'] = trim($_POST['nome'] ?? '');
        $form['descricao'] = trim($_POST['descricao'] ?? '');
        $form['preco'] = trim($_POST['preco'] ?? '');
        $preco = str_replace(',', '.', $form['preco']);
        $enviouFoto = !empty($_FILES['fotoOferta']['name']);

        if ($form['nome'] === '') {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_NAME;
        } elseif ($form['descricao'] === '') {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_DESCRIPTION;
        } elseif ($form['preco'] === '') {
            $errorMsg = ENTITY_DASH_ERROR_EMPTY_PRICE;
        } elseif (!is_numeric($preco) || (float) $preco < 0 || (float) $preco > 99999) {
            $errorMsg = ENTITY_DASH_ERROR_INVALID_PRICE;
        } else {
            $fotoNova = null;

            if ($enviouFoto) {
                $fotoNova = Upload::image($_FILES['fotoOferta'], 'offers');

                if ($fotoNova === null) {
                    $errorMsg = ENTITY_DASH_ERROR_INVALID_PHOTO;
                }
            }

            if ($errorMsg === '') {
                $fotoAntiga = $oferta['fotografia'];

                $ok = $offerModel->update($id, Auth::id(), [
                    'nome' => $form['nome'],
                    'descricao' => $form['descricao'],
                    'preco' => round((float) $preco, 2),
                    'fotografia' => $fotoNova   // null = mantém a atual
                ]);

                if ($ok) {
                    // Apaga a fotografia antiga, se foi substituída
                    if ($fotoNova !== null && !empty($fotoAntiga)) {
                        $ficheiro = ROOT . '/uploads/offers/' . basename($fotoAntiga);
                        if (is_file($ficheiro)) {
                            unlink($ficheiro);
                        }
                    }
                    header('Location: detailsOffer.php?id=' . $id . '&success=true');
                    exit();
                }
                $errorMsg = ENTITY_DASH_ERROR_INVALID_PHOTO;
            }
        }

        if ($errorMsg !== '') {
            $abrirModal = true;
        }
    }

    // Fotografia: só mostra se o ficheiro existir
    $fotoNome = basename((string) ($oferta['fotografia'] ?? ''));
    $temFoto = $fotoNome !== '' && is_file(ROOT . '/uploads/offers/' . $fotoNome);

    // Data (como no antigo: d-m-Y)
    $formatDate = '-';
    if (!empty($oferta['data'])) {
        $formatDate = date('d-m-Y', strtotime($oferta['data']));
    }

    // Disponível: só se estiver marcada como tal E for de hoje (ofertas de dias anteriores já não estão disponíveis)
    $disponivel = !empty($oferta['disponivel']) && $oferta['data'] >= date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Too Good To Go</title>
        <link rel="stylesheet" href="Styles/TooGoodToGo.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="https://play-lh.googleusercontent.com/Ht7OXfuYPvtSdFl7PnuX6KisTLgSceF9krOmxof7klTgqNR7UBVc53z63Vm3NuOQ0eo=w240-h480-rw" type="image/x-icon">
    </head>
    <body style="background-color: #b2d0d1">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 border-bottom" style="background-color: #056365;">
            <div class="col-md-2 text-end d-flex align-items-center justify-content-center">
                <img style="margin-left: 30px;" src="Images/Logo.svg" alt="logo">
            </div>
            <div class="col-md-auto text-end d-flex align-items-center">
                <h4 style="color: #ffff"><?php echo OFFERS_DETAILS_TITLE . " - '" . htmlspecialchars($oferta['nome']) . "'"; ?></h4>
            </div>
            <div class="col-md-2 text-end d-flex align-items-center justify-content-center">
                <a href="dashboardEntity.php" class="btn btn-light btn-menu" style="margin: 10px; background: none; border: none;">
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

            <!-- RE-14: detalhes da oferta -->
            <div class="row mx-1 d-flex justify-content-center align-items-center text-align-center">
                <div class="text-center">
                    <?php if ($temFoto) { ?>
                        <img class="m-4" src="uploads/offers/<?php echo htmlspecialchars($fotoNome); ?>" alt="Foto Oferta" height="200px">
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo OFFERS_DETAILS_NAME ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5 class="mb-0"><?php echo htmlspecialchars($oferta['nome']); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo OFFERS_DETAILS_DESCRIPTION ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo nl2br(htmlspecialchars((string) $oferta['descricao'])); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo OFFERS_DETAILS_PRICE ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo number_format((float) $oferta['preco'], 2, ',', ' '); ?> €</h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo OFFERS_DETAILS_CURRENT_DATE ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo htmlspecialchars($formatDate); ?></h5></div>
                    </div>
                    <div class="row my-1">
                        <div class="col-6 text-end"><h4><b><?php echo OFFERS_DETAILS_AVAILABLE ?>:</b></h4></div>
                        <div class="col-6 my-1"><h5><?php echo htmlspecialchars($disponivel ? DETAILS_AVAILABLE[0] : DETAILS_AVAILABLE[1]); ?></h5></div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-secondary my-3" data-bs-toggle="modal" data-bs-target="#modalEditOferta"><?php echo DASHBOARD_MODAL_EDIT_OFFER_TITLE ?></button>
                </div>

                <!-- RE-15: modal para editar a oferta -->
                <div class="modal fade" id="modalEditOferta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editOfferModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editOfferModalLabel"><?php echo DASHBOARD_MODAL_EDIT_OFFER_TITLE ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row justify-content-center text-align-center">
                                        <div class="form-group col-sm-11 flex-column d-flex">
                                            <label for="nome" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_NAME ?><span class="text-danger">*</span></label>
                                            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($form['nome']); ?>" maxlength="100" required>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="descricao" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_DESCRIPTION ?><span class="text-danger">*</span></label>
                                            <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars((string) $form['descricao']); ?></textarea>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex my-1">
                                            <label for="fotoOferta" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_FOTOGRAFIA ?></label>
                                            <input class="form-control" type="file" id="fotoOferta" name="fotoOferta" accept=".jpeg, .jpg, .png, .gif">
                                            <small class="form-text text-muted text-center"><?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_INFO_FOTOGRAFIA ?></small>
                                        </div>
                                        <div class="form-group col-sm-11 flex-column d-flex mb-3">
                                            <label for="preco" style="text-align: center;" class="form-control-label px-3 py-1"><?php echo DASHBOARD_ENTITY_MODAL_ADD_OFFER_PRECO ?><span class="text-danger">*</span></label>
                                            <input type="number" min="0" max="10000" step="0.01" id="preco" name="preco" value="<?php echo htmlspecialchars((string) $form['preco']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success" name="editarOferta"><?php echo DETAILS_MODAL_EDIT_OFFER_TEXT_BUTTON ?></button>
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
                new bootstrap.Modal(document.getElementById('modalEditOferta')).show();
            </script>
        <?php } ?>
    </body>
</html>