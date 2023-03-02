<?php

require 'functions.php';

/**
 * Ce script importe dans la base de données "eshop" des données de produits 
 * dans une table "product". Cette table en plus de l'id contient 2 champs :
 *   - le nom du produit (champ "name")
 *   - le prix du produit (champ "price") stocké en centimes donc sous la forme d'un nombre entier
 * 
 * On souhaite importer les données d'un fichier CSV contenant des produits.  
 * Attention les prix sont sous le forme de chaînes de caractères avec une parfois une virgule,
 * parfois un point pour séparer les centimes. On va donc faire un traitement pour transformer 
 * les prix en centimes. 
 */

/**
 * Ce fichier PHP est destiné à être exécuté en ligne de commande,
 * c'est-à-dire directement dans un terminal
 * 
 * Pour appeler un fichier PHP en ligne de commande, on se place dans le dossier
 * contenant le fichier PHP et on lance la commande "php <nom_du_fichier> <paramètres>"
 */

/**
 * On commence toujours par inclure les "dépendances", c'est-à-dire les fichiers PHP
 * dont on a besoin pour la suite du script. Ici on inclut le fichier config.php qui
 * définit des constantes avec les informations de connexion à la base de données
 */
require 'config.php';

/**
 * On va récupérer les paramètres de la commande dans la variable prédéfinie $argv
 * $argv contient un tableau dont le premier élément est le nom du fichier PHP
 * Les autres éléments du tableau sont les paramètres suivants
 * Si je lance la commande "php import.php users.csv", je vais récupérer dans $argv le tableau : 
 *  
 * array (2) {
 *    0 => "import.php",
 *    1 => "users.csv",
 * }
 */

/**
 * Ici le seul paramètre est le nom du fichier CSV que je souhaite importer
 * On va donc le récupérer dans la 2ème case du tableau $argv
 */

$filename = $argv[1];

/**
 * On vérifie que le fichier existe bien. S'il n'existe pas on affiche simplement un message d'erreur
 */
if (!file_exists($filename)) {
    echo "Erreur : fichier '$filename' introuvable";
    exit; // On arrête l'exécution du script
}

/**
 * Si on arrive là c'est que le fichier existe bien, on va l'ouvrir en lecture
 * grâce à la fonction fopen()
 */
$file = fopen($filename, "r");


/**
 * On se connecte à la base de données avec PDO et on prépare la requête d'insertion
 */
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdoStatement = $pdo->prepare('INSERT INTO subscribers (firstname, lastname, email, dateTime) VALUES (?,?,?,?)');

/**
 * Ensuite on va lire chaque ligne du fichier CSV avec la fonction fgetcsv()
 * tant qu'il y a des lignes à lire. S'il n'y a plus de nouvelle ligne, fgetcsv() retourne false.
 */
while ($row = fgetcsv($file)) {

    /**
     * $row représente une ligne du fichier CSV, les données sont récupérées dans un tableau
     * La première colone est le nom du produit
     * La deuxième colone est son prix sous forme d'une chaîne de caractères
     */
    $firstname = $row[0];
    $lastname = $row[1];
    $email = $row[2];
    $date = new DateTime();
    $newdate = $date->format('Y-m-d H:i:s');

    

   $firstname = strtolower($firstname);
   $firstname = ucwords($firstname, ' -');
   $lastname = strtolower($lastname);
   $lastname = ucwords($lastname, ' -');
   $email = strtolower($email);
   $email = str_replace(" ", "", $email);


    // Si le mail n'existe pas on enregistre le nouveau subscribers 
    if(!emailExist($email)) {
        $pdoStatement->execute([$firstname, $lastname, $email, $newdate]);
        // Sinon message "d'erreur"
    } else {
        echo "L'adresse $email existe déjà \n";
    }
 
}

echo 'Import terminé!';
