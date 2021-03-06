<?php
/*
Planning Biblio, Plugin Congés Version 1.5.4
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.md et LICENSE
@copyright 2013-2017 Jérôme Combes

Fichier : plugins/conges/updateDB.php
Création : 18 juin 2014
Dernière modification : 18 juin 2014
@author Jérôme Combes <jerome@planningbiblio.fr>

Description :
Fichier permettant de vérifier et de mettre à jour la base de données si le plugins a été mis à jour.
Appelé par la fonction plugins::updateDB dans le fichier /plugins/plugins.php (planningBiblio)
*/

include_once "class.blocagedepot.php";

$c=new blocagedepot();
$c->updateDB($oldVersion,$version);
?>
