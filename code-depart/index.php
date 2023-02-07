<?php


// Inclusion des dépendances
require 'config.php';
require 'functions.php';

$errors = [];
$success = null;
$email = '';
$firstname = '';
$lastname = '';

// Si le formulaire a été soumis...
if (!empty($_POST)) {

    // On récupère les données
    $email = trim($_POST['email']);
    $firstname = trim($_POST['prenom']);
    $lastname = trim($_POST['nom']);

    // On récupère l'origine
    $origineSelectionnee = $_POST['origins'];

    // Validation 
    if (!$email) {
        $errors['email'] = "Merci d'indiquer une adresse mail";
    }

    if (!$prenom) {
        $errors['firstname'] = "Merci d'indiquer un prénom";
    }

    if (!$nom) {
        $errors['lastname'] = "Merci d'indiquer un nom";
    }

    // Si tout est OK (pas d'erreur)
    if (empty($errors)) {

        // Ajout de l'email dans le fichier csv
        addSubscriber($email, $firstname, $lastname, $originsSelectionnee);

        // Message de succès
        $success  = 'Merci de votre inscription';
    }
}

//////////////////////////////////////////////////////
// AFFICHAGE DU FORMULAIRE ///////////////////////////
//////////////////////////////////////////////////////

// Sélection de la liste des origines
$origines = getAllOrigins();

// Inclusion du template
include 'index.phtml';
