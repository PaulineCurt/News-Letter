<?php

// Connexion a la BDD
function connection()
{
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');
    return $pdo;
}

// Recheche des origines
function getAllOrigins()
{
    // Connexion BDD
    $pdo = connection();

    // Insertion dans la table origins
    $sql = 'SELECT *
            FROM origins
            ORDER BY originLabel';

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}


// Recherche des intérets
function getAllInterests()
{
    // Connexion BDD
    $pdo = connection();
    // Insertion dans la table interests
    $sql = 'SELECT *
            FROM interests
            ORDER BY interestLabel';

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}



// Ajoute un abonné à la liste des emails
function addSubscriber(string $email, string $firstname, string $lastname, int $originId)
{
    // Connexion BDD
    $pdo = connection();

    // Insertion de l'email dans la table subscribers
    $sql = 'INSERT INTO subscribers
            (email, firstname, lastname, originId, dateTime) 
            VALUES (?,?,?,?, NOW())';

    $query = $pdo->prepare($sql);
    $query->execute([$email, $firstname, $lastname, $originId]);

    return $pdo->lastInsertId();
}

// Ajoute les intérets aux subscribers
function addInterestSubscriber(int $userID, int $interestID)
{
    // Connextion BDD
    $pdo = connection();
    // Insertion  dans la table subscribers_interest
    $sql = 'INSERT INTO subscribers_interest
            (subscriberId , interestId) 
            VALUES (?,?)';

    $query = $pdo->prepare($sql);
    $query->execute([$userID, $interestID]);
}




function emailExist(string $email)
{
    // Construction du Data Source Name
    $pdo = connection();
    $sql = 'SELECT * FROM subscribers WHERE email=?';
    $query = $pdo->prepare($sql);
    $query->execute([$email]);
    
    $mailexists = $query->rowCount();
    if ($mailexists > 0) {
        return true;
    } else {
        return false;
    }
}