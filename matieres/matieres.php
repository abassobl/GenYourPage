<?php
 echo "<DIV id='main_content'>";
 $val=false;
 if(constant('MERGE_TEACH')===true){
  $matiere_t=array();
  $matiere = simplexml_load_file('matieres/matieres.xml');
  foreach ($matiere->type as $type) {
    $matiere_t[]=$type->titre;
  }
  $matiere_t=array_unique($matiere_t);
  foreach($matiere_t as $type_e){
   echo "<div class='tdlist'>";
   echo "<span class='td_list_title'>".$type_e."</span>";
   echo "<br />";
   foreach ($matiere->type as $type) {
    echo $type->titre."<br />";
    if($type->titre==$type_e){
     echo "type identique <br />";
     echo $type->contenu;
     echo "<br />";
     echo "<div class='td_list_dl'>";
     foreach ($type->fichier as $file) {
      echo "<a class='td_list_dl' href='".$file."'>".basename($file,'.'.pathinfo($file,PATHINFO_EXTENSION))."</a>";
      echo "<br />";
     }
     echo "</div>";
    }
   }
   echo "</div>";
  }
 }
 else{
  if(isset($_POST['menu_mat']) && $_POST['menu_mat']==constant('TD')){
   $matiere = simplexml_load_file('matieres/matieres.xml');
   foreach ($matiere->type as $type) {
    if($type['id']=="td"){
     echo "<div class='tdlist'>";
     echo "<span class='td_list_title'>".$type->titre."</span>";
     echo "<br />";
     echo $type->contenu;
     echo "<br />";
     echo "<div class='td_list_dl'>";
     foreach ($type->fichier as $file) {
      echo "<a class='td_list_dl' href='".$file."'>".basename($file,'.'.pathinfo($file,PATHINFO_EXTENSION))."</a>";
      echo "<br />";
     }
     echo "</div>";
     echo "</div>";
    }
   } 
  }
  if(isset($_POST['menu_mat']) && $_POST['menu_mat']==constant('TEACHING')){
   $matiere = simplexml_load_file('matieres/matieres.xml');
   foreach ($matiere->type as $type) {
    if($type['id']=="cours"){
     echo "<div class='tdlist'>";
     echo "<span class='td_list_title'>".$type->titre."</span>";
     echo "<br />";
     echo $type->contenu;
     echo "<br />";
     echo "<div class='td_list_dl'>";
     foreach ($type->fichier as $file) {
      echo "<a class='td_list_dl' href='".$file."'>".basename($file,'.'.pathinfo($file,PATHINFO_EXTENSION))."</a>";
      echo "<br />";
     }
     echo "</div>";
     echo "</div>";
    } 
   }
  }
 }
 echo "</DIV>";
?>
