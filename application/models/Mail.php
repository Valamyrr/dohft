<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Model {

	private $user;
	private $mail;
	private $mdp;
	private $sujet;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	public function mail_inscription($user,$mail,$mdp)
	{
		$this->email->from('cy.thuillier@gmail.com', 'DawnOfHeroes');
		$this->email->to(array($mail));

		$this->email->subject('Dawn Of Heroes FT - Bienvenue');

		$str=<<<END
		<center>
		<div style="border:solid 1px black;width:500px;height:300px;text-align:center;padding:10px;">
			<h3>Re-Bienvenue sur Dawn Of Heroes !</h3>
			<p>Bonjour $user,
				<br><br>Vous recevez ce mail automatiquement parce que vous vous êtes inscrit sur DawnOfHeroesFT, avec les identifiants suivants :
				<br><br>Utilisateur : $mail
				<br>Mot de passe : $mdp
				<br><br>Si vous ne savez pas pourquoi vous recevez ce mail, il se peut que quelqu'un ait utilisé votre e-mail. Auquel cas, il n'est pas nécessaire de se soucier de ce mail.
				<br><br>Bien à vous,
				<br>Le staff de DoH.
			</p>
		</div>
		</center>
END;

		$this->email->message($str);

		$this->email->send();
		return true;
	}

	public function mail_contact($mail,$sujet,$contenu)
	{
		$this->email->from('cy.thuillier@gmail.com', 'Contact');
		$this->email->to(array('cy.thuillier@gmail.com'));
		$this->email->cc(array($mail));

		$this->email->subject('DoH - Besoin d\'aide');

		$this->load->helper('text');
		$contenu = character_limiter($contenu, 400);
		$str=<<<_END
		<center>
		<div style="border:solid 1px black;width:500px;height:300px;text-align:center;padding:10px;">
			<h3>$sujet</h3>
			<p>
				$contenu
			</p>
		</div>
		</center>
_END;

		$this->email->message($str);
		$this->email->send();
		return true;
	}

}
