<?php
/*
Planning Biblio, Plugin Blocage Dépot Version 1.5.8
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.md et LICENSE
@copyright 2013-2017 Jérome Combe

Fichier : plugins/blocagedepot/index.php
Création : 27 mars 2017
Dernière modification : 28 mars 2017
@author Olivier Crouzet <olivier.crouzet@univ-lyon3.fr>
@author Arthur Suzuki <arthur.suzuki@univ-lyon3.fr>

Description :
Fichier Index du dossier Blocage Dépot
Accessible par le menu Absences
Inclus dans le fichier index.php
*/

$root= strstr(__DIR__,"plugins",TRUE);
require_once "$root/include/config.php";

class blocagedepot {
   public $date=null;
   public $perso_id=null;
   public $site=1;

   //Get current lock state
   public function get(){
       $db=new db;
       $db->select2("pl_poste_verrou","*",array("date"=>$this->date, "site"=>$this->site, "blocage_dep_abs"=>1));
       // si le planning du jour est verrouillé on sort 1
       if ($db->result ) return 1;
       // sinon on sort 0
       return 0;
   }

   //Toggle lock state
   public function toggle(){
       $lastlock=$this->get();
       $db=new db;
       $db2=new db;
       $db->select2("pl_poste_verrou","*",array("date"=>$this->date, "site"=>$this->site));
       if ($db->result) $db2->update("pl_poste_verrou","`blocage_dep_abs`= NOT `blocage_dep_abs`","`date`='$this->date' and `site`='$this->site'");
       else $db2->insert2("pl_poste_verrou",array("date"=>$this->date, "blocage_dep_abs"=>"1", "perso2"=>$this->perso_id, "site"=>$this->site));
       if ( $lastlock != $this->get() ) return 1; //Success
       else return 0; //Failure
   }
   
   public function controleAbsences(&$data){
	$this->date = date("y-m-d",strtotime($data["date"]));
	//Test si les dépots d'absences sont bloqués pour cette date
	if($this->get()) {
		$data["admin"] = "Le dépot d'absence est verrouillé pour le $this->date.\nEnregistrer l'absence malgré tout?";
		$data["info"] = "Le dépot d'absence est verrouillé pour le $this->date.\nMerci de prendre contact avec les responsables du Planning.";
	}
   }

   function updateDB($oldVersion,$newVersion){
        $sql=array();   // Liste des requêtes SQL à executer
        $dbprefix=$GLOBALS['config']['dbprefix'];
        $version=$oldVersion;

        echo "Mise à jour du plugin Blocage Dépot : $oldVersion -> $newVersion<br/>";
        $version="1.0";
        foreach($sql as $elem){
          $this->db->query($elem);
          if(!$this->db->error)
            echo "$elem : <font style='color:green;'>OK</font><br/>\n";
          else
            echo "$elem : <font style='color:red;'>Erreur</font><br/>\n";
        }
   }
}
?>
