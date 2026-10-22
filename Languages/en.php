<?php
    //English
    //Ficheiro "index.php"
    const LOGIN_TEXT = "LOGIN";

    const LOGIN_FIELD_USERNAME = "Username or Email";
    const LOGIN_FIELD_PASSWORD = "Password";

    const LOGIN_TEXT_FIELD_USERNAME = "Insert your username or email";
    const LOGIN_TEXT_FIELD_PASSWORD = "Insert your password";

    const LOGIN_TEXT_BUTTON = "Login";

    //Mensagens de Erro
    const LOGIN_MSG_ERROR_EMPTY_USERNAME = "Username field cannot be empty!";
    const LOGIN_MSG_ERROR_EMPTY_PASSWORD = "Password field cannot be empty!";
    const LOGIN_MSG_ERROR_BAD_USERNAME_EMAIL = "Username/Email doesn´t exist!";
    const LOGIN_MSG_ERROR_BAD_PASSWORD = "Password is incorrect!";
    const LOGIN_MSG_ERROR_ACCOUNT_INACTIVE = "Account is inactive!";

    //Ficheiro "AddAdmin.php"
    const ADD_ADMIN_TEXT = "ADD ADMINISTRATOR";
    const ADD_ADMIN_TEXT_USERNAME = "Username";
    const ADD_ADMIN_TEXT_NAME = "Name";
    const ADD_ADMIN_TEXT_PASSWORD = "Password";
    const ADD_ADMIN_TEXT_PASSWORD_CONFIRM = "Confirm Password";

    const ADD_ADMIN_TEXT_FIELD_USERNAME = "Insert your username";
    const ADD_ADMIN_TEXT_FIELD_NAME = "Insert your name";
    const ADD_ADMIN_TEXT_FIELD_PASSWORD = "Insert your password";
    const ADD_ADMIN_TEXT_FIELD_PASSWORD_CONFIRM = "Confirm your password";

    define('ADD_ADMIN_MSG_ERROR_PASSWORD_SHORT', 'The password must have at least 8 characters.');
    define('ADD_ADMIN_MSG_ERROR_CREATE', 'Could not create the administrator.');

    const ADD_ADMIN_TEXT_BUTTON = "Add Admin";

    const ADD_ADMIN_MSG_SUCCESS = "Admin created successfully!";
    
    //Mensagens de Erro
    const ADD_ADMIN_MSG_ERROR_EMPTY_USERNAME = "Username field cannot be empty!";
    const ADD_ADMIN_MSG_ERROR_EMPTY_NAME = "Name field cannot be empty!";
    const ADD_ADMIN_MSG_ERROR_EMPTY_PASSWORD = "Password field cannot be empty!";
    const ADD_ADMIN_MSG_ERROR_EMPTY_PASSWORD_CONFIRM = "Confirm Password field cannot be empty!";
    const ADD_ADMIN_MSG_ERROR_PASSWORD_MISMATCH = "Passwords don´t match!";

    //Ficheiro "dashboard.php"
    const DASHBOARD_SALUTATION = "Hello, ";
    const ACCOUNT_LOGOUT_CONFIRM = "Are you sure you want to logout?";

    //Modal "Alterar Palavra-passe"
    const DASHBOARD_MODAL_TITLE = "Change Password";
    const DASHBOARD_MODAL_OLD_PASSWORD = "Old Password";
    const DASHBOARD_MODAL_NEW_PASSWORD = "New Password";

    define('PASSWORD_MSG_ERROR_SHORT', 'The password must have at least 8 characters.');
    define('DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_INVALID', 'The email is not valid.');
    define('DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_LOGO_INVALID', 'Invalid logo (use JPG, PNG or GIF up to 2 MB).');

    const DASHBOARD_TEXT_FIELD_OLD_PASSWORD = "Insert your old password";
    const DASHBOARD_TEXT_FIELD_NEW_PASSWORD = "Insert your new password";

    const DASHBOARD_TEXT_BUTTON = "Change Password";

    const DASHBOARD_PASSWORD_MSG_SUCCESS = "Password changed successfully!";

    //Mensagens de Erro
    const DASHBOARD_PASSWORD_MSG_ERROR_EMPTY_OLD_PASSWORD = "Old Password field cannot be empty!";
    const DASHBOARD_PASSWORD_MSG_ERROR_EMPTY_NEW_PASSWORD = "New Password field cannot be empty!";
    const DASHBOARD_PASSWORD_MSG_ERROR_BAD_PASSWORD = "Old Password is incorrect!";
    const DASHBOARD_PASSWORD_MSG_ERROR_SAME_PASSWORD = "New Password cannot be the same as the old one!";

    //Modal "Adicionar Entidade"
    const DASHBOARD_MODAL_ADD_ENTITY_TITLE = "Add Entity";

    const DASHBOARD_MODAL_ADD_ENTITY_NAME = "Name";
    const DASHBOARD_MODAL_ADD_ENTITY_DESCRIPTION = "Description";
    const DASHBOARD_MODAL_ADD_ENTITY_LOGOTIPO = "Logotipo";
    const DASHBOARD_MODAL_ADD_ENTITY_ADDRESS = "Address";
    const DASHBOARD_MODAL_ADD_ENTITY_PHONE = "Phone";
    const DASHBOARD_MODAL_ADD_ENTITY_EMAIL = "Email";
    const DASHBOARD_MODAL_ADD_ENTITY_PASSWORD = "Password";

    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_NAME = "Insert the name";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_DESCRIPTION = "Insert the description";
    const DASHBOARD_MODAL_ADD_ENTITY_INFO_LOGOTIPO = "Choose an image in JPEG, JPG, PNG, or GIF format.";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_ADDRESS = "Insert the address";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_PHONE = "Insert the phone number";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_EMAIL = "Insert the email";
    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_FIELD_PASSWORD = "Insert the password";

    const DASHBOARD_MODAL_ADD_ENTITY_TEXT_BUTTON = "Add Entity";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_SUCCESS = "Entity created successfully!";

    //Mensagens de Erro
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_NAME = "Name field cannot be empty!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_DESCRIPTION = "Description field cannot be empty!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_ADDRESS = "Address field cannot be empty!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PHONE = "Phone field cannot be empty!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_EMAIL = "Email field cannot be empty!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMPTY_PASSWORD = "Password field cannot be empty!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_EMAIL_ALREADY_EXISTS = "There is already an entity with that email!";
    const DASHBOARD_MODAL_ADD_ENTITY_MSG_ERROR_UPLOAD = "Error uploading the image!";

    //Lista de Entidades
    const DASHBOARD_ENTITIES_LIST_TITLE = "Entities List";
    const ENTITIES_MSG_INFORM_EMPTY_LIST = "There are no entities to show!";

    //Atributos de Entidades
    const DASHBOARD_ENTITIES_ATTRIBUTES_NAME = "Name";
    const DASHBOARD_ENTITIES_ATTRIBUTES_DESCRIPTION = "Description";
    const DASHBOARD_ENTITIES_ATTRIBUTES_ADDRESS = "Address";
    const DASHBOARD_ENTITIES_ATTRIBUTES_PHONE = "Phone";
    const DASHBOARD_ENTITIES_ATTRIBUTES_EMAIL = "Email";
    const DASHBOARD_ENTITIES_ATTRIBUTES_ACCOUNT_STATUS = "Account Status";
    const ACCOUNT_STATUS = array(
        "Active",
        "Inactive"
    );
    const ACCOUNT_STATUS_CONFIRM = array(
        "Are you sure you want to activate this account?",
        "Are you sure you want to deactivate this account?"
    );
    const DASHBOARD_ENTITIES_ATTRIBUTES_INFO = "More Info";
    const DASHBOARD_ENTITIES_ATTRIBUTES_DETAILS = "Details";

    //Página dos Detalhes de uma Entidade
    const ENTITIES_DETAILS_TITLE = "Entity Details";
    const ENTITIES_DETAILS_NAME = "Name";
    const ENTITIES_DETAILS_DESCRIPTION = "Description";
    const ENTITIES_DETAILS_LOGOTIPO = "Logotipo";
    const ENTITIES_DETAILS_ADDRESS = "Address";
    const ENTITIES_DETAILS_PHONE = "Phone Number";
    const ENTITIES_DETAILS_EMAIL = "Email";
    const ENTITIES_DETAILS_PASSWORD = "Password";
    const ENTITIES_DETAILS_ACCOUNT_STATUS = "Account Status";
    
    const DASHBOARD_MODAL_EDIT_ENTITY_TITLE = "Edit Entity";

    
    
    //Modal "Editar Entidade"
    const DETAILS_MODAL_EDIT_ENTITY_NAME = "Entity Name";
    const DETAILS_MODAL_EDIT_ENTITY_DESCRIPTION = "Entity Description";
    const DETAILS_MODAL_EDIT_ENTITY_LOGOTIPO = "Entity Logotipo";
    const DETAILS_MODAL_EDIT_ENTITY_ADDRESS = "Entity Address";
    const DETAILS_MODAL_EDIT_ENTITY_PHONE = "Entity Phone";
    const DETAILS_MODAL_EDIT_ENTITY_EMAIL = "Entity Email";
    const DETAILS_MODAL_EDIT_ENTITY_PASSWORD = "Entity Password";

    const DETAILS_MODAL_EDIT_ENTITY_TEXT_BUTTON = "Save Changes";
    const DETAILS_MODAL_EDIT_ENTITY_MSG_SUCCESS = "Entity edited successfully!";

    //Ficheiro "dashboardEntity.php"
    define('ENTITY_DASH_EMPTY_LIST', 'You have no offers for today yet');
    define('ENTITY_DASH_LIST_TITLE', 'Your offers for today');
    define('ENTITY_DASH_COL_NAME', 'Offer');
    define('ENTITY_DASH_COL_ACTIONS', 'Actions');
    define('ENTITY_DASH_BTN_DETAILS', 'View details');
    define('ENTITY_DASH_BTN_EDIT', 'Edit');
    define('ENTITY_DASH_BTN_DELETE', 'Remove');
    define('ENTITY_DASH_CONFIRM_DELETE', 'Are you sure you want to remove this offer?');
    define('ENTITY_DASH_ADD_TITLE', 'Add offer');
    define('ENTITY_DASH_ADD_BUTTON', 'Add');
    define('ENTITY_DASH_FIELD_NAME', 'Name');
    define('ENTITY_DASH_FIELD_DESCRIPTION', 'Description');
    define('ENTITY_DASH_FIELD_PHOTO', 'Photo');
    define('ENTITY_DASH_FIELD_PRICE', 'Price (€)');
    define('ENTITY_DASH_PHOTO_INFO', 'JPG, PNG or GIF, up to 2 MB');
    define('ENTITY_DASH_MSG_ADDED', 'Offer added successfully.');
    define('ENTITY_DASH_MSG_DELETED', 'Offer removed successfully.');
    define('ENTITY_DASH_MSG_EDITED', 'Offer updated successfully.');
    define('ENTITY_DASH_ERROR_EMPTY_NAME', 'Enter the offer name.');
    define('ENTITY_DASH_ERROR_EMPTY_DESCRIPTION', 'Enter the offer description.');
    define('ENTITY_DASH_ERROR_EMPTY_PRICE', 'Enter the price.');
    define('ENTITY_DASH_ERROR_INVALID_PRICE', 'The price is not valid.');
    define('ENTITY_DASH_ERROR_EMPTY_PHOTO', 'Select a photo.');
    define('ENTITY_DASH_ERROR_INVALID_PHOTO', 'Invalid photo (use JPG, PNG or GIF up to 2 MB).');
    const DASHBOARD_ENTITY_SALUTATION = "Welcome, ";

    //Lista de Ofertas 
    const DASHBOARD_ENTITY_OFFERS_LIST_TITLE = "Offers List";
    const DASHBOARD_ENTITY_MSG_INFORM_EMPTY_LIST = "There are no offers to show!";

    //Atributos de Ofertas
    const DASHBOARD_ENTITY_OFFERS_ATTRIBUTES_NAME = "Name";

    const DASHBOARD_ENTITY_ADD_OFFER_TEXT_BUTTON = "Add Offer";

    //Modal "Adicionar Oferta"
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TITLE = "Add Offer";

    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_NAME = "Name";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_DESCRIPTION = "Description";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_FOTOGRAFIA = "Photography";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_PRECO = "Price";

    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_NAME = "Insert the name";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_DESCRIPTION = "Insert the description";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_INFO_FOTOGRAFIA = "Choose an image in JPEG, JPG, PNG, or GIF format.";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_TEXT_FIELD_PRECO = "Insert the price";

    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_SUCCESS = "Offer created successfully!";

    //Mensagens de Erro
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_NAME = "Name field cannot be empty!";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_DESCRIPTION = "Description field cannot be empty!";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_FOTO = "No photos were selected!";
    const DASHBOARD_ENTITY_MODAL_ADD_OFFER_MSG_ERROR_EMPTY_PRECO = "Price field cannot be empty!";
  
    const DASHBOARD_ENTITY_REMOVE_OFFER_CONFIRM = "Are you sure you want to remove this offer?";

    //Ficheiro "detailsOffer.php"
    const OFFERS_DETAILS_TITLE = "Offer Details";
    const OFFERS_DETAILS_NAME = "Name";
    const OFFERS_DETAILS_DESCRIPTION = "Description";
    const OFFERS_DETAILS_FOTO = "Foto";
    const OFFERS_DETAILS_PRICE = "Price";
    const OFFERS_DETAILS_CURRENT_DATE = "Registration Date";
    const OFFERS_DETAILS_AVAILABLE = "Available";
    const DETAILS_AVAILABLE = array(
        "Yes",
        "No"
    );

    define('DETAILS_OFFER_NAME', 'Name');
    define('DETAILS_OFFER_DESCRIPTION', 'Description');
    define('DETAILS_OFFER_PRICE', 'Price');
    define('DETAILS_OFFER_DATE', 'Date');
    define('DETAILS_OFFER_STATUS', 'Status');
    define('DETAILS_OFFER_AVAILABLE', 'Available');
    define('DETAILS_OFFER_UNAVAILABLE', 'Unavailable');
    define('DETAILS_OFFER_BACK', 'Back');
    define('DETAILS_OFFER_EDIT', 'Edit');
    
    const DASHBOARD_MODAL_EDIT_OFFER_TITLE = "Edit Entity";
    const DETAILS_MODAL_EDIT_OFFER_TEXT_BUTTON = "Save Changes";
    const DETAILS_MODAL_EDIT_OFFER_MSG_SUCCESS = "Offer edited successfully!";
?>