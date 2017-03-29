<?php
/**
Planning Biblio, Version 2.2.3
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.md et LICENSE
@copyright 2011-2016 Jérôme Combes

Fichier : planning/poste/ajax.tmplock.php
Création : 23 février 2015
Dernière modification : 3 avril 2015
@author Olivier Crouzet <olivier.crouzet@univ-lyon3.fr>
@author Arthur Suzuki <arthur.suzuki@univ-lyon3.fr>

Description :
Permet aux administrateurs de bloquer temporairement (et débloquer) le depot d'absence
tout en gardant la possibilité de modifier le planning
Page appelée en ajax lors du click sur les maillons de chaine de la page planning/poste/index.php
(événements $("#icon-tmplock").click et $("#icon-tmpunlock").click, page planning/poste/js/planning.js)
*/

session_start();
require_once "class.blocagedepot.php";

//~ // Initialisation des variables
$lock = new blocagedepot;
$lock->date=$_GET['date'];
$lock->perso_id=$_SESSION['login_id'];
if ( isset($_GET['site']) ) $lock->site=$_GET['site'];
if ( isset($_GET['op']) ) $op=$_GET['op'];

//default operation is get
if ( $op == 'toggle' ) echo $lock->toggle();
else echo $lock->get();
exit;
?>
