<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	protected $table_whitelist = 'whitelist';
	protected $table_users = 'users';
	protected $table_variables = 'requetes_variables';
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
		$this->control();
	}

	private function control()
	{
		if(isset($_SESSION['pseudo'])){
			if($_SESSION['type']!=0){
				$this->control_priv();
			}else{
				$data['data']="Accès réservé è_é<br>";
				$this->load->view('accueil',$data);
			}
		}else{
			$data['data']="il n\'y a rien à voir ici... :/<br>";
			$this->load->view('accueil',$data);
		}
	}

	private function control_priv()
	{
		$this->db->select('pseudo')
						 ->where('type',2)
             ->get_compiled_select($this->table_users, FALSE);
		$admin = $this->db->get()->result_array();
		$this->db->select('pseudo')
						 ->where('type',1)
             ->get_compiled_select($this->table_users, FALSE);
		$modo = $this->db->get()->result_array();

		$nom_modo=[];$nom_admin=[];
		if (count($modo)==0){
			$error['modo']="Pas de modérateur...";
		}else{
			for ($i=0; $i <count($modo); $i++) {
				$nom_modo[]=$modo[$i]['pseudo'];
			}
		}
		for ($i=0; $i <count($admin); $i++) {
			$nom_admin[]=$admin[$i]['pseudo'];
		}

		$this->db->select('id')
             ->get_compiled_select($this->table_variables, FALSE);
		$spe=$this->db->get()->result_array();
		if (count($spe)==0){
			$error['spe']="Pas de requêtes de ce type...";
		}
		$this->db->select('id')
             ->get_compiled_select($this->table_tech, FALSE);
		$tech=$this->db->get()->result_array();
		if (count($tech)==0){
			$error['tech']="Pas de requêtes de ce type...";
		}
		$this->db->select('id')
             ->get_compiled_select($this->table_equip, FALSE);
		$equip=$this->db->get()->result_array();
		if (count($equip)==0){
			$error['equip']="Pas de requêtes de ce type...";
		}

		$data=array(
			"nom_modo"=>$nom_modo,
			"nom_admin"=>$nom_admin,
			"error"=>$error
		);
		$this->load->view('admin',$data);
	}

	public function action()
	{
		if(isset($_SESSION['pseudo'])){
			if($_SESSION['type']!=0){
				$this->load->model('securite');
				$p=$this->securite->xss_fix_string($_POST['pseudo']);
				if($p==''){
					echo 'Il manque quelque chose';
				}else{
					switch ($_POST['action']) {
						case "add_whitelist":
							$query = $this->db->query("SELECT pseudo_w FROM whitelist WHERE pseudo_w='$p' LIMIT 1");
							$row = $query->row();
							if(isset($row->pseudo_w)){
								echo $_POST['pseudo']." est déjà inscrit !";
							}else{
								$this->db->set('pseudo_w',$p);
								$this->db->insert($this->table_whitelist);
								echo $p." a été ajouté avec succès !";
							}
							break;
						case "rm_whitelist":
							$query = $this->db->query("SELECT pseudo_w FROM whitelist WHERE pseudo_w='$p' LIMIT 1");
							$row = $query->row();
							if(!isset($row->pseudo_w)){
								echo $_POST['pseudo']." n'est pas dans la whitelist !";
							}else{
								$query = $this->db->query("DELETE FROM whitelist WHERE pseudo_w='$p'");
								echo $_POST['pseudo']." a été supprimé de la whitelist.";
							}
							break;
						case "find_whitelist":
							$query = $this->db->query("SELECT pseudo_w FROM whitelist WHERE pseudo_w='$p' LIMIT 1");
							$row = $query->row();
							if(isset($row->pseudo_w)){
								echo $p." est bien dans la whitelist.";
							}else{
								echo $p." n'est pas inscrit dans la whitelist.";
							}
							break;
						case "special":
							$query = $this->db->query("SELECT u.pseudo, s.id_user, u.id FROM users AS u, specialites AS s WHERE u.pseudo='$p' AND u.id=s.id_user LIMIT 1");
							$row = $query->row();
							if(isset($row->pseudo)){
								$this->db->set($_POST['special'], $_POST['val']);
								$this->db->where('id', $row->id_user);
								$this->db->update($this->table_specialites);
								echo "Fiche Technique mise à jour.";
							}else{
								echo $p." n'a pas de fiche technique ou n'existe pas.";
							}
							break;
						case "rm_special":
							$i=$_POST['id'];
							$query = $this->db->query("DELETE FROM requetes_variables WHERE id='$i' LIMIT 1");
							echo "Effacée !";
							break;
						case "ok_special":
							$i=$_POST['id'];
							$what = $this->db->query("SELECT val_new,val_name FROM requetes_variables WHERE id='$i' LIMIT 1");
							$who = $this->db->query("SELECT u.pseudo, s.id_user, u.id FROM users AS u, specialites AS s WHERE u.pseudo='$p' AND u.id=s.id_user LIMIT 1");
							$this->db->set($what->row()->val_name,$what->row()->val_new);
							$this->db->where('id_user', $who->row()->id);
							$this->db->update($this->table_specialites);
							$query = $this->db->query("DELETE FROM requetes_variables WHERE id='$i' LIMIT 1");
							echo "Traitée !";
							break;
						case "membre":
							if($_SESSION['type']==2){
								$this->db->set('type', 0);
								$this->db->where('pseudo', $p);
								$this->db->update($this->table_users);
								echo $p." est redevenu simple membre !";
							}else{
								echo "Tu n'es pas admin.";
							}
							break;
						case "moderateur":
							if($_SESSION['type']==2){
								$this->db->set('type', 1);
								$this->db->where('pseudo', $p);
								$this->db->update($this->table_users);
								echo $p." a évolué en modérateur !";
							}else{
								echo "Tu n'es pas admin.";
							}
							break;
						case "administrateur":
							if($_SESSION['type']==2){
								$this->db->set('type', 2);
								$this->db->where('pseudo', $p);
								$this->db->update($this->table_users);
								echo $p." a rejoint les dieux !";
							}else{
								echo "Tu n'es pas admin.";
							}
							break;
						case "export":
							if($_SESSION['type']==2){
								$prefs = array(
									'tables'    => array('users','specialites','alters_skills','equipements_skills'),
								  'ignore'    => array(),
								  'format'    => 'txt',
								  'add_drop'  => TRUE,
								  'add_insert'=> TRUE,
								  'newline'   => "\n"
								);
								$this->load->dbutil();
								$backup = $this->dbutil->backup($prefs);

								$this->load->helper('download');
								force_download('mybackup.sql', $backup, TRUE);
								echo "Downloaded !";
							}else{
								echo "Tu n'es pas admin.";
							}
							break;
					  default:
					  	echo "Erreur !";
					}
				}
			}else{
				$this->index();
			}
		}else{
			$this->index();
		}
	}
}
