<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelchkuser extends CI_Model
{
	function __construct(){
        $_POST = json_decode(file_get_contents('php://input'), true);
	}
	function chkAuthName(){
        $password=$_POST['password1'];
        $userName=$_POST['username1'];
        $ipadress =$_SERVER['REMOTE_ADDR'];
        $sessionId=session_id();
        //echo "call getLogin('$userName','$password','$ipadress','$sessionId')";
		$query =$this->db->query("call getLogin('$userName','$password','$ipadress','$sessionId')");
        $res = $query->result_array();
        $query->next_result();
        $query->free_result();
        $resultData=$res[0];
        //print_r($resultData);
        //die();
        if($res[0]['iType']==0){

            $session_data = array('type' => $res[0]['usetype'],'user_name' 	=> $res[0]['mstruserid'],'user_id' => $res[0]['mstrid'],'last_login_id' => $res[0]['LID'],'session_id' =>session_id(),'changePass'=>$res[0]['ChangePas'],'set_timeout'=>$res[0]['set_timeout']);
            $this->session->set_userdata($session_data);
            return $resultData;

        }else{
            return $resultData;
        }
	}
	function logoutentry(){
		//print_r($_POST);die();
			$GetStatus=$this->getUserstatus($_POST['userId']);
			$this->db->trans_start();
		    $logoutdata = array('logendt' => date('Y-m-d H:i:s',now()),	'online'  => 0);
        	$this->db->where('logcode', $_POST['lastLogin']);
		    $this->db->where('session_id', $_POST['sessionId']);
		    $query=$this->db->update('userlogged', $logoutdata);
		    $this->db->trans_complete();
		    return $query;
	}
	function chkLoginStatus($userId){
		$this->db->select('loginstatus,lgnusrCloseAc,mstrlock');
		$this->db->from('createmaster');
		$this->db->where('mstrid', $userId);
		$query = $this->db->get();
        return $query->result_array();
		
	}
	function getUserstatus($userId){
		$this->db->select('loginstatus');
		$this->db->from('createmaster');
		$this->db->where('mstrid', $userId);
		$query = $this->db->get();
	}
	
}
