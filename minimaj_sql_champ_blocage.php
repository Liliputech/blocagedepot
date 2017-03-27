<?php
$version="2.2.3";
require_once "include/config.php";

//ajout du champ blocage_dep_abs dans la table pl_poste_verrou pour les cas d'absences chevauchant la plage Sans-Repas
$sql = "ALTER TABLE `{$dbprefix}pl_poste_verrou` ADD `blocage_dep_abs` INT(1) NOT NULL DEFAULT '0' AFTER `perso`;";
$db=new db();
$db->query($sql);
?>
