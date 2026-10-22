<?php
    //Português
    //Ficheiro "index.php"
    const LOGIN_TEXT = "INICIAR SESSÃO";

    const LOGIN_FIELD_USERNAME = "Nome de Utilizador ou Email";
    const LOGIN_FIELD_PASSWORD = "Palavra-passe";

    const LOGIN_TEXT_FIELD_USERNAME = "Insira o seu nome de utilizador ou email";
    const LOGIN_TEXT_FIELD_PASSWORD = "Insira a sua palavra-passe";

    const LOGIN_TEXT_BUTTON = "Iniciar Sessão";

    //Mensagens de Erro
    const LOGIN_MSG_ERROR_EMPTY_USERNAME = "O campo 'Nome de Utilizador' não pode estar vazio!";
    const LOGIN_MSG_ERROR_EMPTY_PASSWORD = "O campo 'Palavra-passe' não pode estar vazio!";
    const LOGIN_MSG_ERROR_BAD_USERNAME_EMAIL = "O 'Nome de Utilizador'/'Email' não existe!";
    const LOGIN_MSG_ERROR_BAD_PASSWORD = "A 'Palavra-passe' está incorreta!";
    const LOGIN_MSG_ERROR_ACCOUNT_INACTIVE = "A conta está inativa!";

    //Ficheiro "AddAdmin.php"
    const ADD_ADMIN_TEXT = "ADICIONAR ADMINISTRADOR";
    const ADD_ADMIN_TEXT_USERNAME = "Nome de Utilizador";
    const ADD_ADMIN_TEXT_NAME = "Nome Completo";
    const ADD_ADMIN_TEXT_PASSWORD = "Palavra-passe";
    const ADD_ADMIN_TEXT_PASSWORD_CONFIRM = "Confirmar Palavra-passe";

    const ADD_ADMIN_TEXT_FIELD_USERNAME = "Insira o seu nome de utilizador";
    const ADD_ADMIN_TEXT_FIELD_NAME = "Insira o seu nome completo";
    const ADD_ADMIN_TEXT_FIELD_PASSWORD = "Insira a sua palavra-passe";
    const ADD_ADMIN_TEXT_FIELD_PASSWORD_CONFIRM = "Confirme sua palavra-passe";

    define('ADD_ADMIN_MSG_ERROR_PASSWORD_SHORT', 'A password deve ter pelo menos 8 caracteres.');
    define('ADD_ADMIN_MSG_ERROR_CREATE', 'Não foi possível criar o administrador.');
    
    const ADD_ADMIN_TEXT_BUTTON = "Adicionar Admin";

    const ADD_ADMIN_MSG_SUCCESS = "Admin criado com sucesso!";
    
    // Mensagens de Erro
    const ADD_ADMIN_MSG_ERROR_EMPTY_USERNAME = "O campo 'Nome de Utilizador' não pode estar vazio!";
    const ADD_ADMIN_MSG_ERROR_EMPTY_NAME = "O campo 'Nome Completo' não pode estar vazio!";
    const ADD_ADMIN_MSG_ERROR_EMPTY_PASSWORD = "O campo 'Palavra-passe' não pode estar vazio!";
    const ADD_ADMIN_MSG_ERROR_EMPTY_PASSWORD_CONFIRM = "O campo de 'Confirmação Palavra-passe' não pode estar vazio!";
    const ADD_ADMIN_MSG_ERROR_PASSWORD_MISMATCH = "As palavras-passe não coincidem!";

    //Ficheiro "dashboard.php"
    const DASHBOARD_SALUTATION = "Olá, ";
    const ACCOUNT_LOGOUT_CONFIRM = "Tem a certeza que deseja sair?";

    //Modal "Alterar Palavra-passe"
    const DASHBOARD_MODAL_TITLE = "Alterar Palavra-passe";
    const DASHBOARD_MODAL_OLD_PASSWORD = "Palavra-passe Antiga";
    const DASHBOARD_MODAL_NEW_PASSWORD = "Palavra-passe Nova";

    define('PASSWORD_MSG_ERROR_SHORT', 'A password deve ter pelo menos 8 caracteres.');
    define('DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_INVALID', 'O email não é válido.');
    define('DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_LOGO_INVALID', 'O logotipo é inválido (use JPG, PNG ou GIF até 2 MB).');

    const DASHBOARD_TEXT_FIELD_OLD_PASSWORD = "Insira a sua palavra-passe antiga";
    const DASHBOARD_TEXT_FIELD_NEW_PASSWORD = "Insira a sua palavra-passe nova";

    const DASHBOARD_TEXT_BUTTON = "Alterar Palavra-passe";

    const DASHBOARD_PASSWORD_MSG_SUCCESS = "Palavra-passe alterada com sucesso!";

    //Mensagens de Erro
    const DASHBOARD_PASSWORD_MSG_ERROR_EMPTY_OLD_PASSWORD = "O campo 'Palavra-passe Antiga' não pode estar vazio!";
    const DASHBOARD_PASSWORD_MSG_ERROR_EMPTY_NEW_PASSWORD = "O campo 'Palavra-passe Nova' não pode estar vazio!";
    const DASHBOARD_PASSWORD_MSG_ERROR_BAD_PASSWORD = "A palavra-passe antiga está incorreta!";
    const DASHBOARD_PASSWORD_MSG_ERROR_SAME_PASSWORD = "A palavra-passe nova não pode ser igual à antiga!";

    //Modal "Adicionar Entidade"
    const DASHBOARD_MODAL_ADD_ENTITY_TITLE = "Adicionar Entidade";

    const DASHBOARD_MODAL_ADD_ENTITY_NAME = "Nome";
    const DASHBOARD_MODAL_ADD_ENTITY_DESCRIPTION = "Descrição";
    const DASHBOARD_MODAL_ADD_ENTITY_LOGOTIPO = "Logotipo";
    const DASHBOARD_MODAL_ADD_ENTITY_ADDRESS = "Morada";
    const DASHBOARD_MODAL_ADD_ENTITY_PHONE = "Número de telefone";
    const DASHBOARD_MODAL_ADD_ENTITY_EMAIL = "Email";
    const DASHBOARD_MODAL_ADD_ENTITY_PASSWORD = "Palavra-passe";

    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_NAME = "Insira o nome";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_DESCRIPTION = "Insira a descrição";
    const DASHBOARD_MODAL_ADD_ENTITY_INFO_LOGOTIPO = "Escolha uma imagem no formato JPEG, JPG, PNG, ou GIF.";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_ADDRESS = "Insira a morada";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_PHONE = "Insira o número de telefone";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_EMAIL = "Insira o email";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_PASSWORD = "Insira a palavra-passe";

    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_BUTTON = "Adicionar Entidade";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_SUCCESS = "Entidade criada com sucesso!";

    //Mensagens de Erro
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_NAME = "O campo 'Nome' da Entidade não pode estar vazio!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_DESCRIPTION = "O campo 'Descrição' da Entidade não pode estar vazio!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_ADDRESS = "O campo 'Morada' da Entidade não pode estar vazio!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PHONE = "O campo 'Número de telefone' da Entidade não pode estar vazio!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_EMAIL = "O campo 'Email' da Entidade não pode estar vazio!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PASSWORD = "O campo 'Palavra-passe' da Entidade não pode estar vazio!";    
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_ALREADY_EXISTS = "Já existe uma Entidade com esse email!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_UPLOAD = "Erro ao fazer upload do logotipo!";

    //Lista de Entidades
    const DASHBOARD_ENTITIES_LIST_TITLE = "Lista de Entidades";
    const ENTITIES_MSG_INFORM_EMPTY_LIST = "Não existem entidades registadas!";

    //Atributos de Entidades
    const DASHBOARD_ENTITIES_ATTRIBUTES_NAME = "Nome";
    const DASHBOARD_ENTITIES_ATTRIBUTES_DESCRIPTION = "Descrição";
    const DASHBOARD_ENTITIES_ATTRIBUTES_ADDRESS = "Morada";
    const DASHBOARD_ENTITIES_ATTRIBUTES_PHONE = "Número de telefone";
    const DASHBOARD_ENTITIES_ATTRIBUTES_EMAIL = "Email";
    const DASHBOARD_ENTITIES_ATTRIBUTES_ACCOUNT_STATUS = "Estado da Conta";
    const ACCOUNT_STATUS = array(
        "Ativa",
        "Inativa"
    );
    const ACCOUNT_STATUS_CONFIRM = array(
        "Tem certeza de que deseja ativar esta conta?",
        "Tem certeza de que deseja desativar esta conta?"
    );
    const DASHBOARD_ENTITIES_ATTRIBUTES_INFO = "Mais info";
    const DASHBOARD_ENTITIES_ATTRIBUTES_DETAILS = "Detalhes";

    //Página dos Detalhes de uma Entidade
    const ENTITIES_DETAILS_TITLE = "Detalhes da Entidade";
    const ENTITIES_DETAILS_NAME = "Nome";
    const ENTITIES_DETAILS_DESCRIPTION = "Descrição";
    const ENTITIES_DETAILS_LOGOTIPO = "Logotipo";
    const ENTITIES_DETAILS_ADDRESS = "Morada";
    const ENTITIES_DETAILS_PHONE = "Número de telefone";
    const ENTITIES_DETAILS_EMAIL = "Email";
    const ENTITIES_DETAILS_PASSWORD = "Palavra-passe";
    const ENTITIES_DETAILS_ACCOUNT_STATUS = "Estado da Conta";
    
    const DASHBOARD_MODAL_EDIT_ENTITY_TITLE = "Editar Entidade";

    

    //Modal "Editar Entidade"
    const DETAILS_MODAL_EDIT_ENTITY_NAME = "Nome da Entidade";
    const DETAILS_MODAL_EDIT_ENTITY_DESCRIPTION = "Descrição da Entidade";
    const DETAILS_MODAL_EDIT_ENTITY_LOGOTIPO = "Logotipo da Entidade";
    const DETAILS_MODAL_EDIT_ENTITY_ADDRESS = "Morada da Entidade";
    const DETAILS_MODAL_EDIT_ENTITY_PHONE = "Contacto da Entidade";
    const DETAILS_MODAL_EDIT_ENTITY_EMAIL = "Email da Entidade";
    const DETAILS_MODAL_EDIT_ENTITY_PASSWORD = "Palavra-passe da Entidade";

    const DETAILS_MODAL_EDIT_ENTITY_TEXT_BUTTON = "Guardar Alterações";
    const DETAILS_MODAL_EDIT_ENTITY_MSG_SUCCESS = "Entidade editada com sucesso!";

    //Ficheiro "dashboardEntity.php"
    define('ENTITY_DASH_EMPTY_LIST', 'Ainda não tem ofertas para hoje');
    define('ENTITY_DASH_LIST_TITLE', 'As suas ofertas de hoje');
    define('ENTITY_DASH_COL_NAME', 'Oferta');
    define('ENTITY_DASH_COL_ACTIONS', 'Ações');
    define('ENTITY_DASH_BTN_DETAILS', 'Ver detalhes');
    define('ENTITY_DASH_BTN_EDIT', 'Editar');
    define('ENTITY_DASH_BTN_DELETE', 'Remover');
    define('ENTITY_DASH_CONFIRM_DELETE', 'Tem a certeza que quer remover esta oferta?');
    define('ENTITY_DASH_ADD_TITLE', 'Adicionar oferta');
    define('ENTITY_DASH_ADD_BUTTON', 'Adicionar');
    define('ENTITY_DASH_FIELD_NAME', 'Nome');
    define('ENTITY_DASH_FIELD_DESCRIPTION', 'Descrição');
    define('ENTITY_DASH_FIELD_PHOTO', 'Fotografia');
    define('ENTITY_DASH_FIELD_PRICE', 'Preço (€)');
    define('ENTITY_DASH_PHOTO_INFO', 'JPG, PNG ou GIF, até 2 MB');
    define('ENTITY_DASH_MSG_ADDED', 'Oferta adicionada com sucesso.');
    define('ENTITY_DASH_MSG_DELETED', 'Oferta removida com sucesso.');
    define('ENTITY_DASH_MSG_EDITED', 'Oferta atualizada com sucesso.');
    define('ENTITY_DASH_ERROR_EMPTY_NAME', 'Indique o nome da oferta.');
    define('ENTITY_DASH_ERROR_EMPTY_DESCRIPTION', 'Indique a descrição da oferta.');
    define('ENTITY_DASH_ERROR_EMPTY_PRICE', 'Indique o preço.');
    define('ENTITY_DASH_ERROR_INVALID_PRICE', 'O preço não é válido.');
    define('ENTITY_DASH_ERROR_EMPTY_PHOTO', 'Selecione uma fotografia.');
    define('ENTITY_DASH_ERROR_INVALID_PHOTO', 'Fotografia inválida (use JPG, PNG ou GIF até 2 MB).');

    const DASHBOARD_ENTITY_SALUTATION = "Bem Vindo, ";

    //Lista de Ofertas 
    const DASHBOARD_ENTITY_OFFERS_LIST_TITLE = "Lista de Ofertas";
    const DASHBOARD_ENTITY_MSG_INFORM_EMPTY_LIST = "Não existem ofertas registadas!";

    //Atributos de Ofertas
    const DASHBOARD_ENTITY_OFFERS_ATTRIBUTES_NAME = "Nome";
    
    const DASHBOARD_ENTITY_ADD_OFFER_TEXT_BUTTON = "Adicionar Oferta";

    //Modal "Adicionar Oferta"
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TITLE = "Adicionar Oferta";

    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_NAME = "Nome";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_DESCRIPTION = "Descrição";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_FOTOGRAFIA = "Fotografia";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_PRECO = "Preço";

    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_NAME = "Insira o nome";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_DESCRIPTION = "Insira a descrição";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_INFO_FOTOGRAFIA = "Escolha uma imagem no formato JPEG, JPG, PNG, ou GIF.";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_PRECO = "Insira o preço";

    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_SUCCESS = "Oferta criada com sucesso!";

    //Mensagens de Erro
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_NAME = "O campo Nome da Oferta não pode estar vazio!";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_DESCRIPTION = "O campo Descrição da Oferta não pode estar vazio!";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_FOTO = "Não foi selecionada nenhuma fotografia!";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_PRECO = "O campo Preço da Oferta não pode estar vazio!";

    const DASHBOARD_ENTITY_REMOVE_OFFER_CONFIRM = "Tem a certeza que deseja remover esta oferta?";

    //Página dos Detalhes de uma Oferta
    const OFFERS_DETAILS_TITLE = "Detalhes da Oferta";
    const OFFERS_DETAILS_NAME = "Nome";
    const OFFERS_DETAILS_DESCRIPTION = "Descrição";
    const OFFERS_DETAILS_FOTO = "Foto";
    const OFFERS_DETAILS_PRICE = "Preço";
    const OFFERS_DETAILS_CURRENT_DATE = "Data de registo";
    const OFFERS_DETAILS_AVAILABLE = "Disponível";
    const DETAILS_AVAILABLE = array(
        "Sim",
        "Não"
    );

    define('DETAILS_OFFER_NAME', 'Nome');
    define('DETAILS_OFFER_DESCRIPTION', 'Descrição');
    define('DETAILS_OFFER_PRICE', 'Preço');
    define('DETAILS_OFFER_DATE', 'Data');
    define('DETAILS_OFFER_STATUS', 'Estado');
    define('DETAILS_OFFER_AVAILABLE', 'Disponível');
    define('DETAILS_OFFER_UNAVAILABLE', 'Indisponível');
    define('DETAILS_OFFER_BACK', 'Voltar');
    define('DETAILS_OFFER_EDIT', 'Editar');

    const DASHBOARD_MODAL_EDIT_OFFER_TITLE = "Editar Oferta";
    const DETAILS_MODAL_EDIT_OFFER_TEXT_BUTTON = "Guardar Alterações";
    const DETAILS_MODAL_EDIT_OFFER_MSG_SUCCESS = "Oferta editada com sucesso!";
?>