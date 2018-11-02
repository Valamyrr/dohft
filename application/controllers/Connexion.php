<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Connexion extends CI_Controller {

  private $connected;

	public function __construct()
	{
		parent::__construct();
    $this->load->model('connexions');
    $this->load->helper('form');
	}

	public function index()
	{
		$this->connexion();
	}

  public function deconnexion()
  {
    if(isset($_SESSION['pseudo'])){
      $_SESSION=array();
      session_destroy();
      $data['data']="Déconnexion Réussie !<br>";
      $this->load->view('accueil',$data);
    }else{
      $this->connexion();
    }

  }

  public function connexion()
  {
    if(isset($_SESSION['pseudo'])){
      $this->load->view('accueil');
    }else{
      $this->load->view('connexion');
    }
  }

  public function ajax_conn()
  {
    $data=array(
      'pseudo'=>$_POST['pseudo'],
      'mdp'=>$_POST['mdp']
    );
    if($this->connexions->connexion_bdd($data)){
      $p=$_POST['pseudo'];
      $query = $this->db->query("SELECT type,link_alter,link_prez FROM users WHERE pseudo='".$p."' LIMIT 1");
      $row = $query->row();
      //session_start();
      $_SESSION=array(
        "pseudo" => $p,
        "link_alter"=> $row->link_alter,
        "link_pres"=>$row->link_prez,
        "type"=>$row->type
      );
      $data['data']="Connexion Réussie !<br>";
      $this->load->view('accueil',$data);
    }else{
      $error['error'] = "Pseudo ou mot de passe incorrect...<br><br>";
      $this->load->view('connexion',$error);
    }
  }

  public function inscription()
  {
    if(isset($_SESSION['pseudo'])){
      $this->load->view('accueil');
    }else{
      $this->load->view('inscription');
    }
  }

  public function ajax_insc()
  {
    $this->load->libarary('securite');
    $data=array(
      'pseudo' => $this->securite->xss_fix_string($_POST['pseudo']),
      'pseudo'=>$this->securite->xss_fix_string($_POST['pseudo']),
      'mdp'=>$this->securite->xss_fix_string($_POST['mdp']),
      'link_pres'=>$this->securite->xss_fix_string($_POST['link_pres']),
      'link_alter'=>$this->securite->xss_fix_string($_POST['link_alter']),
      'email'=>$this->securite->xss_fix_string($_POST['email']),
      'nom_alter'=>$this->securite->xss_fix_string($_POST['nom_alter']),
      'desc_alter'=>$this->securite->xss_fix_string($_POST['desc_alter']),
      'rang'=>$this->securite->xss_fix_string($_POST['rang'])
    );
    if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
      if($this->connexions->inscription_bdd($data)){
        $data['data']="Inscription Réussie !<br>";
        $this->load->view('accueil',$data);
        $this->load->model('mail');
        $this->mail->mail_inscription($data['pseudo'],$data['email'],$data['mdp']);
      }else{
        $error['error'] = "Votre compte existe déjà ou vous n'êtes pas sur la whitelist.<br><br>";
        $this->load->view('inscription',$error);
      }
    }else{
      $error['error'] = "<span style='color:red'>Mail invalide.</span><br><br>";
      $this->load->view('inscription',$error);
    }
  }
}
