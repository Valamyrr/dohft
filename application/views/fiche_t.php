<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DoH | Fiche Technique</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href='<?php echo base_url()?>application/css/fichetech.css'>
  </head>
  <body>
    <?php include('header.php');?>
    <div class="_container">
        <div class="_titre" align="center";>
          {pseudo}
        </div>
        <?php if($alter!=''){
          echo <<<_END
          <div class="_titre2">
            {alter}
          </div>
          <div class="_texte" id="_talter">
            Description Courte<br>
            <div class="_normalfont">{description}</div>
            Lien de la validation d'alter
            <div align="center" class="_normalfont">
              <a href='{link_alter}'>www</a>
            </div>
          </div>
_END;
        }?>

        <div class="_titre2">
          Rang
        </div>
        <div class="_texte" align="center">
          {rang}
        </div>
        <div class="_titre2">
          Spécialités
        </div>
        <table>
          <tr>
            <td>Polyvalence</td><td class="_somme">{poly}</td><td>Habileté</td><td class="_somme">{habi}</td><td>Négociation</td><td class="_somme">{nego}</td>
          </tr>
          <tr>
            <td>Puissance</td><td class="_somme">{puis}</td><td>Ingénierie</td><td class="_somme">{inge}</td><td>Résistance</td><td class="_somme">{resi}</td>
          </tr>
          <tr>
            <td>Contrôle</td><td class="_somme">{cont}</td><td>Analyse</td><td class="_somme">{anal}</td><td>Volonté</td><td class="_somme">{volo}</td>
          </tr>
          <tr>
            <td>Force</td><td class="_somme">{forc}</td><td>Médecine</td><td class="_somme">{mede}</td><td>Rapidité</td><td class="_somme">{rapi}</td>
          </tr>
          <tr>
            <td>Précision</td><td class="_somme">{prec}</td><td>Coordination</td><td class="_somme">{coor}</td><td></td><td></td>
          </tr>
          <tr>
            <td>Esquive</td><td class="_somme">{esqu}</td><td>Repérage</td><td class="_somme">{repe}</td><td></td><td></td>
          </tr>
          <tr>
            <td>Défense</td><td class="_somme">{defe}</td><td>Discrétion</td><td class="_somme">{disc}</td><td>Total dépensé</td><td><span id="_ptsomme">0</span></td>
          </tr>
        </table>
      </div><br>
      <?php
      if ($alter!=''){
        echo '
        <div class="_container">
          <div class="_titre" align="center";>
            Techniques d\'alter
          </div>';
        try{
          $bdd = new PDO("mysql:host=localhost;dbname=dohft;charset=utf8", 'cyril', 'Merlin528641397!*');
        }catch(Exception $e){
          die('Erreur : '.$e->getMessage());
        }
        $p=$_SESSION['pseudo'];
        $query = $bdd->query("SELECT s.nom, s.niveau, s.description, s.type  FROM users AS u, alters_skills AS s WHERE u.id = s.id_user AND u.pseudo = '$p' AND s.magique=1");

        while ($donnees = $query->fetch())
        {
          echo '
            <table>
              <tr>
                <td colspan="6" class="_titre2">'.$donnees['nom'].'</td>
              </tr>
              <tr>
                <td>Rang</td><td>'.$donnees['niveau'].'</td><td colspan="2">Alter</td><td colspan="2">'.$donnees['type'].'</td>
              </tr>
              <tr>
                <td colspan="6">'.$donnees['description'].'</td>
              </tr>
            </table>';
        }
        echo '</div>';
        $query->closeCursor();
      }?>
      <br>
      <div class="_container">
        <div class="_titre" align="center";>
          Techniques sans alter
        </div>
      
        <?php
          try{
            $bdd = new PDO("mysql:host=localhost;dbname=dohft;charset=utf8", 'cyril', 'Merlin528641397!*');
          }catch(Exception $e){
            die('Erreur : '.$e->getMessage());
          }
          $p=$_SESSION['pseudo'];
          $query = $bdd->query("SELECT s.nom, s.niveau, s.description, s.type  FROM users AS u, alters_skills AS s WHERE u.id = s.id_user AND u.pseudo = '$p' AND s.magique=0");

          while ($donnees = $query->fetch())
          {
            echo '
              <table>
                <tr>
                  <td colspan="6" class="_titre2">'.$donnees['nom'].'</td>
                </tr>
                <tr>
                  <td>Rang</td><td>'.$donnees['niveau'].'</td><td colspan="2">Alter</td><td colspan="2">'.$donnees['type'].'</td>
                </tr>
                <tr>
                  <td colspan="6">'.$donnees['description'].'</td>
                </tr>
              </table>';
          }
          $query->closeCursor();
        ?>
      </div>
      <script src="http://code.jquery.com/jquery.min.js"></script>
      <script src="<?php echo base_url()?>application/js/fichetech.js"></script>
  </body>
</html>
