<?php
 echo "<DIV id='main_content'>";
 $cv = simplexml_load_file('cv.xml');
 $xp_box=false;
 $form_box=false;
 foreach ($cv->type as $type) {
  if($type['id']=='xp'){
   if(!$xp_box){
    $xp_box=true;
    echo "<div class='cvlist'>";
    echo "<span class='cv_list_title'>Experience</span>";
    echo "<br />";
    echo "<table>";
   }
   echo "<tr><td class='cv_liste_el'>";
   echo $type->date;
   echo "</td><td>";
   echo $type->contenu;
   echo "</td></tr>"; 
  }
  if($type['id']=='form'){
   if(!$form_box){
    $form_box=true;
    echo "</table></div>";
    echo "<div class='cvlist'>";
    echo "<span class='cv_list_title'>Formation</span>";
    echo "<br />";
    echo "<table>";
   }
   echo "<tr><td class='cv_liste_el'>";
   echo $type->titre;
   echo "</td><td>";
   echo $type->contenu;
   echo "</td></tr>";
  }     
 }
 echo "</table></div>";
 echo "</br >";
 echo "</br >";
 echo "<div class='cvlist'>";
 echo "<span class='cv_list_title_sup'>Competences autres</span><br />";
 echo $cv->competences;
 echo "</div>";
 echo "</br >";
 echo "<div class='cvlist'>";
 echo "<span class='cv_list_title_sup'>Language</span><br />";
 echo $cv->language;
 echo "</div>";
 echo "</br >";
 echo "<div class='cvlist'>";
 echo "<span class='cv_list_title_sup'>Hobby</span><br />";
 echo $cv->hobby;
 echo "</div>";
 echo "</div>";
?>
