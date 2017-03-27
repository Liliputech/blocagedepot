<?php
/**
Planning Biblio, Plugin BlocageDepots Version 1
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.md et LICENSE
@copyright 2013-2017 Arthur Suzuki

Fichier : plugins/blocagedepot/install.php
Création : 27 mars 2017
Dernière modification : 27 mars 2017
@author Arthur Suzuki <arthur.suzuki@univ-lyon3.fr>

Description :
Fichier permettant l'installation du plugin Blocage Depot. Ajoute les informations nécessaires dans la base de données
*/

session_start();

// Sécurité
if($_SESSION['login_id']!=1){
  echo "<br/><br/><h3>Vous devez vous connecter au planning<br/>avec le login \"admin\" pour pouvoir installer ce plugin.</h3>\n";
  echo "<a href='../../index.php'>Retour au planning</a>\n";
  exit;
}

$version="1";
include_once "../../include/config.php";

$sql=array();


//ajout du champ blocage_dep_abs dans la table pl_poste_verrou pour les cas d'absences chevauchant la plage Sans-Repas
$sql[] = "ALTER TABLE `{$dbprefix}pl_poste_verrou` ADD `blocage_dep_abs` INT(1) NOT NULL DEFAULT '0' AFTER `perso`;";

// Droits d'accès
$sql[]="INSERT INTO `{$dbprefix}acces` (`nom`,`groupe_id`,`page`) VALUES ('Blocage des d&eacutepots','100','plugins/blocagedepot/index.php');";

// Menu
$sql[]="INSERT INTO `{$dbprefix}menu` (`niveau1`,`niveau2`,`titre`,`url`) VALUES (15,0,'Bloquer/D&eacute;bloquer','plugins/blocagedepot/index.php');";

// Inscription du plugin dans la base
$sql[]="INSERT INTO `{$dbprefix}plugins` (`nom`,`version`) VALUES ('blocagedepot','$version');";
?>

<!-- Entête HTML -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Plugin Blocage Depot - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
// Execution des requêtes
foreach($sql as $elem){
  $db=new db();
  $db->query($elem);
  if(!$db->error)
    echo "$elem : <font style='color:green;'>OK</font><br/>\n";
  else
    echo "$elem : <font style='color:red;'>Erreur</font><br/>\n";
}

echo "<br/><br/><a href='../../index.php'>Retour au planning</a>\n";
?>

</body>
</html>
