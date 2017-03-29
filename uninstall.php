<?php
/*
Planning Biblio, Plugin Blocage Dépot Version 1
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.md et LICENSE
@copyright 2013-2017 Jérôme Combes

Fichier : plugins/conges/uninstall.php
Création : 27 mars 2017
Dernière modification : 27 mars 2017
@author Arthur Suzuki <arthur.suzuki@univ-lyon3.fr>

Description :
Fichier permettant la désinstallation du plugin Blocage Dépot.
*/

session_start();

ini_set('display_errors','on');
error_reporting(999);

$confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_NUMBER_INT);

$version="1.0";
include_once "../../include/config.php";

?>

<!-- Entête HTML -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Plugin Blocage Dépot - Désinstallation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h3>Désintallation du plugin "Blocage D&eacute;pot"</h3>

<?php

// Sécurité : compte admin seulement
if($_SESSION['login_id']!=1){
  echo <<<EOD
  <p>
  <h3>Vous devez vous connecter au planning<br/>avec le login "admin" pour pouvoir d&eacute;sinstaller ce plugin.</h3>
  <a href='../../index.php'>Retour au planning</a>
  </p>
EOD;
  exit;
}

// Demande de confirmation
if(!$confirm){
  echo <<<EOD
  <p>
  Vous &ecirc;tes sur le point de d&eacute;sintaller le plugin Blocage d&eacute;pot.<br/>
  Voulez-vous continuer ?
  </p>
  <p>
  <form method='post' action='uninstall.php' name='form'>
  <input type='hidden' name='confirm' value='1' />
  <input type='button' value='Retour au planning' onclick='location.href="../../index.php";' />
  <input type='submit' value='Continuer la d&eacute;sinstallation' style='margin-left:20px;' />
  </form>
  </p>
EOD;
  exit;
}
// Désintallation
if($confirm == 1){
  echo "<p><strong>Suppression du plugin</strong></p>";
  
  $sql=array();
  
  // Droits d'accès
  $sql[]="DELETE FROM `{$dbprefix}acces` WHERE `page` LIKE 'plugins/blocagedepot/%';";

  // Suppression du menu
  $sql[]="DELETE FROM `{$dbprefix}menu` WHERE `url` LIKE 'plugins/blocagedepot/%';";

  //suppression du champ blocage_dep_abs dans la table pl_poste_verrou
  $sql[] = "ALTER TABLE `{$dbprefix}pl_poste_verrou` DROP `blocage_dep_abs`;";

  // Suppression du plugin Blocage Dépot dans la base
  $sql[]="DELETE FROM `{$dbprefix}plugins` WHERE `nom`='blocagedepot';";

  // Execution des requêtes
  foreach($sql as $elem){
    $db=new db();
    $db->query($elem);
    if(!$db->error)
      echo "$elem : <font style='color:green;'>OK</font><br/>\n";
    else
      echo "$elem : <font style='color:red;'>Erreur</font><br/>\n";
  }
}

echo "<br/><br/><a href='../../index.php'>Retour au planning</a>\n";
?>

</body>
</html>
