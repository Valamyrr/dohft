<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DoH | Connexion</title>
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
              <legend>Connexion</legend>
              <?php if(isset($error)) echo $error; ?>
              <div class="form-group">
                <label class="col-md-4 control-label" for="pseudo">Pseudo</label>
                <div class="col-md-4">
                <input id="pseudo" name="pseudo" type="text" placeholder="John Doe" class="form-control input-md">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="mdp">Mot de passe</label>
                <div class="col-md-4">
                  <input id="mdp" name="mdp" type="password" class="form-control input-md">
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
          let pseudo = encodeURIComponent($('#pseudo').val()); //On vérifie les string
          let mdp = encodeURIComponent($('#mdp').val());
          if(pseudo != "" && mdp != ""){
            let donn='pseudo='+pseudo+'&mdp='+mdp;
            $.ajax({
              type: 'POST',
              data: donn,
              url: '<?php echo base_url()?>connexion/ajax_conn',
              success: function(data) {
                $('body').html(data);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                alert('La requête a échoué : '+xhr.status+' '+thrownError);
              }
            });
          }else{
            alert('Veuillez remplir les champs');
          }
        })
      })
    </script>

  </body>
</html>
