<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Securite extends CI_Model
{

  public function __construct()
 	{
 		parent::__construct();
    $this->load->helper('security');
 	}

  public function mysql_entities_fix_string($conn,$str)
  {
    return htmlentities(mysql_fix_string($conn,$string));
  }

  public function mysqli_fix_string($conn,$str)
  {
    if(get_magic_quotes_gpc()){$string = stripslashes($string);}
    return $conn->mysqli_real_escape_string($string);
  }

  public function xss_fix_string($str)
  {
    $this->load->helper('text');
    return convert_accented_characters(htmlentities($this->security->xss_clean($str)));
  }

  public function true_security($conn,$str)
  {
    return xss_fix_string(mysqli_fix_string($conn,$str));
  }

  public function security_fix_filename($str)
  {
    return $this->security->sanitize_filename($str);
  }

  public function encode_password($password)
  {
    return 'ueS'.do_hash($password).'9Otha';
  }
}

/* End of file security.php */
/* Location: ./application/models/security.php */
