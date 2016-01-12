<html>
<head>
</head>
<body>
<?php 
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                                *****VARIABLES GLOBALES*****                                                                          ***
 ***                                                         																		  ***
 *** $_SESSION['menu_merge_bib']        : indique si les bibliographies sont fusionnées ou non (prend le pas sur $_SESSION['menu_bib_ok'] et $_SESSION['menu_res_ok'])                                    ***
 *** $_SESSION['menu_bib_ok']           : indique si un menu bibliographie est necessaire.                                                                                                                ***
 *** $_SESSION['my_bib_php_content']    : contenu du fichier php de bibliographie personelle (voir global si l'option est validée)                                                                        ***
 *** $_SESSION['menu_res_ok']           : indique si un menu ressources est necessaire           													  ***
 *** $_SESSION['res_bib_php_content']   : contenu du fichier php de bibliographie de ressource (n'existe pas si les deux bibliographie sont fusionnées)                                                   ***
 *** $_SESSION['home_content']          : contenu de la page d'acceuil (sauf l'encart)                                                                                                                    ***
 *** $_SESSION['enc_content']           : contenu de l'encart de la page d'acceuil															  ***
 *** $_SESSION['menu_merge_td']         : indique si les matieres sont fusionnées ou non (prend le pas sur $_SESSION['menu_td_ok'] et $_SESSION['menu_cours_ok'])             				  ***
 *** $_SESSION['menu_cours_ok']         : indique si une liste des cours est à générer															  ***
 *** $_SESSION['menu_td_ok']            : indique si une liste de TD est à générer          														  ***
 *** $_SESSION['matiere_xml_content']   : contenu du fichier xml contenant les Matieres (TD/Cours)                                                                                                        ***
 *** $_SESSION['index_php_content']     : Liste des elements du menu et leur path pour le fichier de configuration                                                                                        ***
 *** $_SESSION['menu_langue']           : langue du menu (anglais ou français)                                                                                                                            ***
 *** $_SESSION['menu_cv_ok']            : indique si un CV est à générer                                                                                                                                  ***
 *** $_SESSION['cv_xml_content']        : contenu du fichier XML du CV                                                                                                                                    ***
 *** $_SERVER['PHP_SELF']               : nom de la page actuelle, permet un renommage                                                                                                                    ***
 *** $_SESSION['User_name']             : prenom de l'utilisateur                                                                                                                                         ***
 *** $_SESSION['User_fname']            : nom de l'utilisateur                                                                                                                                            ***
 *** $_SESSION['User_role']             : Fonction de l'utilisateur                                                                                                                                       ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                               *****FONCTIONS*****                                                                                    ***
 ***                                                         																		  ***
 *** gen_site()      : écrit le contenu des formulaires dans les fichiers config.php, matiere.xml, bibliographie.php, ressources.php, cv.xml, home.php                                                    ***
 *** gen_cv_page()   : genère le formulaire pour le CV                                                                                                                                                    ***
 *** gen_bib_page()  : genère le formulaire de bibliographie                                                        				        						  ***
 *** gen_mat_page()  : genère le formulaire pour les TD/cours                                                                                                                                             ***
 *** gen_home_page() : genère le formulaire pour la page d'acceuil                                                                                                                                        ***
 *** gen_choice()    : genère le formulaire de configuration                                                                                                                                              ***
 *** save_cv()       : recupère les informations du formulaire de CV                                                                                                                                      ***
 *** save_bib()      : recupère les informations du formulaire de biblio                                                                                                                                  ***
 *** save_mat()      : recupère les information du formulaire TD/Cours                                                                                                                                    ***
 *** save_home()     : recupère les informations du formulaire d'homepage                                                                                                                                 ***
 *** save_config()   : recupère les informations du forumlaire de configuration                                                                                                                           ***
 *** cleangen()      : réinitialise le générateur																			  ***      
 ***                                                                                                                                                                                                      ***
 *** file_upload_error($fichier) : gère les erreur d'upload de fichier : renvoie true si aucune erreur, false sinon, $fichier est le path du fichier sous forme de chaine de caracteres                   ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                *****GENERATION DU SITE (ecriture dans les fichiers xml)*****                                                         ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function gen_site(){
 $tag=false;
 // ************************************************************************************** génération du fichier de configuration ***************************************************************************
 if(!$fp = fopen("layout/config.php","w+")){
  echo "Impossible d'acceder au fichier config.php<br />";
  $tag=true;
 } else {
  $contents = $_SESSION['index_php_content'];
  $contents="\n <?php @define('UNAME','".$_SESSION['User_name']."');\n @define('UFNAME','".$_SESSION['User_fname']."');\n @define('UROLE','".$_SESSION['User_role']."');\n ?>".$contents;
  fputs($fp,$contents);
  fclose($fp);
  echo "fichier de configuration mis à jour<br />";
  unset($_SESSION['index_php_content']);
 }
 // *************************************************************************************** Génération de l'homepage ****************************************************************************************
 if(!$fp = fopen("home.php","w+")){
   echo "Impossible d'acceder au fichier Home.php<br />";
   $tag=true;
  } else {
   $contents=$_SESSION['home_content'];
   fputs($fp,$contents);
   fclose($fp);
   echo "homepage mis à jour<br />";
   unset($_SESSION['home_content']);
  }
 // ************************************************************************************** génération des fichier de biblio *********************************************************************************
 if(isset($_SESSION['my_bib_php_content'])){
  if(!$fp = fopen("publication/Bibliographie.php","w+")){
   echo "Impossible d'acceder au fichier Bibliographie.php<br />";
   $tag=true;
  } else {
   $contents=$_SESSION['my_bib_php_content'];
   fputs($fp,$contents);
   fclose($fp);
   echo "fichier de bibliographie mis à jour<br />";
   unset($_SESSION['my_bib_php_content']);
  }
 }
 if(isset($_SESSION['res_bib_php_content'])){
  if(!$fp = fopen("publication/Ressources.php","w+")){
   echo "Impossible d'acceder au fichier Ressources.php<br />";
   $tag=true;
  } else {
   $contents=$_SESSION['res_bib_php_content'];
   fputs($fp,$contents);
   fclose($fp);
   echo "fichier de ressource mis à jour<br />";
   unset($_SESSION['res_bib_php_content']);
  }
 }
 // ************************************************************************************** génération des xml TD COURS **************************************************************************************
 if(isset($_SESSION['matiere_xml_content'])){
  if(!$fp = fopen("matieres/matieres.xml","w+")){
   echo "Impossible d'acceder au fichier matieres.xml<br />";
   $tag=true;
  } else {
   $contents=$_SESSION['matiere_xml_content'];
   fputs($fp,$contents);
   fclose($fp);
   echo "fichier de matieres mis a jour<br />";
   unset($_SESSION['matiere_xml_content']);
  }
 }
// ************************************************************************************** génération des xml CV **************************************************************************************
 if(isset($_SESSION['cv_xml_content'])){
  if(!$fp = fopen("cv.xml","w+")){
   echo "Impossible d'acceder au fichier CV.xml<br />";
   $tag=true;
  } else {
   $contents=$_SESSION['cv_xml_content'];
   fputs($fp,$contents);
   fclose($fp);
   echo "fichier de CV mis a jour<br />";
   unset($_SESSION['cv_xml_content']);
  }
 }
// *************************************************************************************** Création d'une archive avec les fichiers du site.
$zip = new ZipArchive();
if($zip->open('www.zip', ZipArchive::CREATE) == TRUE){
 $zip->addEmptyDir('WWW');
  $zip->addFile('index.php','WWW/index.php');
  $zip->addFile('home.php','WWW/home.php');
  $zip->addFile('cv.xml','WWW/cv.xml');
  $zip->addFile('CV.php','WWW/CV.php');
  $zip->addEmptyDir('WWW/publication');// ********************************************* dossier publication
   $zip->addFile('publication/Bibliographie.php','WWW/publication/Bibliographie.php');
   $zip->addFile('publication/Ressources.php','WWW/publication/Ressources.php');
   $zip->addFile('publication/bibtexbrowser.local.php','WWW/publication/bibtexbrowser.local.php');
   $zip->addFile('publication/bibtexbrowser.php','WWW/publication/bibtexbrowser.php');
   $zip->addEmptyDir('WWW/publication/my');
   if($dir=opendir("publication/my")){
    while($my=readdir($dir)){
     if(is_file('publication/my/'.$my)){
      $zip->addFile('publication/my/'.$my,'WWW/publication/my/'.$my);
     }
    }
    closedir($dir);
   }else{
    $tag=true;
    echo "impossible d'ouvrir le dossier publication/my";
   }
   $zip->addEmptyDir('WWW/publication/reco');
   if($dir=opendir("publication/reco")){
    while($reco=readdir($dir)){
     if(is_file('publication/reco/'.$reco)){
      $zip->addFile('publication/reco/'.$reco,'WWW/publication/reco/'.$reco);
     }
    }
    closedir($dir);
   }else{
    $tag=true;
    echo "impossible d'ouvrir le dossier publication/reco";
   }
  $zip->addEmptyDir('WWW/matieres');// *************************************** dossier matière
   $zip->addFile('matieres/matieres.php','WWW/matieres/matieres.php');
   $zip->addFile('matieres/matieres.xml','WWW/matieres/matieres.xml');
   $zip->addEmptyDir('WWW/matieres/cours');
   if($dir=opendir("matieres/cours")){
    while($cour=readdir($dir)){
     if(is_file('matieres/cours/'.$cour))
      $zip->addFile('matieres/cours/'.$cour,'WWW/matieres/cours/'.$cour);
    }
    closedir($dir);
   }else{
    $tag=true;
    echo "impossible d'ouvrir le dossier matiere/cours";
   }
   $zip->addEmptyDir('WWW/matieres/td');
   if($dir=opendir("matieres/td")){
    while($td=readdir($dir) ){
     if(is_file('matieres/td/'.$td))
      $zip->addFile('matieres/td/'.$td,'WWW/matieres/td/'.$td);
    }
    closedir($dir);
   }else{
    $tag=true;
    echo "impossible d'ouvrir le dossier matiere/td";
   }
  $zip->addEmptyDir('WWW/layout');// ************************************** dossier layout
   $zip->addFile('layout/config.php','WWW/layout/config.php');
   $zip->addFile('layout/constan.ttf','WWW/layout/constan.ttf');
   $zip->addFile('layout/constanb.ttf','WWW/layout/constanb.ttf');
   $zip->addFile('layout/constani.ttf','WWW/layout/constani.ttf');
   $zip->addFile('layout/constanz.ttf','WWW/layout/constanz.ttf');
   $zip->addFile('layout/Ibisc.css','WWW/layout/Ibisc.css');
   $zip->addFile('layout/webpage_mod.png-g4174-590.png','WWW/layout/webpage_mod.png-g4174-590.png');
   $zip->addFile('layout/webpage_mod.png-rect3781-898.png','WWW/layout/webpage_mod.png-rect3781-898.png');
   $zip->addFile('layout/webpage_mod.png-rect3783-228.png','WWW/layout/webpage_mod.png-rect3783-228.png');
  $zip->addEmptyDir('WWW/images');// *********************************************************************** dossier images
   $zip->addFile('images/icone_bib.gif','WWW/images/icone_bib.gif');
   $zip->addFile('images/icone_doi.jpg','WWW/images/icone_doi.jpg');
   $zip->addFile('images/icone_pdf.gif','WWW/images/icone_pdf.gif');
   $zip->addFile('images/icone_pdfs.gif','WWW/images/icone_pdfs.gif');
   $zip->addFile('images/logo-genopole.png','WWW/images/logo-genopole.png');
   $zip->addFile('images/logoIBISC.png','WWW/images/logoIBISC.png');
   $zip->addFile('images/logoueve.png','WWW/images/logoueve.png');
   $zip->addFile('images/S_ibisc_bar.png','WWW/images/S_ibisc_bar.png');
   if(file_exists("images/identity_tmp.png")){
    $zip->addFile('images/identity_tmp.png','WWW/images/identity.png');
   }else{
    $zip->addFile('images/identity.png','WWW/images/identity.png');
   }
 $zip->close();
}
else{
 echo "impossible de créer une archive";
 $tag=true;
}
 // ****************************************************************************** fin du script : erreur ou suppression du fichier ! ***********************************************************************

 if(!$tag){
  echo "<p><font color='red'>Attention</font>,<br /> Vous devez récupérer le dossier www.zip crée dans le dossier courant et uniquement cette archive.</p><br /><br />";
 } else {
  echo "Une ou plusieurs erreurs sont survenu, merci de relancer le script.";
 }
 echo "<form method='post' action='".basename($_SERVER['PHP_SELF'])."' enctype='multipart/form-data'>";
 if(!$tag){
  echo "<label for='sup'>Voulez vous remettre à zéro le générateur ?</label>";
  echo "<input type='checkbox' name='sup' checked='checked' />";
  echo "<input type='hidden' name='suppr_submit' value='done' />";
 }
 echo "<input type='submit' value='Terminer' />";
 echo "</form>";
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                *****NETOYAGE DU GENERATEUR (efface les fichier temporaires)*****                                                     ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function cleangen(){
//************************************** suppression/réinitialisation des fichier ***************************
 fopen('cv.xml','w');
 fopen('home.php','w');
 if(file_exists("images/identity_tmp.png"))
  unlink('images/identity_tmp.png');
 fopen('layout/config.php','w');
 fopen('matieres/matieres.xml','w');
 foreach (glob("matieres/cours/*.*") as $filename)
  unlink($filename); 
 foreach (glob("matieres/td/*.*") as $filename)
  unlink($filename);
 fopen('publication/Bibliographie.php','w'); 
 fopen('publication/Ressources.php','w');
 foreach (glob("publication/my/*.*") as $filename)
  unlink($filename); 
 foreach (glob("publication/reco/*.*") as $filename)
  unlink($filename); 


}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                           *****Gestion de l'upload des fichiers*****                                                                 ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function file_upload_error($fichier){
 if(!isset($_FILES[$fichier])){
  echo "l'entrée FILE pour ".$fichier." n'a pas été créée<br />";
  return false;
 }
 if ($_FILES[$fichier]['error']) {     
  switch ($_FILES[$fichier]['error']){     
   case 1: // UPLOAD_ERR_INI_SIZE     
    echo"Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !<br />";     
    break;     
   case 2: // UPLOAD_ERR_FORM_SIZE     
    echo "Le fichier dépasse la limite autorisée dans le formulaire HTML !<br />"; 
    break;     
   case 3: // UPLOAD_ERR_PARTIAL     
    echo "L'envoi du fichier a été interrompu pendant le transfert !<br />";     
    break;     
   case 4: // UPLOAD_ERR_NO_FILE     
    echo "Le fichier que vous avez envoyé a une taille nulle !<br />"; 
    break;
   default:
    echo "Erreur inconnue";
    break;     
  }  
  return false;   
 }     
 else {     
 // $_FILES[$fichier]['error'] vaut 0 soit UPLOAD_ERR_OK     
 echo $fichier." a été uploader avec succes<br />";  
  return true; 
 }
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                                 *****Formulaire de CV*****                                                                           ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function gen_cv_page(){ ?>
<script type="text/javascript">// ************ créer un champ de plus pour experience **************************************
 // ajout d'une nouvelle section cv;
 function plus_cv(Nom){
  var container,all_ch, new_txt, new_area,l1,l2;
  container=document.getElementById(Nom+'_box');
  all_ch=container.getElementsByTagName('textarea');
  l1=document.createElement('label');
  l1.appendChild(document.createTextNode("Année :"));
  l1.htmlFor=Nom+'_date'+all_ch.length;
  container.appendChild(l1);//ajout label champ texte
  new_txt=document.createElement('input');
  new_txt.setAttribute('type','text');
  new_txt.setAttribute('name',Nom+'_date'+all_ch.length);
  container.appendChild(new_txt);//ajout champ texte
  container.appendChild(document.createElement('br'));
  l2=document.createElement('label');
  l2.appendChild(document.createTextNode("informations :"));
  l2.htmlFor=Nom+'_cont'+all_ch.length;
  container.appendChild(l2);//ajout label commentaire
  new_area=document.createElement('textarea');
  new_area.setAttribute('cols',30);
  new_area.setAttribute('rows',5);
  new_area.setAttribute('name',Nom+'_cont'+all_ch.length);
  container.appendChild(new_area);//ajout de la zone de commentaire
  container.appendChild(document.createElement('br'));
 }// ******************************************* fin script champ supplementaire ************************************
 </script> 
 <DIV style="position:absolute;align:center">
   <form method="post" action=<?php echo "\"".basename($_SERVER['PHP_SELF'])."\"" ?> enctype="multipart/form-data">
    <div style="position:absolute;left:0px;width:100px;top:0px;margin:0px;padding:0px;">
     <fieldset>
      <legend>Experience</legend>
      <div id='xp_box'>
       
       <label for="xp_date0">Année :</label>
       <input type="text" name="xp_date0" />
       <br />
       <label for="xp_cont0">informations :</label>
       <textarea name="xp_cont0" rows=5 cols=30></textarea>
      <br />
      </div>
      <div>
        <input type="button" value="ajouter de l'experience" onclick="plus_cv('xp');" />
      </div>
     </fieldset>
    </div>
    <div style="position:absolute;left:300px;width:100px;top:0px;">
     <fieldset>
      <legend>Formation</legend>
      <div id='form_box'>
       
       <label for="form_date0">Année :</label>
       <input type="text" name="form_date0" />
       <br />
       <label for="form_cont0">informations :</label>
       <textarea name="form_cont0" rows=5 cols=30></textarea>
      <br />
      </div>
      <div>
        <input type="button" value="ajouter une année de formation" onclick="plus_cv('form');" />
      </div>
     </fieldset>
    </div>
    <div style="position:absolute;left:600px;width:250px;top:0px;">
     <fieldset>
     <legend>Informations complementaires</legend>
      <div id='info'>
       <label for="comp">competences :(c1,c2,...)</label>
       <input type="text" name="comp" />
       <br />
       <label for="keywords">mots clés :(k1,k2,...)</label>
       <input type="text" name="keywords" />
       <br />
       <label for="hobby">Passions autres :(p1,p2,...)</label>
       <input type="text" name="hobby" />
       <br />
       <label for="lang">Langues parlées :(l1,l2,...)</label>
       <input type="text" name="lang" />
       <br />
      </div>
     </fieldset>
    </div>
    <DIV style="position:absolute;left:700px;width:100px;top:250px;">
     <input type="hidden" name="cv_submit" value="done" />
     <input type="reset" value="Reset" />
     <input type="submit" value="Suivant" />
    </DIV>
   </form>
  </div>
<?php }
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                           *****Formulaire de bibliographie*****                                                                      ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function gen_bib_page(){
 if($_SESSION['menu_merge_bib']==='on'){ ?>
  <DIV style="position:absolute;align:center">
   <form method="post" action=<?php echo "\"".basename($_SERVER['PHP_SELF'])."\"" ?> enctype="multipart/form-data">
    <div>
     <fieldset>
      <legend>Bibliographie globale</legend>
      <label for="bib_m_file">Selectionnez un fichier Bibtex à uploader :</label>
      <br />
      <input type="file" name="bib_m_file" />
     </fieldset>
    </div>
    <DIV>
     <input type="hidden" name="bib_submit" value="done" />
     <input type="reset" value="Reset" />
     <input type="submit" value="Suivant" />
    </DIV>
   </form>
  </div>
 <?php }
 else{ ?>
  <DIV style="position:absolute;align:center">
   <form method="post" action=<?php echo "\"".basename($_SERVER['PHP_SELF'])."\"" ?> enctype="multipart/form-data">
  <?php if($_SESSION['menu_bib_ok']==='on'){ ?>
    <div>
     <fieldset>
      <legend>Bibliographie personelle</legend>
      <label for="bib_p_file">Selectionnez un fichier Bibtex à uploader :</label>
      <br />
      <input type="file" name="bib_p_file" />
     </fieldset>
    </div>
  <?php }
  if($_SESSION['menu_res_ok']==='on'){ ?>
   <div>
     <fieldset>
      <legend>Bibliographie suggerée</legend>
      <label for="bib_r_file">Selectionnez un fichier Bibtex à uploader :</label>
      <br />
      <input type="file" name="bib_r_file" />
     </fieldset>
    </div>
  <?php } ?>
  <DIV>
   <input type="hidden" name="bib_submit" value="done" />
   <input type="reset" value="Reset" />
   <input type="submit" value="Suivant" />
  </DIV>
  </form>
  </div>
 <?php }
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                               *****Formulaire de Matiere*****                                                                        ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function gen_mat_page(){ ?>
 <script type="text/javascript">// ******************** créer un champ de plus pour cours ou TD *******************************
 // ajout d'une nouvelle section cours;
 function plus_mat(Nom){
  var container,all_ch,all_ch_l, new_txt, new_area, new_file,new_div,new_button,l1,l2,l3;
  container=document.getElementById(Nom+'_box');
  all_ch=container.getElementsByTagName('textarea');
  all_ch_l=all_ch.length;
  l1=document.createElement('label');
  l1.appendChild(document.createTextNode("titre du "+Nom+" :"));
  l1.htmlFor='t_'+Nom+''+all_ch_l;
  container.appendChild(l1);//ajout label champ texte
  new_txt=document.createElement('input');
  new_txt.setAttribute('type','text');
  new_txt.setAttribute('name','t_'+Nom+''+all_ch_l);
  container.appendChild(new_txt);//ajout champ texte
  container.appendChild(document.createElement('br'));
  l2=document.createElement('label');
  l2.appendChild(document.createTextNode("commentaire :"));
  l2.htmlFor='c_'+Nom+''+all_ch_l;
  container.appendChild(l2);//ajout label commentaire
  container.appendChild(document.createElement('br'));
  new_area=document.createElement('textarea');
  new_area.setAttribute('cols',20);
  new_area.setAttribute('rows',5);
  new_area.setAttribute('name','c_'+Nom+''+all_ch_l);
  container.appendChild(new_area);//ajout de la zone de commentaire
  container.appendChild(document.createElement('br'));
  new_div=document.createElement('div');
  new_div.setAttribute('id','file_'+Nom+'_box'+all_ch_l);
  l3=document.createElement('label');
  l3.appendChild(document.createTextNode("fichier du "+Nom+" :"));
  l3.htmlFor='f_'+Nom+''+all_ch_l+'0';
  new_div.appendChild(l3);//ajout label fichier
  new_div.appendChild(document.createElement('br'));
  new_file=document.createElement('input');
  new_file.setAttribute('type','file');
  new_file.setAttribute('name','f_'+Nom+''+all_ch_l+'0');
  new_div.appendChild(new_file);//ajout champ fichier
  new_div.appendChild(document.createElement('br'));
  container.appendChild(new_div);
  new_button=document.createElement('input');
  new_button.setAttribute('type','button');
  new_button.setAttribute('value','ajouter un fichier');
  new_button.setAttribute('onclick','plus_file(\''+Nom+'\',\''+all_ch_l+'\');');
  container.appendChild(new_button);
  container.appendChild(document.createElement('br'));
  
 }// ******************************************* fin script champ supplementaire ************************************
 </script>
 <script type="text/javascript">// ******************** créer un champ fichier supplementaire *******************************
  function plus_file(Nom,Val){
   var sub_cont,all_ch_sub,all_ch_sub_l,new_file,l1;
   sub_cont=document.getElementById('file_'+Nom+'_box'+Val);
   all_ch_sub=sub_cont.getElementsByTagName('input');
   all_ch_sub_l=all_ch_sub.length;
   new_file=document.createElement('input');
   new_file.setAttribute('type','file');
   new_file.setAttribute('name','f_'+Nom+''+Val+''+all_ch_sub_l);
   sub_cont.appendChild(new_file);//ajout champ fichier
   sub_cont.appendChild(document.createElement('br'));
  }
 </script>
 <DIV style="position:absolute;top:50px">
 <form method="post" action=<?php echo "\"".basename($_SERVER['PHP_SELF'])."\"" ?> enctype="multipart/form-data">
   <?php //echo "cours : ".$_SESSION['menu_cours_ok'];
   //echo "td : ".$_SESSION['menu_td_ok'];
   if($_SESSION['menu_cours_ok']==='on' || $_SESSION['menu_merge_td']==='on'){ ?>   
    <div>
     <fieldset>
      <legend>Contenu des Cours</legend>
       <div id="cours_box">
        <label for="t_cours0">titre du cours :</label>
        <input type=text name="t_cours0" />
        <br />
        <label for="c_cours0">commentaire :</label>
        <br />
        <textarea name="c_cours0" cols=20 rows=5>commentaires sur le cours</textarea>
        <br />
        <div id="file_cours_box0">
         <label for="f_cours00">fichier du cour :</label>
         <br />
         <input type="file" name="f_cours00" />
         <br />
        </div>
         <input type="button" value="ajouter un fichier" onclick="plus_file('cours','0');" />
         <br /> 
        </div>
       <div>
        <input type="button" value="ajouter un cours" onclick="plus_mat('cours');" />
       </div>
      </fieldset>
     </div>
    <?php } 
    if($_SESSION['menu_td_ok']==='on' || $_SESSION['menu_merge_td']==='on'){ ?>
     <div style="position:absolute;left:400px;top:0px">
      <fieldset>
       <legend>Contenu des TD</legend>
       <div id="td_box">
        <label for="t_td0">titre du td :</label>
        <input type=text name="t_td0" />
        <br />
        <label for="c_td0">commentaire :</label>
        <textarea name="c_td0" cols=20 rows=5>commentaires sur le td</textarea>
        <br />
        <div id="file_td_box0">
         <label for="f_td00">fichier td :</label>
         <br />
         <input type="file" name="f_td00" />
        <br />
        </div>
        <input type="button" value="ajouter un fichier" onclick="plus_file('td','0');" /> 
        <br />
       </div>
       <div>
        <input type="button" value="ajouter un TD" onclick="plus_mat('td');" />
       </div>
      </fieldset>
     </div>
    <?php } ?>
   <DIV style="position:absolute;left:670px;width:100px;top:0px;">
    <input type="hidden" name="cours_TD_submit" value="done" />
    <input type="reset" value="Reset" />
    <input type="submit" value="Suivant" />
   </DIV>
  </form>
 </div>
 <?php
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                             *****Formulaire de Homepage*****                                                                         ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function gen_home_page(){?>
 <DIV style="position:absolute;align:center">
 <form method="post" action=<?php echo "\"".basename($_SERVER['PHP_SELF'])."\"" ?> enctype="multipart/form-data">
  <div>
   <fieldset>
    <legend>information personelles</legend>
    <label for="user_name">Prenom :</label>
    <input type="text" name="user_name" />
    <label for="user_first_name">Nom :</label>
    <input type="text" name="user_first_name"/>
    <label for="user_role">Fonction :</label>
    <SELECT name="user_role" size="1">
     <OPTION>Doctorant
     <OPTION>Ingenieur
     <OPTION>Maitre de conference
     <OPTION>Post-Doc
     <OPTION>Professeur
     <OPTION>Stagiaire
    </SELECT>
   </fieldset>
   <fieldset>
    <legend>Contenu de la page d'acceuil</legend>
    <table border=0>
     <tr><td>
    <label for="home_content">Contenu de l'acceuil</label>
    </td><td><label for="enc_content">Contenu de l'encart</label></td>
    </tr><tr><td>
    <textarea name="home_content" cols=50 rows=30>Présentation des recherches(par exemple)</textarea>
    </td><td>
    <textarea name="enc_content" cols=50 rows=30>informations personelles (l'email est automatiquement généré)</textarea>
    </td></tr></table>
    <label for="img_home">Votre image personelle : </label>
    <input type="file" name="img_home" />
   </fieldset>
   <input type="hidden" name="home_submit" value="done" />
  </DIV>
  <DIV>
   <input type="reset" value="Reset" />
   <input type="submit" value="Suivant" />
  </DIV>
 </form>
</div>
<?php }
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                      *****Formulaire de configuration*****                                                                           ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function gen_choice(){ ?>
 <DIV style="height:758px;position:absolute;align:center">
 <form method="post" action=<?php echo "\"".basename($_SERVER['PHP_SELF'])."\"" ?> >
  <DIV>
   <fieldset>
    <legend>Options du menu</legend>
    <label for="menu_langue">Choix de la langue</label>
    <br />
    <select name="menu_langue">
     <option value="fr">Français</option>
     <option value="en">English</option>
    </select>
    <br />
    <label for="menu_merge_td">Onglet cours/td</label>
    <br />
    <input type="checkbox" name="menu_merge_td">Regrouper TD et Cours en une seul page</input>
    <br />
    <label for="menu_merge_bib">Onglet Bibliographie</label>
    <br />
    <input type="checkbox" name="menu_merge_bib">Regrouper biblio et ressources au même endroit</input>
    <br />
    <fieldset>
     <legend>Présence d'éléments</legend>
     <br />
     <input type="checkbox" name="menu_bib_ok">intégrer votre bibliographie au site</input>
     <br />
     <input type="checkbox" name="menu_res_ok">intégrer une liste de ressources</input>
     <br />
     <input type="checkbox" name="menu_cours_ok">intégrer une page de cours</input>
     <br />
     <input type="checkbox" name="menu_td_ok">intégrer une page de TD</input>
     <br />
     <input type="checkbox" name="menu_cv_ok">intégrer une page de cv</input>
     <br />
    </fieldset>
   </fieldset>
   <input type="hidden" name="menu_submit" value="done" />
  </DIV>
  <DIV>
   <input type="reset" value="Reset" />
   <input type="submit" value="Suivant" />
  </DIV>
 </form>
</DIV>
<?php }
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                           *****Sauvegarde de configuration*****                                                                      ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function save_config(){
 $_index_head="<?php\n";
 $menuc="\$menu=[HOME";
 $menupc="\$menu_path=[HOME_PATH";
 if(isset($_POST['menu_langue'])){
  //echo $_POST['menu_langue'];
  $_index_head=$_index_head."@define('LANG','".$_POST['menu_langue']."');\n";
  $_SESSION['menu_langue']=$_POST['menu_langue'];//fr/en
 }else{$_SESSION['menu_langue']='off';}
 $_index_head=$_index_head."@define('HOME_PATH','Home.php');\n";
 
 if(isset($_POST['menu_merge_td'])){
  //echo $_POST['menu_merge_td'];
  $menuc=$menuc.",TEACHING";
  $menupc=$menupc.",TEACHING_PATH";
  $_index_head=$_index_head."@define('MERGE_TEACH',true);\n";
  $_index_head=$_index_head."@define('TEACHING_PATH','matieres/matieres.php');\n";
  $_SESSION['menu_merge_td']=$_POST['menu_merge_td'];//empty or not
 }else{
  $_index_head=$_index_head."@define('MERGE_TEACH',false);\n";
  $_SESSION['menu_merge_td']='off';
 }

 if(isset($_POST['menu_cours_ok'])){
  //echo $_POST['menu_cours_ok'];
  $_SESSION['menu_cours_ok']=$_POST['menu_cours_ok'];//empty or not
  if($_SESSION['menu_merge_td']==='off'){
   $menuc=$menuc.",TEACHING";
   $menupc=$menupc.",TEACHING_PATH";
   $_index_head=$_index_head."@define('TEACHING_PATH','matieres/matieres.php');\n";
  }
 }else{$_SESSION['menu_cours_ok']='off';}

 if(isset($_POST['menu_td_ok'])){
  //echo $_POST['menu_td_ok'];
  $_SESSION['menu_td_ok']=$_POST['menu_td_ok'];//empty or not
  if($_SESSION['menu_merge_td']==='off'){
   $menuc=$menuc.",TD";
   $menupc=$menupc.",TD_PATH";
   $_index_head=$_index_head."@define('TD_PATH','matieres/matieres.php');\n";
  }
 }else{$_SESSION['menu_td_ok']='off';}

 if(isset($_POST['menu_cv_ok'])){
  //echo $_POST['menu_cv_ok'];
  $_SESSION['menu_cv_ok']=$_POST['menu_cv_ok'];//empty or not
  $menuc=$menuc.",CV";
  $menupc=$menupc.",CV_PATH";
  $_index_head=$_index_head."@define('CV_PATH','CV.php');\n";
 }else{$_SESSION['menu_cv_ok']='off';}

 if(isset($_POST['menu_merge_bib'])){
  //echo $_POST['menu_merge_bib'];
  $_SESSION['menu_merge_bib']=$_POST['menu_merge_bib'];//empty or not
  $menuc=$menuc.",BIBLIOGRAPHY";
  $menupc=$menupc.",BIBLIOGRAPHY_PATH";
  $_index_head=$_index_head."@define('BIBLIOGRAPHY_PATH','publication/Bibliographie.php');\n";
 }else{$_SESSION['menu_merge_bib']='off';}

 if(isset($_POST['menu_bib_ok'])){
  //echo $_POST['menu_bib_ok'];
  $_SESSION['menu_bib_ok']=$_POST['menu_bib_ok'];//empty or not
  if($_SESSION['menu_merge_bib']==='off'){
   $menuc=$menuc.",BIBLIOGRAPHY";
   $menupc=$menupc.",BIBLIOGRAPHY_PATH";
   $_index_head=$_index_head."@define('BIBLIOGRAPHY_PATH','publication/Bibliographie.php');\n";
  }
 }else{$_SESSION['menu_bib_ok']='off';}

 if(isset($_POST['menu_res_ok'])){
  //echo $_POST['menu_res_ok'];
  $_SESSION['menu_res_ok']=$_POST['menu_res_ok'];//empty or not
  if($_SESSION['menu_merge_bib']==='off'){
   $menuc=$menuc.",REF";
   $menupc=$menupc.",REF_PATH";
   $_index_head=$_index_head."@define('REF_PATH','publication/Ressources.php');\n";
  }
 }else{$_SESSION['menu_res_ok']='off';}
 $menuc=$menuc."];\n";
 $menupc=$menupc."];\n";
 $if_chain="if(defined('LANG') && constant('LANG')==='fr'){\n @define('HOME','Acceuil');\n @define('TEACHING','Cours');\n @define('TD','Td');\n @define('CV','Cv');\n @define('BIBLIOGRAPHY','Bibliographie');\n @define('REF','Ressources');\n }\n else if(defined('LANG') && constant('LANG')==='en'){\n @define('HOME','home');\n @define('TEACHING','Teaching');\n @define('TD','Td');\n @define('CV','CV');\n @define('BIBLIOGRAPHY','Bibliography');\n @define('REF','References');\n }\n else{\n echo 'language error';\n }\n";
 $_index_head=$_index_head.$if_chain;
 $_index_head=$_index_head.$menuc;
 $_index_head=$_index_head.$menupc;
 $_index_head=$_index_head."?>\n";
 $_SESSION['index_php_content']=$_index_head;
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                           *****Sauvegarde de homepage*****                                                                           ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function save_home(){
 if(isset($_FILES['img_home'])){
  if(file_upload_error('img_home')){
   $name=$_FILES['img_home']['name'];
   //echo $name." a eté utploadé";
   move_uploaded_file($_FILES['img_home']['tmp_name'], 'images/identity_tmp.png');
  }
 }
 $_SESSION['User_name']=$_POST['user_name'];
 $_SESSION['User_fname']=$_POST['user_first_name'];
 $_SESSION['User_role']=$_POST['user_role'];
 $_SESSION['home_content']="<DIV id='info'>\n<div id='id_mask'></div>";
 $_SESSION['home_content']=$_SESSION['home_content']."<div id='enc_title'>".ucwords($_SESSION['User_name'])." ".strtoupper($_SESSION['User_fname'])."<br />\n";
 $_SESSION['home_content']=$_SESSION['home_content'].ucwords($_SESSION['User_role'])."<br /><br /></div>\n";
 $_SESSION['home_content']=$_SESSION['home_content'].nl2br($_POST['enc_content'])."\n";
 $_SESSION['home_content']=$_SESSION['home_content']."</div>\n <div id='hometxt'>\n";
 $_SESSION['home_content']=$_SESSION['home_content']."<p>".nl2br($_POST['home_content'])."</p>\n</div>";
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                           *****Sauvegarde de matiere*****                                                                            ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function save_mat(){
 $td_t=array();
 $cours_t=array();
 $cpt=0;
 while(isset($_POST['t_cours'.$cpt]) && !empty($_POST['t_cours'.$cpt])){
  $cours_t[$cpt]="<type id=\"cours\">\n <titre>";
  $cours_t[$cpt]=$cours_t[$cpt].$_POST['t_cours'.$cpt];
  $cours_t[$cpt]=$cours_t[$cpt]."</titre>\n <contenu>";
  if(isset($_POST['c_cours'.$cpt])){
   $cours_t[$cpt]=$cours_t[$cpt].$_POST['c_cours'.$cpt];
   //echo $_POST['c_cours'.$cpt];
  }
  $cours_t[$cpt]=$cours_t[$cpt]."</contenu>\n";
  $cpt2=0;
  while(isset($_FILES['f_cours'.$cpt.$cpt2])){
   $cours_t[$cpt]=$cours_t[$cpt]."<fichier>";
   if(file_upload_error('f_cours'.$cpt.$cpt2)){ 
    $name=$_FILES['f_cours'.$cpt.$cpt2]['name'];
    $cours_t[$cpt]=$cours_t[$cpt]."matieres/cours/".$name;
    move_uploaded_file($_FILES['f_cours'.$cpt.$cpt2]['tmp_name'], 'matieres/cours/'.$name);
   }
   $cours_t[$cpt]=$cours_t[$cpt]."</fichier>\n";
   $cpt2++;
  }
  $cours_t[$cpt]=$cours_t[$cpt]."</type>\n";
  $cpt++;
 }
 $cpt=0;
 while(isset($_POST['t_td'.$cpt]) && !empty($_POST['t_td'.$cpt])){
  $td_t[$cpt]="<type id=\"td\">\n <titre>";
  $td_t[$cpt]=$td_t[$cpt].$_POST['t_td'.$cpt];
  //echo $_POST['t_td'.$cpt];
  $td_t[$cpt]=$td_t[$cpt]."</titre>\n <contenu>";
  if(isset($_POST['c_td'.$cpt])){
   $td_t[$cpt]=$td_t[$cpt].$_POST['c_td'.$cpt];
   //echo $_POST['c_td'.$cpt];
  }
  $td_t[$cpt]=$td_t[$cpt]."</contenu>\n";
  $cpt2=0;
  while(isset($_FILES['f_td'.$cpt.$cpt2])){
   $td_t[$cpt]=$td_t[$cpt]."<fichier>";
   if(file_upload_error('f_td'.$cpt.$cpt2)){
    $name=$_FILES['f_td'.$cpt.$cpt2]['name'];
    $td_t[$cpt]=$td_t[$cpt]."matieres/td/".$name;
    move_uploaded_file($_FILES['f_td'.$cpt.$cpt2]['tmp_name'], 'matieres/td/'.$name);
   }
   $td_t[$cpt]=$td_t[$cpt]."</fichier>\n";
   $cpt2++;
  }
  $td_t[$cpt]=$td_t[$cpt]."</type>\n";
  $cpt++;
 }
 $_SESSION['matiere_xml_content']="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n <matieres>\n ";
  for($i=0;$i<count($cours_t);$i++)
   $_SESSION['matiere_xml_content']=$_SESSION['matiere_xml_content'].$cours_t[$i];
  for($i=0;$i<count($td_t);$i++)
   $_SESSION['matiere_xml_content']=$_SESSION['matiere_xml_content'].$td_t[$i];
  $_SESSION['matiere_xml_content']=$_SESSION['matiere_xml_content']."</matieres>";
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                            *****Sauvegarde de biblio*****                                                                            ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function save_bib(){
 if(isset($_FILES['bib_m_file'])){
  if(file_upload_error('bib_m_file')){
   $name=$_FILES['bib_m_file']['name'];
   move_uploaded_file($_FILES['bib_m_file']['tmp_name'], 'publication/my/'.$name); 
   $_SESSION['my_bib_php_content']="<?php\n echo \"<DIV id='main_content'>\";\n \$_GET['bib']='publication/my/".$name."';\n \$_GET['all']=1;\n include('bibtexbrowser.php');\n echo '</DIV>';\n ?>\n"; 
  }
 }
 if(isset($_FILES['bib_p_file'])){
  if(file_upload_error('bib_p_file')){
   $name=$_FILES['bib_p_file']['name'];
   move_uploaded_file($_FILES['bib_p_file']['tmp_name'], 'publication/my/'.$name);
   $_SESSION['my_bib_php_content']="<?php\n echo \"<DIV id='main_content'>\";\n \$_GET['bib']='publication/my/".$name."';\n \$_GET['all']=1;\n include('bibtexbrowser.php');\n echo '</DIV>';\n ?>\n";  
  }
 }
 if(isset($_FILES['bib_r_file'])){
  if(file_upload_error('bib_r_file')){
   $name=$_FILES['bib_r_file']['name'];
   move_uploaded_file($_FILES['bib_r_file']['tmp_name'], 'publication/reco/'.$name);
   $_SESSION['res_bib_php_content']="<?php\n echo \"<DIV id='main_content'>\";\n \$_GET['bib']='publication/reco/".$name."';\n \$_GET['all']=1;\n include('bibtexbrowser.php');\n echo '</DIV>';\n ?>\n";  
  }
 }
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                           *****Sauvegarde de CV*****                                                                      ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
function save_cv(){
 $xp_t=array();
 $form_t=array();
 $cpt=0;
 while(isset($_POST['xp_date'.$cpt]) && !empty($_POST['xp_date'.$cpt])){
  $xp_t[$cpt]="<type id=\"xp\">\n <date>";
  $xp_t[$cpt]=$xp_t[$cpt].$_POST['xp_date'.$cpt];
  $xp_t[$cpt]=$xp_t[$cpt]."</date>\n <contenu>";
  if(isset($_POST['xp_cont'.$cpt])){
   $xp_t[$cpt]=$xp_t[$cpt].$_POST['xp_cont'.$cpt];
  }
  $xp_t[$cpt]=$xp_t[$cpt]."</contenu>\n </type>\n";
  $cpt++;
 }
 $cpt=0;
 while(isset($_POST['form_date'.$cpt]) && !empty($_POST['form_date'.$cpt])){
  $form_t[$cpt]="<type id=\"form\">\n <titre>";
  $form_t[$cpt]=$form_t[$cpt].$_POST['form_date'.$cpt];
  $form_t[$cpt]=$form_t[$cpt]."</titre>\n <contenu>";
  if(isset($_POST['form_cont'.$cpt])){
   $form_t[$cpt]=$form_t[$cpt].$_POST['form_cont'.$cpt];
  }
  $form_t[$cpt]=$form_t[$cpt]."</contenu>\n </type>\n";
  $cpt++;
 }
 $sub_content="<competences>".$_POST['comp']."</competences>\n";
 $sub_content=$sub_content."<keywords>".$_POST['keywords']."</keywords>\n";
 $sub_content=$sub_content."<hobby>".$_POST['hobby']."</hobby>\n";
 $sub_content=$sub_content."<language>".$_POST['lang']."</language>\n";
 $_SESSION['cv_xml_content']="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n <cv>\n ";
  for($i=0;$i<count($xp_t);$i++)
   $_SESSION['cv_xml_content']=$_SESSION['cv_xml_content'].$xp_t[$i];
  for($i=0;$i<count($form_t);$i++)
   $_SESSION['cv_xml_content']=$_SESSION['cv_xml_content'].$form_t[$i];
  $_SESSION['cv_xml_content']=$_SESSION['cv_xml_content'].$sub_content."</cv>";
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ***                                                                                                                                                                                                      ***
 ***                                                                                             *****Sitegen.php (main)*****                                                                             ***
 ***                                                                                                                                                                                                      ***
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
if(!isset($_SESSION)){
 session_start();
}
if(isset($_POST['menu_submit'])){
 save_config();
 gen_home_page();
}
else if(isset($_POST['home_submit'])){
 save_home();
 if($_SESSION['menu_cours_ok']==='on' ||$_SESSION['menu_td_ok']==='on' || $_SESSION['menu_merge_td']==='on'){
  gen_mat_page();
 }
 else if($_SESSION['menu_merge_bib']==='on' || $_SESSION['menu_bib_ok']==='on' || $_SESSION['menu_res_ok']==='on'){
  gen_bib_page();
 }
 else if($_SESSION['menu_cv_ok']==='on'){
  gen_cv_page();
 }
 else{
  gen_site();
 }
}
else if(isset($_POST['cours_TD_submit'])){
 save_mat();
 if($_SESSION['menu_merge_bib']==='on' || $_SESSION['menu_bib_ok']==='on' || $_SESSION['menu_res_ok']==='on'){
  gen_bib_page();
 }
 else if($_SESSION['menu_cv_ok']==='on'){
  gen_cv_page();
 }
 else{
  gen_site();
 }
}
else if(isset($_POST['bib_submit'])){
 save_bib();
 if($_SESSION['menu_cv_ok']==='on'){
  gen_cv_page();
 }
 else{
  gen_site();
 }
}
else if(isset($_POST['cv_submit'])){
 save_cv();
 gen_site();
}
else if(isset($_POST['suppr_submit']) && isset($_POST['sup']) && $_POST['sup']==='on'){
 echo "suppression des fichier locaux";
 $_SESSION = array(); 
 session_destroy();
 cleangen(); 
}
else{
 if(isset($_POST['suppr_submit']) && ((isset($_POST['sup']) && $_POST['sup']==='off') || !isset($_POST['sup']))){
  echo "<p>le générateur n'a pas été réinitialisé<br /> <font color='red'>Attention</font>,<br /> le site a été généré,<br /> toute rééxecution de ce script ecrasera les fichiers existants</p>";
 }
 gen_choice();
}
/************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************
 ************************************************************************************************************************************************************************************************************/
/**
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **
 **/
?>
</body>
</html>