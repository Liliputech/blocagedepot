<?php
/*
Planning Biblio, Plugin Blocage Dépot Version 1.5.8
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.md et LICENSE
@copyright 2013-2017 Arthur Suzuki

Fichier : plugins/blocagedepot/index.php
Création : 27 mars 2017
Dernière modification : 27 mars 2017
@author Olivier Crouzet <olivier.crouzet@univ-lyon3.fr>
@author Arthur Suzuki <arthur.suzuki@univ-lyon3.fr>

Description :
Fichier Index du dossier Blocage Dépot
Accessible par le menu Absences
Inclus dans le fichier index.php
*/

require_once "class.blocagedepot.php";

?>
<h3>Bloquer / D&eacute;bloquer</h3>
<br>
Choisissez une date sur laquelle vous souhaitez bloquer les dépôts d'absences.<br>
Si après selection la date s'affiche en rouge cela signifie qu'un blocage est déjà existant pour cette date.<br>
Si elle s'affiche en vert cela signifie qu'aucun blocage ne s'applique à cette date.<br>
La couleur du texte correspond toujours à l'état en cours pour la date inscrite.<br>
<br>
Date: <input type='text' id='datepicker' name='date'><input type="button" id="toggle" value="Bloquer / Débloquer"></input>
<script>

function getLockState(date){
    datepicker=document.getElementById('datepicker');
    datepicker.style.color="white";
    datepicker.style.fontWeight="bold";
    $.ajax({
        url: "plugins/blocagedepot/ajax.tmplock.php",
        dataType: "json",
        data: {date: date, op: "get" },
        type: "get",
        success : function(result){datepicker.style.background=result? 'red' : 'green';}
    });
}

$('#toggle').click(function(){
    datepicker=document.getElementById('datepicker');
    date=datepicker.value;
    $.ajax({
        type: "get",
        url: "plugins/blocagedepot/ajax.tmplock.php",
        data: { date:date, op:'toggle'},
        success : function() { getLockState(date) }
    });
});

$('#datepicker').datepicker({
    dateFormat:'yy-mm-dd',
    onSelect: function(date) { getLockState(date) }
}); 

</script>
