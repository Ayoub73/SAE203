<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$racineServerChemin = $_SERVER['DOCUMENT_ROOT'];

$url = $_SERVER['REQUEST_URI'];
$urlListParts = explode('/', str_ireplace(array('http://', 'https://'), '', $url));
$urlListParts = array_filter($urlListParts);
$racineDossierRaw = [];

$listeDossiersExclure = ["administration"];

foreach ($urlListParts as $urlPart) {
    if (in_array($urlPart, $listeDossiersExclure)) {
        break;
    }

    if (
        strpos($urlPart, ".") === false &&
        !in_array($urlPart, glob("**", GLOB_ONLYDIR))
    ) {
        $racineDossierRaw[] = $urlPart;
    }
}

$racineDossier = "/" . join("/", $racineDossierRaw);

require_once("{$racineServerChemin}{$racineDossier}/classes/DotEnv.php");

$fichierEnvChemin = "{$racineServerChemin}{$racineDossier}/.env.prod";

$listDomaineLocaux = array(
    '127.0.0.1',
    '::1'
);

if (in_array($_SERVER['REMOTE_ADDR'], $listDomaineLocaux)) {
    $fichierEnvChemin = "{$racineServerChemin}{$racineDossier}/.env.dev";

    
}

(new DotEnv($fichierEnvChemin))->load();

try {
    $nomBDD = getenv('NOM_BDD');
    $serveurBDD = getenv('SERVEUR_BDD');

    // On se connecte à notre base de donnée
    $clientMySQL = new PDO(
        "mysql:host={$serveurBDD};dbname={$nomBDD};charset=utf8",
        getenv('UTILISATEUR_BDD'),
        getenv('MDP_BDD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
