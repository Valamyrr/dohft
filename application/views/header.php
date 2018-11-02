<nav class="navbar navbar-default" style="border-radius:0px !important">
  <ul class="nav navbar-nav">
    <?php
    $url = base_url();
    if(isset($_SESSION['pseudo'])){
      $url1= $_SESSION['link_pres'];
      $url2= "";
      $url3= "";
      $url4=$url."admin";
      echo <<<_END
        <li class="nav-item"><a class="nav-link" href="$url1">Présentation</a></li>
        <li class="nav-item"><a class="nav-link" href="$url2">Fiche Technique</a></li>
        <li class="nav-item"><a class="nav-link" href="$url3">Requêtes</a></li>
        <li class="nav-item"><a class="nav-link" href="$url">Accueil</a></li>
_END
      ;
      if($_SESSION['type']=='2'){
        echo <<<_END
        <li class="nav-item"><a class="nav-link" href="$url4">Administration</a></li>
_END
      ;}
    };
    ?>
  </ul>
  <ul class="nav navbar-nav navbar-right navbar-collapse" style="margin-right:15px;">
    <?php
    $url1=$url."connexion/deconnexion";
    if(isset($_SESSION['pseudo'])) {
      echo <<<_END
      <li class="nav-item">
        <a class="nav-link" href="$url1"> Se deconnecter</a>
      </li>
_END
    ;}else{
      $url1=$url."connexion/";
      $url2=$url."connexion/inscription";
      echo <<<_END
      <li class="nav-item">
        <a class="nav-link" href="$url1"> Se connecter</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="$url2"> S'inscrire</a>
      </li>
_END
    ;}
    ?>
  </ul>
</nav>
