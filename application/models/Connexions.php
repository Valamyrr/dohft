<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Connexions extends CI_Model
{
  protected $table = 'users';

  public function __construct()
  {
    parent::__construct();
    $this->load->model('securite');
    $this->load->database();
  }

  public function connexion_bdd($data)
  {
    $p=$this->securite->xss_fix_string($data['pseudo']);
    $query = $this->db->query("SELECT mdp FROM users WHERE pseudo='$p' LIMIT 1");
    $row = $query->row();

    if ($query->result_id->num_rows==null){return false;}

    if($row->mdp == $this->securite->encode_password($data['mdp'])){
      return true;
    }else{
      return false;
    }
  }

  public function inscription_bdd($data)

  {
    $d=$data['pseudo'];
    $query = $this->db->query("SELECT pseudo FROM users WHERE pseudo='$d' LIMIT 1");
    foreach ($query->result() as $row)
    {
            echo $row->title;
    }
    $row = $query->row();
    if(isset($row->pseudo)){return false;}

    $query = $this->db->query("SELECT pseudo_w FROM whitelist WHERE pseudo_w='$d' LIMIT 1");
    $row = $query->row();
    if(!isset($row->pseudo)){return false;}

    $this->load->helper('text');

    $pseudo = $data['pseudo'];
    $email = $data['email'];
    $mdp = $this->securite->encode_password($data['mdp']);
    $link_pres = $data['link_pres'];
    $link_alter = $data['link_alter'];
    $nom_alter = $data['nom_alter'];
    $rang = $data['rang'];
    $desc_alter= character_limiter($data['desc_alter'],255);

    $this->db->set('pseudo', $pseudo);
    $this->db->set('mdp', $mdp);
    $this->db->set('email', $email);
    $this->db->set('link_prez', $link_pres);
    $this->db->set('link_alter', $link_alter);
    $this->db->set('pouvoir', $nom_alter);
    $this->db->set('rang',$rang);
    $this->db->set('description_alter',$desc_alter);

		return $this->db->insert($this->table);
  }
}
