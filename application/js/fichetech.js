$(function(){
  let somme=0;
  $("._somme").each(function(index) {
    somme+=parseInt($(this).html());
  });
  $('#_ptsomme').html(somme);
})
