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

if(!strstr($_SERVER['SCRIPT_NAME'],"cron.ctrlPlanning.php")){
  $path=substr($_SERVER['SCRIPT_NAME'],-9)=="index.php"?null:"../../";
  $path=substr($_SERVER['SCRIPT_NAME'],-16)=="ics/calendar.php"?"../":$path;
  require_once "${path}include/config.php";
}

class blocagedepot {
   public $date=null;
   public $perso_id=null;
   public $site=1;

   //Get current lock state
   public function get(){
       $db=new db;
       $db->select2("pl_poste_verrou","*",array("date"=>$this->date, "site"=>$this->site));
       // si le planning du jour est verrouillé on sort 1
       if ($db->result ) return 1;
       // sinon on sort 0
       return 0;
   }

   //Toggle lock state
   public function toggle(){
       $lastlock=$this->get($this->date,$this->site);
       $db=new db;
       if ($lastlock == 1) $db->delete("pl_poste_verrou","`date`= '$this->date' and `blocage_dep_abs`= 1 and `perso2`= '$this->perso_id'");
       else $db->insert2("pl_poste_verrou",array("date"=>$this->date, "blocage_dep_abs"=>"1", "perso2"=>$this->perso_id, "site"=>$this->site));
       if ( $lastlock != $this->get($this->date,$this->site) ) return 1; //Success
       else return 0; //Failure
   }
   
   function updateDB($oldVersion,$newVersion){
        $sql=array();   // Liste des requêtes SQL à executer
        $dbprefix=$GLOBALS['config']['dbprefix'];
        $version=$oldVersion;

        echo "Mise à jour du plugin iBlocage Dépot : $oldVersion -> $newVersion<br/>";
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