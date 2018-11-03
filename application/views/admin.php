<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DoH | Administration</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!--
    CSS
-->
    <style type="text/css">

    .onglet{ /* Les petits boutons en haut */
      display: inline-block;
      width: 130px;
      background-color: #4DAF7C;
      border:solid 1px green;
      cursor: pointer;
      margin-bottom:8px;
      margin-top: 2px
    }
    .contenu{ /* Assez explicite : les boîtes qui vont changer */
      border-radius : 20px;
      border: 5px solid #4DAF7C;
      border-left: 10px solid #4DAF7C;
      border-right: 10px solid #4DAF7C;
      padding: 10px;
      display:none;
      height : 600px;
      width : 800px;
      overflow : auto;
    }

textarea{
  width: 500px;
  height: 200px;
}

@media(max-width: 786px){
  .contenu{
    height: 450px;
    width : 300px
  }
}
    </style>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="onglets">
      <div align="center">
        <div class="onglet" id="1">Whitelist</div>
        <div class="onglet" id="2">Objets Héroïques</div>
        <div class="onglet" id="3">Spécialités</div>
        <div class="onglet" id="4">Techniques</div>
        <?php
        if($_SESSION['type']=='2'){
          echo <<<_END
          <div class="onglet" id="5">Staff</div>
          <div class="onglet" id="6">Exporter</div>
_END
        ;}
        ?>

      </div>
    </div>

    <center>
      <div class="contenu" id="contenu_0">
        <p>Bienvenue sur le panneau d'administration !</p>
      </div>
      <div class="contenu" id="contenu_1">
        <table style="border-spacing:5px;border-collapse:separate;">
          <tr>
            <td><label for="add_whitelist">Ajouter : </label></td>
            <td><input name="add_whitelist" id="add_whitelist" type="text"></td>
            <td><button id="c_add_whitelist">Ok</button></td>
          </tr>
          <tr>
            <td><label for="rm_whitelist">Supprimer : </label></td>
            <td><input name="rm_whitelist" id="rm_whitelist" type="text"></td>
            <td><button id="c_rm_whitelist">Ok</button></td>
          </tr>
          <tr>
            <td><label for="find_whitelist">Chercher : </label></td>
            <td><input name="find_whitelist" id="find_whitelist" type="text"></td>
            <td><button id="c_find_whitelist">Ok</button></td>
          </tr>
        </table>
        <div id="whitelist_answer"></div>
      </div>
      <div class="contenu" id="contenu_2">
        <div id="equip_answer"></div>
        <br>
        <?php
        if(isset($error['equip'])){
          echo $error['equip'];
        }else{
          try{
      			$bdd = new PDO("mysql:host=localhost;dbname=dohft;charset=utf8", 'cyril', 'Merlin528641397!*');
      		}catch(Exception $e){
      			die('Erreur : '.$e->getMessage());
      		}
      		$query = $bdd->query('SELECT es.id, u.pseudo, es.nom, es.niveau, es.description, es.type  FROM users AS u, equipements_skills AS es WHERE u.id = es.id_user AND es.etat=0 ORDER BY es.id');

          while ($donnees = $query->fetch())
          {
            echo '<div class="list-group-item details" id="equip_'.$donnees['pseudo'].$donnees['id'].'">
                    Demande de '.$donnees['pseudo'].' : '.$donnees['nom'].' ('.$donnees['type'].' de niveau '.$donnees['niveau'].')
                    <br>'. $donnees['description'] . '<br>
                    <div class="btn btn-xs btn-danger rm_equip"><span class="glyphicon glyphicon-trash"></span> Refuser</div>
                    <div class="btn btn-xs btn-success ok_equip"><span class="glyphicon glyphicon-wrench"></span> Confirmer</div>
                  </div>';
          }
          $query->closeCursor();

        }
        ?>
      </div>
      <div class="contenu" id="contenu_3">
        <table style="border-spacing:5px;border-collapse:separate;">
          <tr>
            <td><label for="nom_special">Nom : </label></td>
            <td><input name="nom_special" id="nom_special" type="text"></td>
          </tr>
          <tr>
            <td><label for="special_special">Spécialité : </label></td>
            <td><select name="special_special" id="special_special" type="text">
              <option value="polyvalence">polyvalence</option>
              <option value="puissance">puissance</option>
              <option value="controle">controle</option>
              <option value="strength">force</option>
              <option value="accuracy">précision</option>
              <option value="esquive">esquive</option>
              <option value="defense">defense</option>
              <option value="habilete">habileté</option>
              <option value="ingenierie">ingénierie</option>
              <option value="analyse">analyse</option>
              <option value="medecine">médecine</option>
              <option value="coordination">coordination</option>
              <option value="reperage">repérage</option>
              <option value="discretion">discrétion</option>
              <option value="negociation">négociation</option>
              <option value="resistance">résistance</option>
              <option value="volonte">volonté</option>
              <option value="rapidite">rapidité</option>
            </select></td>
          </tr>
          <tr>
            <td><label for="val_special">Valeur : </label></td>
            <td><input name="val_special" id="val_special" type="text"></td>
          </tr>
          <tr>
            <td colspan="2"><button id="c_special">Ok</button></td>
          </tr>
        </table><br>
        <div id="special_answer"></div>
        <br>
        <?php
        if(isset($error['spe'])){
          echo $error['spe'];
        }else{
          try{
      			$bdd = new PDO("mysql:host=localhost;dbname=dohft;charset=utf8", 'cyril', 'Merlin528641397!*');
      		}catch(Exception $e){
      			die('Erreur : '.$e->getMessage());
      		}
      		$query = $bdd->query('SELECT rv.id, u.pseudo, rv.explication, rv.val_new, rv.val_name  FROM users AS u, requetes_variables AS rv WHERE u.id = rv.id_user ORDER BY rv.id');

          while ($donnees = $query->fetch())
          {
            echo '<div class="list-group-item details" id="spe_'.$donnees['pseudo'].$donnees['id'].'">
                    Demande de '.$donnees['pseudo'].' : '.$donnees['val_name'].' -> '.$donnees['val_new'].'
                    <br>'. $donnees['explication'] . '<br>
                    <div class="btn btn-xs btn-danger rm_special"><span class="glyphicon glyphicon-trash"></span> Refuser</div>
                    <div class="btn btn-xs btn-success ok_special"><span class="glyphicon glyphicon-wrench"></span> Confirmer</div>
                  </div>';
          }
          $query->closeCursor();

        }
        ?>
      </div>
      <div class="contenu" id="contenu_4">
        <div id="tech_answer"></div>
        <br>
        <?php
        if(isset($error['tech'])){
          echo $error['tech'];
        }else{
          try{
      			$bdd = new PDO("mysql:host=localhost;dbname=dohft;charset=utf8", 'cyril', 'Merlin528641397!*');
      		}catch(Exception $e){
      			die('Erreur : '.$e->getMessage());
      		}
      		$query = $bdd->query('SELECT es.id, u.pseudo, es.nom, es.niveau, es.description, es.type  FROM users AS u, equipements_skills AS es WHERE u.id = es.id_user AND es.etat=0 ORDER BY es.id');

          while ($donnees = $query->fetch())
          {
            echo '<div class="list-group-item details" id="tech_'.$donnees['pseudo'].$donnees['id'].'">
                    Demande de '.$donnees['pseudo'].' : '.$donnees['nom'].' ('.$donnees['type'].' de niveau '.$donnees['niveau'].')
                    <br>'. $donnees['description'] . '<br>
                    <div class="btn btn-xs btn-danger rm_tech"><span class="glyphicon glyphicon-trash"></span> Refuser</div>
                    <div class="btn btn-xs btn-success ok_tech"><span class="glyphicon glyphicon-wrench"></span> Confirmer</div>
                  </div>';
          }
          $query->closeCursor();

        }
        ?>
      </div>
      <?php
      if($_SESSION['type']=='2'){
        echo <<<_END
        <div class="contenu" id="contenu_5">
          <table style="border-spacing:5px;border-collapse:separate;">
            <tr>
              <td><label for="membre">Membre : </label></td>
              <td><input name="membre" id="membre" type="text"></td>
              <td><button id="c_membre">Ok</button></td>
            </tr>
            <tr>
              <td><label for="moderateuradministrateur">Modérateur : </label></td>
              <td><input name="moderateur" id="moderateur" type="text"></td>
              <td><button id="c_moderateur">Ok</button></td>
            </tr>
            <tr>
              <td><label for="administrateur">Administrateur : </label></td>
              <td><input name="administrateur" id="administrateur" type="text"></td>
              <td><button id="c_administrateur">Ok</button></td>
            </tr>
          </table>
          <div id="staff_answer"></div>
          <br>
          <b>Modérateurs :</b><br>
_END;
        if(isset($error['modo'])){
          echo $error['modo']."<br>";
        }else{
          foreach ($nom_modo as $key) {
            echo "$key<br>";
          }
        }
        echo"<b>Administrateurs :</b><br>";
        foreach ($nom_admin as $key) {
          echo "$key<br>";
        }
        echo <<<_END
        </div>
        <div class="contenu" id="contenu_6">
          <button id="c_export">Récupérer BDD</button><br><br>
          <textarea id="export_answer"></textarea>
        </div>
_END;
      }?>


    </center>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
      let ancre = '0';
      /*$('#1').css({ //Propriétés de la position par défaut si différent de 0
        'display':'inline-block',
        'background-color':'green',
        'border':'solid 1px green'
      })*/
      change_onglet(ancre);
      $('.onglet').on('click',function(){
        $('.onglet').css('background-color','#4DAF7C')
        $(this).css({
          'display':'inline-block',
          'background-color':'green',
          'border':'solid 1px green'
        })
        change_onglet(this.id)
      })
      function change_onglet(active){
      	document.getElementById('contenu_'+ancre).style.display = 'none';
      	document.getElementById('contenu_'+active).style.display = 'block';
      	ancre = active;
      }
    </script>
    <script type="text/javascript">
      $(function(){
        function ajax_admin(donn,action,cible){
          $.ajax({
            type: 'POST',
            data: donn+"&action="+action,
            url: '<?php echo base_url()?>admin/action',
            success: function(data) {
              cible.html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
              alert('La requête a échoué : '+xhr.status+' '+thrownError);
            }
          });
        }
        $("#c_add_whitelist").on('click',function(){
          let pseudo = encodeURIComponent($('#add_whitelist').val());
          ajax_admin("pseudo="+pseudo,"add_whitelist",$('#whitelist_answer'));
        })
        $("#c_rm_whitelist").on('click',function(){
          let pseudo = encodeURIComponent($('#rm_whitelist').val());
          ajax_admin("pseudo="+pseudo,"rm_whitelist",$('#whitelist_answer'));
        })
        $("#c_find_whitelist").on('click',function(){
          let pseudo = encodeURIComponent($('#find_whitelist').val());
          ajax_admin("pseudo="+pseudo,"find_whitelist",$('#whitelist_answer'));
        })
        $("#c_special").on('click',function(){
          let pseudo = encodeURIComponent($('#nom_special').val());
          let special = encodeURIComponent($('#special_special').val());
          let val = encodeURIComponent($('#val_special').val());
          ajax_admin("pseudo="+pseudo+"&special="+special+"&val="+val,"special",$('#special_answer'));
        })
        function truncate(string,int){
          var string2="";var string3="";
          for(var i=int; i<string.length; i++){string2+=string[i]};
          i=0;string="";
          while(isNaN(parseInt(string2[i]))){string+=string2[i];i++}
          for(i; i<string2.length;i++){string3+=string2[i]};
          return[string,string3];
        }
        $('.rm_special').on('click',function(){
          let id=this.parentElement.id;
          let res=truncate(id,4);
          pseudo=res[0];id=res[1];
          ajax_admin("pseudo="+pseudo+"&id="+id,"rm_special",$('#special_answer'));
          this.parentElement.style="display:none";
        })
        $('.ok_special').on('click',function(){
          let id=this.parentElement.id;
          let res=truncate(id,4);
          pseudo=res[0];id=res[1];
          ajax_admin("pseudo="+pseudo+"&id="+id,"ok_special",$('#special_answer'));
          this.parentElement.style="display:none";
        })
        <?php
        if($_SESSION['type']=='2'){
          echo <<<_END
        $("#c_membre").on('click',function(){
          let pseudo = encodeURIComponent($('#membre').val());
          ajax_admin("pseudo="+pseudo,"membre",$('#staff_answer'));
        })
        $("#c_moderateur").on('click',function(){
          let pseudo = encodeURIComponent($('#moderateur').val());
          ajax_admin("pseudo="+pseudo,"moderateur",$('#staff_answer'));
        })
        $("#c_administrateur").on('click',function(){
          let pseudo = encodeURIComponent($('#administrateur').val());
          ajax_admin("pseudo="+pseudo,"administrateur",$('#staff_answer'));
        })
        $("#c_administrateur").on('click',function(){
          let pseudo = encodeURIComponent($('#administrateur').val());
          ajax_admin("pseudo="+pseudo,"administrateur",$('#staff_answer'));
        })
        $("#c_export").on('click',function(){
          ajax_admin("pseudo=' '","export",$('#export_answer'));
        })
_END;
}?>
      })
    </script>
  </body>
</html>
