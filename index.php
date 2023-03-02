
<?php
session_start();

// Inclusion des dépendances
require 'config.php';
require 'functions.php';

// Déclaration des variables
$errors = [];
$success = null;
$email = '';
$firstname = '';
$lastname = '';
$origin = '';
$interest = '';

// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $origin = $_POST['origin'];

    if (isset($_POST['interest'])) {
        $interest = $_POST['interest'];
    }

    // Validation 

    // Vérifie si l'email est déjà présent dans la BDD
    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = " L'adresse email n'est pas valide ";
    } elseif (emailExist($email) == true) {
        $errors['email'] = " Cet adresse email existe déjà";
    }
    // Messages d'erreurs si les champs de sont pas remplis
    if (!$firstname) {
        $errors['firstname'] = "Merci d'indiquer un prénom";
    }
    if (!$lastname) {
        $errors['lastname'] = "Merci d'indiquer un nom";
    }
    if (!$origin) {
        $errors['origin'] = "Merci de choisir un champ";
    }
    if (!$interest) {
        $errors['interest'] = "Merci de cocher au moins un centre d'interêt";
    }
    
    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        $subId = addSubscriber($email, $firstname, $lastname, $origin);

        foreach ($interest as $i) {
            addInterestSubscriber($subId, $i);
        }
        
        // Message de succès
        $success  = 'Merci de votre inscription';
        $_SESSION['message'] = $success;
        
        // Le formulaire a été soumis
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
     }
   
}
//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////


// Si le formulaire est correctement remplis success message
if (isset ($_SESSION['message'])) {
 $success = $_SESSION['message'];
 $_SESSION['message'] = null; 
}

// Sélection de la liste des origines
$origines = getAllOrigins();
$interests = getAllInterests();

// Inclusion du template
include 'index.phtml';