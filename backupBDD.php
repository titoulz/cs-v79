<?php
$myFile = "./paramBDD.txt";
$lines = file($myFile);//file in to an array
foreach($lines as $line)
{
    $var = explode(' ', $line, 2);
    if(!isset($var[1]))
        $var[1] = "";
    $arr[$var[0]] = trim($var[1]);
}

// Chemin du fichier de sauvegarde
$backupFile = __DIR__ . DIRECTORY_SEPARATOR ."sql". DIRECTORY_SEPARATOR ."cs_cafe.sql";

// Construction de la commande mysqldump
$command = "c:\\xampp\\mysql\\bin\\mysqldump --user=".$arr["USERBDD"]." --password=".$arr["MDPBDD"]." --host=".$arr["IPBDD"]." ".$arr["BDD"]." > $backupFile";
echo $command;
// Exécution de la commande
exec($command, $output, $returnVar);

// Vérification de la réussite
if ($returnVar === 0) {
    echo "Sauvegarde réussie dans le fichier : {$backupFile}";
} else {
    echo "Erreur lors de la sauvegarde de la base de données.";
}