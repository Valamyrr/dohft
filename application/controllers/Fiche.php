<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fiche extends CI_Controller {

	protected $table_users = 'users';
	protected $table_specialites = 'specialites';
	protected $table_tech = 'alters_skills';
	protected $table_equip = 'equipements_skills';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

  public function index()
  {
		$this->load->library('parser');
		$p=$_SESSION['pseudo'];
		$query = $this->db->query("SELECT * FROM specialites AS s, users AS u WHERE u.pseudo='$p' AND s.id_user=u.id LIMIT 1");
		$row = $query->row();
		$data=array(
			'pseudo'=>$row->pseudo,
			'rang'=>$row->rang,
			'link_alter'=>$row->link_alter,
			'alter'=>$row->pouvoir,
			'description'=>$row->description_alter,
			'poly'=>$row->polyvalence,
			'puis'=>$row->puissance,
			'cont'=>$row->controle,
			'forc'=>$row->strength,
			'prec'=>$row->accuracy,
			'esqu'=>$row->esquive,
			'defe'=>$row->defense,
			'habi'=>$row->habilete,
			'inge'=>$row->ingenierie,
			'anal'=>$row->analyse,
			'mede'=>$row->medecine,
			'coor'=>$row->coordination,
			'repe'=>$row->reperage,
			'disc'=>$row->discretion,
			'nego'=>$row->negociation,
			'resi'=>$row->resistance,
			'volo'=>$row->volonte,
			'rapi'=>$row->rapidite
		);
    $this->parser->parse('fiche_t',$data);
  }

	public function dump()
	{
		$this->load->view("accueil");
		$p=$_SESSION['pseudo'];
		$query = $this->db->query("SELECT * FROM specialites AS s, users AS u WHERE u.pseudo='$p' AND s.id_user=u.id LIMIT 1");
		$row = $query->row();
		var_dump($query->row());
	}

}
