<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DoH | Inscription</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <?php include('header.php');?>
    <div class="col-lg-12 col-sm-12 main"> <!-- Container -->
      <div class="raw">
        <div class="col-lg-4 col-lg-push-4 col-sm-10 col-sm-push-1">
          <?php $att=array('class'=>'form-horizontal','role'=>'form', 'method'=>'post');?>
          <?php echo form_open('#', $att);?>
            <fieldset>
            <legend>Inscription</legend>
            <?php if(isset($error)) echo $error; ?>
            <div class="form-group">
              <label class="col-md-4 control-label" for="pseudo">Pseudo</label>
              <div class="col-md-4">
              <input id="pseudo" name="pseudo" type="text" placeholder="All Might" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="mdp">Mot de passe</label>
              <div class="col-md-4">
                <input id="mdp" name="mdp" type="password" placeholder="********" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="link_pres">Lien présentation</label>
              <div class="col-md-4">
              <input id="link_pres" name="link_pres" type="text" placeholder="www" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="link_alter">Lien alter</label>
              <div class="col-md-4">
              <input id="link_alter" name="link_alter" type="text" placeholder="www" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="email">Email</label>
              <div class="col-md-4">
              <input id="email" name="email" type="text" placeholder="chatmignon75@wanadoo.fr" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="rang">Rang</label>
              <div class="col-md-4">
                <select id="rang" name="rang" class="form-control">
                  <option value="C">C</option>
                  <option value="B">B</option>
                  <option value="A">A</option>
                  <option value="S">S</option>
                  <option value="X">X</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="nom_alter">Nom alter</label>
              <div class="col-md-4">
              <input id="nom_alter" name="nom_alter" type="text" placeholder="One For All" class="form-control input-md">
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="desc_alter">Description Alter</label>
              <div class="col-md-4">
                <textarea class="form-control" id="desc_alter" name="desc_alter" style="min-height:200px;">Plus Ultra !</textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label" for="submit"></label>
              <div class="col-md-4">
                <button id="submit" name="submit" class="btn btn-info">Link Start !</button>
              </div>
            </div>

            </fieldset>
          </form>
        </div>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript">
      $(function(){
        $('#submit').click(function(e){
          e.preventDefault();
          let pseudo = encodeURIComponent($('#pseudo').val());
          let mdp = encodeURIComponent($('#mdp').val());
          let link_pres = encodeURIComponent($('#link_pres').val());
          let link_alter = encodeURIComponent($('#link_alter').val());
          let email = $('#email').val();
          let nom_alter = encodeURIComponent($('#nom_alter').val());
          let desc_alter = encodeURIComponent($('#desc_alter').html());
          let rang = encodeURIComponent($('#rang').val());
          if(pseudo != "" && mdp != "" && link_pres!="" && email!=""){
            let donn='pseudo='+pseudo+'&mdp='+mdp+'&link_pres='+link_pres+'&link_alter='+link_alter+'&email='+email+'&nom_alter='+nom_alter+'&desc_alter='+desc_alter+'&rang='+rang;
            $.ajax({
              type: 'POST',
              data: donn,
              url: '<?php echo base_url()?>connexion/ajax_insc',
              success: function(data) {
                $('body').html(data);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                alert('La requête a échoué : '+xhr.status+' '+thrownError);
              }
            });
          }else{
            alert('Veuillez remplir tous les champs.');
          }
        })
      })
    </script>

  </body>
</html>
