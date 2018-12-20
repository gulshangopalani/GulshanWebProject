<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modelcreatemaster extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$_POST = json_decode(file_get_contents('php://input'), true);
	}
	function changePassword(){
		$old_password=sha1($_POST['old_password']);
		$this->db->select('mstrpassword as usepass');
		$this->db->from('createmaster');
		$this->db->where('mstrid', $_POST['user_id']);
		$query = $this->db->get();
		foreach ($query->result() as $getPass)
				$chkPass=$getPass->usepass;
			if ($chkPass==$old_password) {
				$passwordData = array('mstrpassword'	=> sha1($_POST['newpassword']));
				$this->db->where('mstrid', $_POST['user_id']);
				$condition1=$this->db->update('createmaster', $passwordData);
				//print_r($condition1);
				//echo $this->db->queries[1];die();
		       	return 1;
			}else{
				return 0;
			}
	}
	function updateAccount(){
		$dataArray = array('mobileno' => $_POST['mobileno'],'mstrname' => $_POST['mstrname']);
		$this->db->where('mstrid',$this->session->userdata('user_id'));	
		$condition1=$this->db->update('createmaster', $dataArray);
      	return $condition1;
	}
	function getDealerInfo(){
		$this->db->select('mstrname,mstruserid,mobileno');
		$this->db->from('createmaster');
		$this->db->where('mstrid',$this->session->userdata('user_id'));		
		$query = $this->db->get();
		return $query->result_array();	
	}
	function getFormData(){
		$this->db->select('max(mstrid) as maxid');
		$this->db->from('createmaster');
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach ($query->result() as $getMaxId)
				$id=$getMaxId->maxid;
				$getid=$id+1;
				$json = $getid;
			}else{
				$json = 1;
			}
		return $json;	
	}
	function chkMasterUsername($user){
		$this->db->trans_start();
		$this->db->select('mstruserid as usename');
		$this->db->from('createmaster');
		$this->db->where('mstruserid', $user);
		$query = $this->db->get();
		$num=$query->num_rows();
		$this->db->trans_complete();
		if($num==1){
			return $num;
		}
		else{
			return $num;
		}
	}
	function saveCreateMaster(){
	  			$chek=$this->chkMasterUsername($this->input->post('username'));       			
				if($chek==0){
					$this->db->trans_begin();
					//$this->db->insert('loginusers', $insertData);
					//$last_id=$this->db->insert_id();
					//print_r($_POST);
					
			             if($this->input->post('partner')!='')
							 $partner= $this->input->post('partner');
						 else 
							 $partner=0;
						 
			             if($this->input->post('Commission')!='')
							 $Commission= $this->input->post('Commission');
						 else 
							 $Commission=0;
						 
			             if($this->input->post('maxProfit')!='')
							 $lgnUserMaxProfit= $this->input->post('maxProfit');
						 else 
							 $lgnUserMaxProfit =0;
						 
						 if($this->input->post('maxLoss')!='')
							 $lgnUserMaxLoss= $this->input->post('maxLoss');
						 else 
						 $lgnUserMaxLoss=0;
					 
						 if($this->input->post('sessionCommission')!='')
							 $SessionComm= $this->input->post('sessionCommission');
						 else 
						 $SessionComm=0;
					 
						 if($this->input->post('otherCommission')!='')
							 $OtherComm= $this->input->post('otherCommission');
						 else 
						 $OtherComm=0;
					 
						 if($this->input->post('maxStake')!='')
							 $lgnUserMaxStake= $this->input->post('maxStake');
						 else 
						 $lgnUserMaxStake=0;
					 
						 if($this->input->post('betDelay')!='')
							 $set_timeout= $this->input->post('betDelay');
						 else 
						 $set_timeout=0;
					 
						 if($this->input->post('GngInPlayStake')!='')
							$InPlayStack= $this->input->post('GngInPlayStake');
						else 
							$InPlayStack=0;
						if($this->input->post('DetectAmt')!='')
							$DetectAmt= $this->input->post('DetectAmt');
						else 
							$DetectAmt=0;

						if ($this->input->post('typeId')==1 || $this->input->post('typeId')==2) {
							$insertData1 = array(
					            'mstrname' 			=> $this->input->post('master_name'),
					            'mstruserid' 		=> $this->input->post('username'),
					            'mstrpassword' 		=> sha1($this->input->post('password')),
					            'usetype' 			=> $this->input->post('typeId'),
					            'ipadress' 			=> $_SERVER['REMOTE_ADDR'],
					            'loginid'			=> 0,//$last_id,
					            'parentId'			=> $this->input->post('parantId'),
					            'usecrdt' 			=> $this->input->post('FromDate'),
					            'partner'			=> $partner,
					            'Commission'		=> $Commission,
					            'lgnUserMaxProfit'	=> $lgnUserMaxProfit,
								'lgnUserMaxLoss'	=> $lgnUserMaxLoss,
								'SessionComm'		=> $SessionComm,
								'OtherComm'			=> $OtherComm,
								'HelperID'			=> $this->input->post('HelperID')								
					        );
						}else if($this->input->post('typeId')==3){
							$insertData1 = array(
					            'mstrname' 			=> $this->input->post('master_name'),
					            'mstruserid' 		=> $this->input->post('username'),
					            'mstrpassword' 		=> sha1($this->input->post('password')),
					            'usetype' 			=> $this->input->post('typeId'),
					            'mstrremarks' 		=> $this->input->post('remarks'),
					            'ipadress' 			=> $_SERVER['REMOTE_ADDR'],
					            'loginid'			=> 0,//$last_id,
					            'parentId'			=> $this->input->post('parantId'),
					            'usecrdt' 			=> $this->input->post('FromDate'),
					            'partner'			=> $partner,
					            'Commission'		=> $Commission,
					            'lgnUserMaxProfit'	=> $lgnUserMaxProfit,
								'lgnUserMaxLoss'	=> $lgnUserMaxLoss,
								'SessionComm'		=> $SessionComm,
								'OtherComm'			=> $OtherComm,
								'lgnUserMaxStake'	=> $lgnUserMaxStake,
								'set_timeout'		=> $set_timeout,
								'HelperID'			=> $this->input->post('HelperID'),
								'InPlayStack'		=> $InPlayStack,

					        );
						}					
			      	// print_r($insertData1);
			        $condition=$this->db->insert('createmaster', $insertData1);
			        $creMstId=$this->db->insert_id();
			        $ParantId=$this->input->post('parantId');
			        /*code for Detect Amount*/
				    if($this->input->post('typeId')==3){ 
						$DataArray = array('user_id'=> $creMstId,'value'=> $DetectAmt );
						$condition=$this->db->insert('detect_amount', $DataArray);
					}	
			        /*End of code detect amount*/
			        //start user working table save the data By Manish 31/12/2016
			        $wortype="ADD_ACC";
			        $remarks=$this->input->post('typeId').">>".$this->input->post('username').">>".$partner.">>".$this->input->post('HelperID');
		        	$userWrkingArray = array(
								            'woruser' 			=> $this->input->post('master_name'),
								            'wormode' 			=> 0,
								            'wordate' 			=> $this->input->post('FromDate'),
								            'wortype' 			=> $wortype,
								            'worcode' 			=> $creMstId,
								            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
								            'worrema'			=> $remarks,
								            'worcudt'			=> date('Y-m-d H:i:s',now()),
								        );
		        	$condition=$this->db->insert('userworkin', $userWrkingArray);
			        //End of useworking table
			        if ($this->input->post('typeId')==1) {

			        	$adminPval=100-$partner;
			        	$masterPval=$partner;
			        	$dealerPval=0;

			        }else if($this->input->post('typeId')==2){

			        	$adminPval=100-$this->input->post('PntPartenerShip');
			        	$masterPval=$this->input->post('PntPartenerShip')-$partner;
			        	$dealerPval=$partner;

			        }
			       
			        //Manish add for free chip
			        if ($this->input->post('typeId')==2 || $this->input->post('typeId')==1) {

				        $pTypeId=$this->input->post('typeId');
				        $pParantId=$this->input->post('parantId');
						$query =$this->db->query("call InsPartner($pTypeId,$pParantId,$creMstId,$adminPval,$masterPval,$dealerPval)");


			        }else if($this->input->post('typeId')==3){
			        	$pTypeId=$this->input->post('typeId');
				        $pParantId=$this->input->post('parantId');
						$query =$this->db->query("call InsPartner($pTypeId,$pParantId,$creMstId,0,0,0)");
			        }
			        
			        //end of Free chip code
			        
			      //echo $this->db->queries[2];die();
			        if ($this->db->trans_status() === FALSE){
					    $this->db->trans_rollback();
					     return 0;
					}
					else{
					    $this->db->trans_commit();
					    return 1;
					}
				}else{
					return 2;
				}
	}
	function getSportMstData(){
		$this->db->select('max(id) as maxid');
		$this->db->from('sportmst');
		$query = $this->db->get();
		if($query->num_rows()>0){
			foreach ($query->result() as $getMaxId)
				$id=$getMaxId->maxid;
				$getid=$id+1;
				$json = $getid;
			}else{
				$json = 1;
			}
		return $json;	
	}
	function lstSportData(){
		$this->db->select('id,name');
		$this->db->from('sportmst');			
		$query = $this->db->get();
		return $query->result_array();
    
	}
	function lstSportDataById(){
		$this->db->select('id,name');
		$this->db->from('sportmst');
		$this->db->where('name','Cricket');			
		$query = $this->db->get();
		return $query->result_array();
    
	}
	function SaveSportMaster(){
		$insertData = array('name'=> $_POST['Sport_name']);
		$query=$this->db->insert('sportmst', $insertData);
		if ($query) {
			return $this->lstSportData();
		}else{
			return false;
		}
		

		//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table

	}
	function getSportTypeId(){
		$this->db->select('max(id) as maxid');
		$this->db->from('sporttypemst');
		
		$query = $this->db->get();
		if($query->num_rows()>0){
			
			foreach ($query->result() as $getMaxId)
				$id=$getMaxId->maxid;
				$getid=$id+1;
				$json = $getid;
			
			}else{
				$json = 1;
			}
		return $json;		
	}
	function lstSportTypeData(){
		$this->db->select('spmst.name,sptymst.Name,sptymst.ID');
		$this->db->from('sporttypemst sptymst');
		$this->db->join('sportmst spmst','sptymst.SportID=spmst.id');
       	$query = $this->db->get();
		return $query->result_array();
	}
	function SaveSportTypeMaster(){
		$insertData = array('Name'=> $_POST['Sport_name'],'SportID'=>$_POST['Sport_id']);
		$query=$this->db->insert('sporttypemst', $insertData);
		if ($query) {
			return true;
		}else{
			return false;
		}

		//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
	}
	function getTeameId(){
		$this->db->select('max(id) as maxid');
		$this->db->from('team');
		
		$query = $this->db->get();
		if($query->num_rows()>0){
			
			foreach ($query->result() as $getMaxId)
				$id=$getMaxId->maxid;
				$getid=$id+1;
				$json = $getid;
			
			}else{
				$json = 1;
			}
		return $json;		
	}
	function lstTeamData(){
		$this->db->select('id,name');
		$this->db->from('team');			
		$query = $this->db->get();
		return $query->result_array();
	}
	function saveTeamData(){
		$insertData = array('name'=> $_POST['Team_name']);
		$query=$this->db->insert('team', $insertData);
		if ($query) {
			return true;
		}else{
			return false;
		}	

		//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
	}
	function getPlayerId(){
		$this->db->select('max(ID) as maxid');
		$this->db->from('player');
		
		$query = $this->db->get();
		if($query->num_rows()>0){
			
			foreach ($query->result() as $getMaxId)
				$id=$getMaxId->maxid;
				$getid=$id+1;
				$json = $getid;
			
			}else{
				$json = 1;
			}
		return $json;		
	}
	function lstPlayerData(){
		$this->db->select('plr.ID,plr.Age,spmst.name,tm.name as teamName,plr.Name');
		$this->db->from('player plr');
		$this->db->join('sportmst spmst','plr.SportID=spmst.id');
		$this->db->join('team tm','plr.TeamId=tm.id');						
		$query = $this->db->get();
		return $query->result_array();
	}
	function savePlayerData(){
		$insertData = array('Name'=> $_POST['player_name'],'SportID'=> $_POST['Sport_id'],'TeamId'=> $_POST['team_id']);
		$query=$this->db->insert('player', $insertData);
		if ($query) {
			return true;
		}else{
			return false;
		}		

		//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
	}
	function getSeriesId(){
		$this->db->select('max(ID) as maxid');
		$this->db->from('seriesmst');
		
		$query = $this->db->get();
		if($query->num_rows()>0){
			
			foreach ($query->result() as $getMaxId)
				$id=$getMaxId->maxid;
				$getid=$id+1;
				$json = $getid;
			
			}else{
				$json = 1;
			}
		return $json;		
	}
	function lstSeriesData($id){
			if ($id=='') {
				$this->db->select('srmst.ID,srmst.name,spmst.Name');
				$this->db->from('seriesmst srmst');
				$this->db->join('sportmst spmst','srmst.SportID=spmst.id');
			}else{
				$this->db->select('ID,Name');
				$this->db->from('seriesmst');
				$this->db->where('SportID', $id);
			}
			
        	$query = $this->db->get();
			return $query->result_array();
	}
	function saveSeriesData(){
			$insertData = array('Name'=> $_POST['Series_name'],'SportID'=>$_POST['Sport_id']);
			$query=$this->db->insert('seriesmst', $insertData);
			if ($query) {
				return true;
			}else{
				return false;
			}

			//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
	}
	function getMaxMatchId(){
			$this->db->select('max(MstCode) as maxid');
			$this->db->from('matchmst');			
			$query = $this->db->get();
			if($query->num_rows()>0){
				
				foreach ($query->result() as $getMaxId)
					$id=$getMaxId->maxid;
					$getid=$id+1;
					$json = $getid;
				
				}else{
					$json = 1;
				}
			return $json;	
	}

	function saveMatchEntryData(){
			
			$insertData = array(
							'MstDate'=> $_POST['matchDate'],
							'SportID'=> 1,
							'FromDt'=> $_POST['timeFrom'],
							'ToDt'=> $_POST['timeTo'],
							'Team1'=> $_POST['team1'],
							'Team2'=> $_POST['team2'],
							'TypeID'=> $_POST['matchType1'],
							'SeriesID'=> $_POST['matchSeries'],
							'Target'=> $_POST['matchOver'],
							
							
							);
			
			
			$query=$this->db->insert('matchmst', $insertData);
			if ($query) {
				return true;
			}else{
				return false;
			}		

			//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
	}
	function GetPlayerLstById($id){
			$this->db->select('ID,Name');
			$this->db->from('player');
			$this->db->where('SportID', $id);
			$query = $this->db->get();
			return $query->result_array();
	}
	function GetPlayerLst(){
			$this->db->select('ID,Name');
			$this->db->from('player');
			$query = $this->db->get();
			return $query->result_array();
	}
	function getMaxBetId(){
			$this->db->select('max(bet_id) as maxid');
			$this->db->from('bet_entry');			
			$query = $this->db->get();
			if($query->num_rows()>0){
				
				foreach ($query->result() as $getMaxId)
					$id=$getMaxId->maxid;
					$getid=$id+1;
					$json = $getid;
				
				}else{
					$json = 1;
				}
			return $json;	
	}
	function GetUserLst(){
			$this->db->select('mstrid as usecode,mstruserid as usename');
			$this->db->from('createmaster');
			$this->db->where('usetype<>',0 );
			$query = $this->db->get();
			return $query->result_array();
	}
	function changeUserPasswod1(){

			//print_r($_POST);die();
				$dataArray = array('mstrpassword' => sha1($_POST['newPassword']));				
				$this->db->where('mstrid',$_POST['userId']);	
				$condition1=$this->db->update('createmaster', $dataArray);
				//echo $this->db->queries[0];die();
				return true;
			
	}
	function saveFancyEntry(){
			$insertData = array('MstName'=> $_POST['HeadName'],'MstType'=> $_POST['fancyType'],'MstDate'=> $_POST['FromDate'],'Desc'=>$_POST['remarks']);
			$query=$this->db->insert('headmst', $insertData);
			if ($query) {
				return true;
			}else{
				return false;
			}		

			//Add Userworking sourabh 170117
		//$creFancyId=$this->db->insert_id();
		////start user working table save the data By Manish 170117
		//$wortype="OddEven fancy";
		//$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
		//$userWrkingArray = array(
		//	'woruser'=> $_POST['HeadName'],
		//	'wormode'=> 0,
		//	'wordate'=> $_POST['date'],
		//	'wortype'=> $wortype,
		//	'worcode'=> $creFancyId,
		//	'worsysn'=> $_SERVER['REMOTE_ADDR'],
		//	'worrema'=> $remarks,
		//	'worcudt'=> date('Y-m-d H:i:s',now()),
		//);
		//$condition=$this->db->insert('userworkin', $userWrkingArray);
		////End of useworking table
	}
	function getFancyHeader(){
			$this->db->select('*');
			$this->db->from('headmst');
			$query = $this->db->get();
			return $query->result_array();
	}
	function saveFancy(){
		if($_POST['fancyType']==2){				
			$row = $this->db->query('SELECT MAX(MFancyID) AS `maxid` FROM `matchfancy`')->row();
			$maxid = $row->maxid+1;						
			if($_POST['isApi']==1){
				$insertData = array('HeadName'=> $_POST['HeadName'],'TypeID'=> $_POST['fancyType'],'MatchID'=> $_POST['mid'],'Remarks'=>$_POST['remarks'],'date'=>$_POST['date'],'time'=>$_POST['time'],'SessInptYes'=>$_POST['inputYes'],'SessInptNo'=>$_POST['inputNo'],'MFancyID'=>$maxid,'SprtId'=>$_POST['sid'],'rateDiff'=>$_POST['RateDiff'],'pointDiff'=>$_POST['PointDiff'],'MaxStake'=>$_POST['MaxStake'],'NoValume'=>$_POST['NoLayRange'],'YesValume'=>$_POST['YesLayRange'],'marketId'=>$_POST['marketId']);
			}else{
				$insertData = array('HeadName'=> $_POST['HeadName'],'TypeID'=> $_POST['fancyType'],'MatchID'=> $_POST['mid'],'Remarks'=>$_POST['remarks'],'date'=>$_POST['date'],'time'=>$_POST['time'],'SessInptYes'=>$_POST['inputYes'],'SessInptNo'=>$_POST['inputNo'],'MFancyID'=>$maxid,'SprtId'=>$_POST['sid'],'rateDiff'=>$_POST['RateDiff'],'pointDiff'=>$_POST['PointDiff'],'MaxStake'=>$_POST['MaxStake'],'NoValume'=>$_POST['NoLayRange'],'YesValume'=>$_POST['YesLayRange']);
			}
			$this->db->trans_begin();					
			
			$query=$this->db->insert('matchfancy', $insertData);				
			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    return false;
			}
			else{
			    $this->db->trans_commit();
			    return 1;
			}
		}
	}
	
	
	
	function SaveFancyApi(){
		if($_POST['fancyType']==2){				
			$row = $this->db->query('SELECT MAX(MFancyID) AS `maxid` FROM `matchfancy`')->row();
			$maxid = $row->maxid+1;						
			if($_POST['isApi']==1){
				$insertData = array('HeadName'=> $_POST['HeadName'],'TypeID'=> $_POST['fancyType'],'MatchID'=> $_POST['mid'],'Remarks'=>$_POST['remarks'],'date'=>$_POST['date'],'time'=>$_POST['time'],'SessInptYes'=>$_POST['inputYes'],'SessInptNo'=>$_POST['inputNo'],'MFancyID'=>$maxid,'SprtId'=>$_POST['sid'],'rateDiff'=>$_POST['RateDiff'],'pointDiff'=>$_POST['PointDiff'],'MaxStake'=>$_POST['MaxStake'],'NoValume'=>$_POST['NoLayRange'],'YesValume'=>$_POST['YesLayRange'],'marketId'=>$_POST['marketId']);
			}else{
				$insertData = array('HeadName'=> $_POST['HeadName'],'TypeID'=> $_POST['fancyType'],'MatchID'=> $_POST['mid'],'Remarks'=>$_POST['remarks'],'date'=>$_POST['date'],'time'=>$_POST['time'],'SessInptYes'=>$_POST['inputYes'],'SessInptNo'=>$_POST['inputNo'],'MFancyID'=>$maxid,'SprtId'=>$_POST['sid'],'rateDiff'=>$_POST['RateDiff'],'pointDiff'=>$_POST['PointDiff'],'MaxStake'=>$_POST['MaxStake'],'NoValume'=>$_POST['NoLayRange'],'YesValume'=>$_POST['YesLayRange']);
			}
			$this->db->trans_begin();					
			
			$query=$this->db->insert('matchfancy', $insertData);				
			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    return false;
			}
			else{
			    $this->db->trans_commit();
			    return 1;
			}
		}
	}
	
	
		function getMatchNameById($matchId){
				$this->db->select("matchName");
				$this->db->from('matchmst');
				$this->db->where('MstCode',$matchId);
				$query = $this->db->get();
				return $query->result();

			}
		function chkMatchFancy($matchId,$fancyType){

			 return $this->db->where('MatchID', $matchId)->where('TypeID',$fancyType)->count_all_results('matchfancy');
		
		}
		function GetFancyByIdnType($matchId,$fancyType){

			$this->db->select('MatchID,HeadName,TypeID,Remarks,date,time,SessInptYes,SessInptNo,ID');
			$this->db->from('matchfancy');
			$this->db->where('MatchID', $matchId);
			$this->db->where('TypeID', $fancyType);
			$query = $this->db->get();
			$data = $query->result_array();
				//echo $this->db->queries[0];die();
			//$password =$data[0]['usepass'];
			return $data;

		}
		function updateMatchStatus($matchId,$active){
			$dataArray = array('active' => $active);
    		$this->db->where('MstCode',$matchId);
            $this->db->update('matchmst', $dataArray);
            return true; 
		}
		function updateFancyStatus($fancyId,$active){
			$dataArray = array('active' => $active);
    		$this->db->where('ID',$fancyId);
            $this->db->update('matchfancy', $dataArray);
            return true; 
		}
		function getPlayer(){
			/*SELECT distinct(plr.Name),plr.ID FROM matchmst mtchmst INNER JOIN player plr ON mtchmst.Team1=plr.TeamId OR mtchmst.Team2=plr.TeamId WHERE mtchmst.SportID=1*/
			$this->db->select('distinct(Name),ID');
			$this->db->from('player');
			/*$this->db->join('player plr','mtchmst.Team1=plr.TeamId OR mtchmst.Team2=plr.TeamId');*/
			/*$this->db->where('mtchmst.SportID',1);*/
			$query = $this->db->get();
			return $query->result_array();
		}
		function GetPlayerById($playerId){
			$this->db->select('Name');
			$this->db->from('player');
			$this->db->where('ID', $playerId);
			$query = $this->db->get();
			$data = $query->result_array();

			$name =$data[0]['Name'];
			return $name;
		}
		function viewUserAc($id,$type){
			$this->db->select('c.mstrname,c.mstruserid,(case when b.TypeID=1 then b.Master else b.Dealer end) as partner,c.stakeLimit,c.Commission,c.lgnUserMaxProfit,c.lgnUserMaxLoss,c.lgnUserMaxStake');
			$this->db->from('createmaster c');
			if($type=1)
			$this->db->join('tblpartner b','c.mstrid = b.ParentID','left');
		else
			$this->db->join('tblpartner b','c.mstrid = b.UserID','left');
			$this->db->where('c.mstrid', $id);
			$query = $this->db->get();
			//echo $this->db->queries[0];die();
			return $data = $query->result_array();

		}
		function ChangeUserPassword(){
			
			if ($_POST['userType_id']==$_POST['SltUsrType_id']) {

				$getPassword=$this->chkUserPassword($_POST['userId']);

				if ($getPassword==sha1($_POST['oldPassword'])) {

					$dataArray = array('mstrpassword' => sha1($_POST['newPassword']),'HelperID' => $_POST['HelperID']);
					
					$this->db->where('mstrid',$_POST['userId']);	
					$condition1=$this->db->update('createmaster', $dataArray);
					//start user working table save the data By Manish 31/12/2016
			        	$wortype="CHANGE_PASSWORD";
			        	$remarks="USER TYPE_ID : ".$_POST['userType_id'].">>USER_ID : ".$_POST['userId'].">>".$_POST['HelperID'];
			        	$userWrkingArray = array(
									            'woruser' 			=> $_POST['userId'],
									            'wormode' 			=> 0,
									            'wordate' 			=> date('Y-m-d H:i:s',now()),
									            'wortype' 			=> $wortype,
									            'worcode' 			=> $_POST['userId'],
									            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
									            'worrema'			=> $remarks,
									            'worcudt'			=> date('Y-m-d H:i:s',now()),
									        );
			        	$condition=$this->db->insert('userworkin', $userWrkingArray);
			        //End of useworking table
					
					if ($condition1) {
						return true;
						
					}else{
						return false;
					}

				}else{
					
						return false;
				
				}
			}else{
					$dataArray = array('mstrpassword' => sha1($_POST['newPassword']),'HelperID' => $_POST['HelperID']);
					$this->db->trans_begin();
					$this->db->where('mstrid',$_POST['userId']);	
					$condition1=$this->db->update('createmaster', $dataArray);
					//start user working table save the data By Manish 31/12/2016
			        	/*$wortype="CHANGE_PASSWORD";
			        	$remarks="USER TYPE_ID : ".$_POST['userType_id'].">>USER_ID : ".$_POST['userName'].">>".$_POST['HelperID'];
			        	$userWrkingArray = 	array(
									            'woruser' 			=> $_POST['userId'],
									            'wormode' 			=> 0,
									            'wordate' 			=> date('Y-m-d H:i:s',now()),
									            'wortype' 			=> $wortype,
									            'worcode' 			=> $_POST['userId'],
									            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
									            'worrema'			=> $remarks,
									            'worcudt'			=> date('Y-m-d H:i:s',now()),
									        );
			        	$condition=$this->db->insert('userworkin', $userWrkingArray);*/
			        //End of useworking table
					 if ($this->db->trans_status() === FALSE){
					    $this->db->trans_rollback();
					     return false;
					}
					else{
					    $this->db->trans_commit();
					    return true;
					}
			}
		}
		function chkUserPassword($userId){

			$this->db->select('mstrpassword as usepass');
			$this->db->from('createmaster');
			$this->db->where('mstrid', $userId);
			$query = $this->db->get();
			$data = $query->result_array();
			$password =$data[0]['usepass'];
			return $password;
		}
		function lockUser(){
			
            $userType=$_POST['userType'];
            $userId=$_POST['userId'];
            $lockVal=$_POST['lockVal'];
			$loginUserID=$_POST['loginUserID'];//sourabh new 161224
			$HelperID=$_POST['HelperID'];
			
			//start user working table save the data By Manish 31/12/2016
        	$wortype="UserLock";
        	$remarks="USER TYPE_ID : ".$_POST['userType'].">> USER_ID : ".$_POST['HelperID'].">> USER_ID : ".$_POST['HelperID'];
        	$userWrkingArray = 	array(
						            'woruser' 			=> $_POST['userId'],
						            'wormode' 			=> 1,
						            'wordate' 			=> date('Y-m-d H:i:s',now()),
						            'wortype' 			=> $wortype,
						            'worcode' 			=> $_POST['userId'],
						            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
						            'worrema'			=> $remarks,
						            'worcudt'			=> date('Y-m-d H:i:s',now()),
						        );
        	
			//End of useworking table
			$this->db->trans_begin();

			$condition=$this->db->insert('userworkin', $userWrkingArray);
           //echo "call sp_updLockStatus($userId,$userType,$lockVal,$lockVal,$loginUserID)";die();
            $query =$this->db->query("call sp_updLockStatus($userId,$userType,$lockVal,$lockVal,$loginUserID,$HelperID)");
		
			 	if ($this->db->trans_status() === FALSE){
					    $this->db->trans_rollback();
					     return false;
				}
				else{
				    $this->db->trans_commit();
				    return true;
				}

		}
		function lockUserBetting(){
			//start user Lock betting
			
            
            //return true; 
			//start user working table save the data By Manish 31/12/2016
	        	$wortype="UserLock Betting";
	        	$remarks="USER TYPE_ID : ".$_POST['userType'].">> USER_ID : ".$_POST['userName'].">> HelperID : ".$_POST['HelperID'];
	        	$userWrkingArray = 	array(
							            'woruser' 			=> $_POST['userId'],
							            'wormode' 			=> 1,
							            'wordate' 			=> date('Y-m-d H:i:s',now()),
							            'wortype' 			=> $wortype,
							            'worcode' 			=> $_POST['userId'],
							            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
							            'worrema'			=> $remarks,
							            'worcudt'			=> date('Y-m-d H:i:s',now()),
							        );
	 			$this->db->trans_begin();

					$dataArray = array('lgnusrlckbtng' => $_POST['lockbettingVal'],'HelperID' => $_POST['HelperID']);
					$this->db->where('mstrid',$_POST['userId']);
					$q1=$this->db->update('createmaster', $dataArray);
					$condition=$this->db->insert('userworkin', $userWrkingArray);
				 	if ($this->db->trans_status() === FALSE){
						    $this->db->trans_rollback();
						     return false;
					}
					else{
					    $this->db->trans_commit();
					    return true;
					}
			//end of user lock betting
			
		}
		function UpdateUserAccount(){


			//start user working table save the data By Manish 31/12/2016
	        	$wortype="Close Account";
	        	$remarks="USER TYPE_ID : ".$_POST['userType'].">> USER_ID : ".$_POST['userName'].">> HelperID : ".$_POST['HelperID'];
	        	$userWrkingArray = 	array(
							            'woruser' 			=> $_POST['userId'],
							            'wormode' 			=> 1,
							            'wordate' 			=> date('Y-m-d H:i:s',now()),
							            'wortype' 			=> $wortype,
							            'worcode' 			=> $_POST['userId'],
							            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
							            'worrema'			=> $remarks,
							            'worcudt'			=> date('Y-m-d H:i:s',now()),
							        );
	        	
				//End of useworking table
						$this->db->trans_begin();

						$dataArray = array('lgnusrCloseAc' => $_POST['accValue'],'HelperID' => $_POST['HelperID']);
						$this->db->where('mstrid',$_POST['userId']);
						$q1=$this->db->update('createmaster', $dataArray);
						// $loginArray = array('lgnusrCloseAc' => $_POST['accValue']);
						// $this->db->where('usecode',$_POST['userId']);
						// $q2=$this->db->update('loginusers', $loginArray);

						$condition=$this->db->insert('userworkin', $userWrkingArray);

		           
			
					 	if ($this->db->trans_status() === FALSE){
							    $this->db->trans_rollback();
							     return false;
						}
						else{
						    $this->db->trans_commit();
						    return true;
						}
			//end of user lock betting



			
            
          
		}
		function partnerValue($userId){
			$this->db->select('partner');
			$this->db->from('createmaster');
			$this->db->where('mstrid', $userId);
			$query = $this->db->get();
			$data = $query->result_array();

			$name =$data[0]['partner'];
			return $name;
		}
		function UpdateUserAccountData()
		{
			//print_r($_POST);die();
			

			if($_POST['partnership']!='')$partner = $_POST['partnership'];else $partner =0;
			if($_POST['set_timeout']!='')$set_timeout = $_POST['set_timeout'];else $set_timeout =0;
			if($_POST['maxProfit']!='')$lgnUserMaxProfit = $_POST['maxProfit'];else $lgnUserMaxProfit =0;
			if($_POST['maxLoss']!='')$lgnUserMaxLoss = $_POST['maxLoss'];else $lgnUserMaxLoss =0;
			if($_POST['maxStake']!='')$lgnUserMaxStake = $_POST['maxStake'];else $lgnUserMaxStake =0;
			if($_POST['InPlayStack']!='')$InPlayStack =$_POST['InPlayStack'];else $InPlayStack =0;
			/*'partner' => $_POST['partnership'],*/
			$dataArray = array(
								'mstrname' => $_POST['Name'],								
								'set_timeout' => $_POST['set_timeout'],
								'lgnUserMaxProfit' => $_POST['maxProfit'],
								'lgnUserMaxLoss' => $_POST['maxLoss'],
								'lgnUserMaxStake' => $_POST['maxStake'],
								'InPlayStack' => $_POST['InPlayStack'],
								'HelperID' => $_POST['HelperID']
								);
			//print_r($dataArray);
			$this->db->trans_begin();

    		$this->db->where('mstrid',$_POST['id']);
            $q1=$this->db->update('createmaster', $dataArray);

            //$loginArray = array('mstrname' => $_POST['Name']);
    		//$this->db->where('mstrname',$_POST['userId']);
            //$q2=$this->db->update('loginusers', $loginArray);

            //start user working table save the data By Manish 31/12/2016
		        $wortype="VIEW_ACC";
		        $remarks=$_POST['userType'].">>".$_POST['userId'].">>".$_POST['partnership'];
		        	$userWrkingArray = array(
								            'woruser' 			=> $_POST['userId'],
								            'wormode' 			=> 1,
								            'wordate' 			=> date('Y-m-d H:i:s',now()),
								            'wortype' 			=> $wortype,
								            'worcode' 			=> $_POST['id'],
								            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
								            'worrema'			=> $remarks,
								            'worcudt'			=> date('Y-m-d H:i:s',now()),
								        );
		        	$condition=$this->db->insert('userworkin', $userWrkingArray);
		    //End of useworking table

            //start the tble Partner Update
            	if ($_POST['userType']==1) {

			        	$adminPval=100-$_POST['partnership'];
			        	$masterPval=$_POST['partnership'];
			        	$dealerPval=0;

		        }else if($_POST['userType']==2){

		        	$adminPval=100-$_POST['PntPartenerShip'];
		        	$masterPval=$_POST['PntPartenerShip']-$_POST['partnership'];
		        	$dealerPval=$_POST['partnership'];

		        }
			       
			        //Manish add for free chip
		        if ($_POST['userType']==2 || $_POST['userType']==1) {
		        	
			        //print_r($_POST);die();
			        //$this->db->insert('tblpartner', $partnershipData);
			        $userId=$_POST['id'];
			        $pTypeId=$_POST['userType'];
			        $pParantId=$_POST['parantId'];
					$query =$this->db->query("call InsPartner($pTypeId,$pParantId,$userId,$adminPval,$masterPval,$dealerPval)");
		        }
			        
            //End of TblPartner

            		if ($this->db->trans_status() === FALSE){
					    $this->db->trans_rollback();
					     return false;
					}
					else{
					    $this->db->trans_commit();
					    return true;
					}
            
            //return true; 
		}
	function viewUserAcData($id)//sourabh 11-nov-2016
	{
		$this->db->select('mstrlock,lgnusrlckbtng,lgnusrCloseAc,IFNULL(lgnUserMaxStake,"0") as stakeLimit,lgnUserMaxProfit,lgnUserMaxLoss,IFNULL(InPlayStack,"0") as GoingInplayStakeLimit,set_timeout');
		$this->db->from('createmaster');
		$this->db->where('mstrid', $id);
		$query = $this->db->get();
		return $data = $query->result_array();
	}
	function updateOddsLimit($limit,$matchId)//sourabh 11-nov-2016
	{
		$dataArray = array('oddsLimit' => $limit);
    	$this->db->where('MstCode',$matchId);
        $this->db->update('matchmst', $dataArray);
        return true; 
	}
	function updateStakeLimit($limit,$usecode)//Manish 25-nov-2016
	{
		$dataArray = array('stakeLimit' => $limit);
    	$this->db->where('mstrid',$usecode);
        $this->db->update('createmaster', $dataArray);
        return true; 
	}
	function updateCommission($Commission,$usecode)//Manish 25-nov-2016
	{
		$dataArray = array('Commission' => $Commission);
    	$this->db->where('mstrid',$usecode);
        $this->db->update('createmaster', $dataArray);
        return true; 
	}
	function UpdateMaxProfit($profit,$usecode)//Manish 25-nov-2016
	{
		$dataArray = array('lgnUserMaxProfit' => $profit);
    	$this->db->where('mstrid',$usecode);
        $this->db->update('createmaster', $dataArray);
        return true; 
	}
	function UpdateMaxLoss($loss,$usecode)//Manish 25-nov-2016
	{
		$dataArray = array('lgnUserMaxLoss' => $loss);
    	$this->db->where('mstrid',$usecode);
        $this->db->update('createmaster', $dataArray);
        return true; 
	}
	function UpdateMaxStake($stake,$usecode)//Manish 25-nov-2016
	{
		$dataArray = array('lgnUserMaxStake' => $stake);
    	$this->db->where('mstrid',$usecode);
        $this->db->update('createmaster', $dataArray);
        return true; 
	}
	function suspendFancy(){

		//print_r($_POST);die();
		$row = $this->db->query('SELECT MAX(MFancyID) AS `maxid` FROM `matchfancy`')->row();						
		$maxid = $row->maxid+1; 
		$dataArray = array( 'active' => $_POST['status'],'SessInptYes'=>$_POST['YesVal'],'SessInptNo'=>$_POST['NoVal'],'MaxStake'=>$_POST['MaxStake'],'NoValume'=>$_POST['NoValume'],'YesValume'=>$_POST['YesValume'],'pointDiff'=>$_POST['pointDiff'],'rateDiff'=>$_POST['rateDiff'],'MFancyID'=>$maxid);
			//print_r($dataArray);die();
		$this->db->where('ID',$_POST['FancyId']);
		$this->db->where('result',NULL);
		$query=$this->db->update('matchfancy', $dataArray);
		$dataArray1 = array('DisplayMsg'=>'');
		$this->db->where('MatchID',$_POST['matchId']);
		
		$query1=$this->db->update('matchfancy', $dataArray1);
		$str = $this->db->last_query();
		print_r($str);
		
		return $query; 
	}
	function updateVolumeLimit($limit,$matchId)//sourabh 30-nov-2016
	{
		$dataArray = array('volumeLimit' => $limit);
    	$this->db->where('MstCode',$matchId);
        $this->db->update('matchmst', $dataArray);
        return true; 
	}
	function sumOfOdds($MarketId,$userId,$userType,$matchId)//sourabh 161226 change
	{
	if($userId==null)$userId1=0;else $userId1=$userId;
		
			$query =$this->db->query("call SP_OddsProfitLossNew($userId1,$userType,$matchId,$MarketId)");//sourabh 161226 change
			$res = $query->result_array();
			$query->next_result();
			$query->free_result();
			return $res;

	}
	function get_userList($userType){
		$this->db->select('mstrid as id,mstruserid as label');
		$this->db->from('createmaster');
		$this->db->where('usetype', $userType);
		
		$query = $this->db->get();
		return $data = $query->result_array();
	}
	function get_menuList(){
		$this->db->select('*');
		$this->db->from('menuoption');
		#$this->db->where('usetype', $userType);
		
		$query = $this->db->get();
		return $data = $query->result_array();
	}
	function getMarketInfo($MarketId)//sourabh 7-dec-2016
	{
		$this->db->select('m.Name as MarketName,m.Id as MarketID,m.sportsId as SportID,s.name as SportName ');
		$this->db->from('market m');
		$this->db->where('m.Id', $MarketId);
		$this->db->join('sportmst s','s.id=m.sportsId','inner');
		$query = $this->db->get();
		return $data = $query->result_array();
	}
	function SaveSubAdmin(){
		$insertData = array(

                'mstrname' 		=> $this->input->post('name'),
                'usename' 		=> $this->input->post('username'),
                'usepass' 		=> sha1($this->input->post('password')),
                'usetype' 		=> $this->input->post('type'),
                'ipadress' 		=> $_SERVER['REMOTE_ADDR']
	            );
        $insertcreteMaster = array(

                'mstrname' 		=> $this->input->post('name'),
                'mstruserid' 		=> $this->input->post('username'),
                'mstrpassword' 		=> sha1($this->input->post('password')),
                'usetype' 		=> $this->input->post('type'),
                'ipadress' 		=> $_SERVER['REMOTE_ADDR']
        );
        $query1=$this->db->insert('createmaster', $insertcreteMaster);
		//$query=$this->db->insert('loginusers', $insertData);
		if ($query1) {
			return true;
		}else{
			return false;
		}


	}
	function getSubadmin()//sourabh 7-dec-2016
	{
		//$this->db->select('usecode,mstrname,usename');
		//$this->db->from('loginusers');
		//$this->db->where('usetype', 4);

		$this->db->select('mstrid as usecode,mstrname,mstruserid as usename');
		$this->db->from('createmaster');
		$this->db->where('usetype', 4);
		$query = $this->db->get();
		return $data = $query->result_array();
	}
	function getSelectionName($matchId,$marketId)//sourabh 161228
	{
		$this->db->select('*');
		$this->db->from('tblSelection');
		$this->db->where('matchId', $matchId);
		$this->db->where('marketId', $marketId);
		$query = $this->db->get();
		return $data = $query->result_array();
	}
	function getResetPassword(){

			$this->db->select('Password');
			$this->db->from('tblconfig');
			$query = $this->db->get();
			$data = $query->result_array();
			$password =$data[0]['Password'];
			return $password;

	}
	function updateUserAcPasswrd($userId,$passwrd,$HelperID){
			$dataArray = array('mstrpassword' => sha1($passwrd),'HelperID' => $this->input->post('HelperID'));
			$this->db->where('mstrid',$userId);
			$query=$this->db->update('createmaster', $dataArray);
			return $query; 
	}
	function UpdateCnfgPasssword($passwrd){
			$dataArray = array('Password' => $passwrd);
			$this->db->where('Id',1);
			$query=$this->db->update('tblconfig', $dataArray);
			return $query; 
	}
	function submitClearChip()//sourabh 161229
	{
		$this->load->model('Chip_model');
		$GetpId=$this->Get_ParantId($this->input->post('UserID'));
		$ParantId=$GetpId[0]->parentId;
		$UserID=$_POST['UserID'];
		$LoginID=$_POST['LoginID'];
		$CrDr=$_POST['CrDr'];
		$Chips=$_POST['Chips'];
		$IsFree=$_POST['IsFree'];
		$Narration=$_POST['Narration'];
		$HelperID=$_POST['HelperID'];
				
		$query = $this->db->query("call sp_insClearChip($UserID,$LoginID,$CrDr,$Chips,$IsFree,'$Narration',$ParantId,$HelperID)");
		$res = $query->result_array();
			$query->next_result();
			$query->free_result();
			return $res;
	}
	function RollBackSettlement($id){
		$query =$this->db->query("call sp_rollBackSettlement($id)");
			$res = $query->result_array();
			$query->next_result();
			$query->free_result();
			return $res;
	}
	function Get_ParantId($userId){
			$this->db->select("parentId");
			$this->db->from('createmaster');
			$this->db->where('mstrid',$userId);
			$query = $this->db->get();
			return $query->result();
	}
	function GetFancyById($FancyID,$fancyType){

			$this->db->select('MatchID,HeadName,TypeID,Remarks,date,time,SessInptYes,SessInptNo,ID');
			$this->db->from('matchfancy');
			$this->db->where('ID', $FancyID);
			$this->db->where('TypeID', $fancyType);
			$query = $this->db->get();
			$data = $query->result_array();
            //echo $this->db->queries[0];die();
            //$password =$data[0]['usepass'];
			return $data;

	}
	function UpdateSessionFancy(){
		$Fancy=$this->GetFancyById($_POST['FancyID'],$_POST['fancyType']);
					
					$fancyId=$Fancy[0]['ID'];
					$MatchID=$Fancy[0]['MatchID'];
					$HeadName=$Fancy[0]['HeadName'];
					$TypeID=$Fancy[0]['TypeID'];
					$Remarks=$Fancy[0]['Remarks'];
					$date=$Fancy[0]['date'];
					$time=$Fancy[0]['time'];
					$SessInptYes=$Fancy[0]['SessInptYes'];
					$SessInptNo=$Fancy[0]['SessInptNo'];
					//$insertData = array('HeadName'=> $HeadName,'TypeID'=> $TypeID,'MatchID'=> $MatchID,'Remarks'=>$Remarks,'date'=>$date,'time'=>$time,'SessInptYes'=>$SessInptYes,'SessInptNo'=>$SessInptNo,'MatchFancyId'=>$fancyId);
					//Start Transaction

					$this->db->trans_begin();

					//$insertQuery=$this->db->insert('tblsessionfancy', $insertData);
					$dataArray =  array('HeadName'=> $_POST['HeadName'],'TypeID'=> $_POST['fancyType'],'MatchID'=> $_POST['mid'],'Remarks'=>$_POST['remarks'],'date'=>date('Y-m-d',now()),'time'=>date('H:i:s',now()),'SessInptYes'=>$_POST['inputYes'],'SessInptNo'=>$_POST['inputNo'],'active'=>1);
		    		//Update The session Fancy
		    		$this->db->where('ID',$_POST['FancyID']);
		    		$this->db->where('TypeID',$_POST['fancyType']);
		    		
		            $UpdateQuery=$this->db->update('matchfancy', $dataArray);
		            $creFancyId=$this->db->insert_id();
					//start user working table save the data By Manish 02/1/2017
			        	$wortype="Session Fancy";
			        	$remarks="Fancy Type>>".$_POST['fancyType'].">>Fancy Name >>".$_POST['HeadName'].">> Match ID >>".$_POST['mid'];
			        	$userWrkingArray = array(
									            'woruser' 			=> $_POST['HeadName'],
									            'wormode' 			=> 1,
									            'wordate' 			=> $date,
									            'wortype' 			=> $wortype,
									            'worcode' 			=> $creFancyId,
									            'worsysn' 			=> $_SERVER['REMOTE_ADDR'],
									            'worrema'			=> $remarks,
									            'worcudt'			=> date('Y-m-d H:i:s',now()),
									        );
			        	$condition=$this->db->insert('userworkin', $userWrkingArray);
			        //End of useworking table
		           if ($this->db->trans_status() === FALSE)
					{
					    $this->db->trans_rollback();
					     return false;
					}
					else
					{
					    $this->db->trans_commit();
					    return true;
					}
		           //Complete Transaction
					
				//}

	}
	function getMaxProfit($id,$MatchId,$MarketId)//sourabh 170102 new
	{
			/*$query =$this->db->select('IFNULL(Sum(P_L),"0") as maxProfit');
			$query = $this->db->where('UserId',	$id);
            $query = $this->db->where('MatchId',$MatchId);
            $query = $this->db->where('MarketId',$MarketId);
			$query = $this->db->where('IFNULL(ResultID,0)',	'0');
			$query = $this->db->where('IFNULL(isBack,0)','0');
			$query = $this->db->get('tblbets');
			$result = $query->result();
			return $result;*/
			//echo "call getMarketLiability($id,$matchId,'$marketId')";
			//die();
			$query =$this->db->query("call getMarketLiability($id,$MatchId,'$MarketId')");
			$res = $query->result_array();
			$query->next_result();
			$query->free_result();
			return $res;
	}
	function editFancy(){//sourabh 170118

			$row = $this->db->query('SELECT MAX(MFancyID) AS `maxid` FROM `matchfancy`')->row();
			//print_r($row);
			$maxid = $row->maxid+1; 
			if(empty($_POST['mid'])==1)  $pMatchID=0;else $pMatchID=$_POST['mid'];
			if(empty($_POST['HeadName'])==1)  $pHeadName='';else $pHeadName=$_POST['HeadName'];
			$pTypeID=$_POST['fancyType'];
			if(empty($_POST['remarks'])==1) $pRemarks='';else $pRemarks=$_POST['remarks']; 
			if(empty($_POST['date'])==1)  $pdate=null;else $pdate=$_POST['date'];
			if(empty($_POST['time'])==1) $ptime=null;else $ptime=$_POST['time']; 
			if(empty($_POST['inputYes'])==1) $pSessInptYes=0;else $pSessInptYes=$_POST['inputYes'];
			if(empty($_POST['inputNo'])==1) $pSessInptNo=0;else $pSessInptNo=$_POST['inputNo']; 
			if(empty($_POST['fancyRange'])==1)  $pfancyRange=0;else $pfancyRange=$_POST['fancyRange'];
			if(empty($_POST['PlayerId'])==1) $pPlayerId=0; else $pPlayerId=$_POST['PlayerId'];
			$pactive=1;  
			$presult='';  
			if(empty($_POST['Back_size'])==1)  $pupDwnBack=0;else $pupDwnBack=$_POST['Back_size'];
			if(empty($_POST['Lay_size'])==1) $pupDwnLay=0; else $pupDwnLay=$_POST['Lay_size'];
			$pMFancyID=$maxid; 
			if(empty($_POST['sid'])==1)  $pSprtId=0;else $pSprtId=$_POST['sid'];
			if(empty($_POST['RateDiff'])==1) $prateDiff=0;else $prateDiff=$_POST['RateDiff']; 
			if(empty($_POST['PointDiff'])==1) $ppointDiff=0;else $ppointDiff=$_POST['PointDiff']; 
			if(empty($_POST['MaxStake'])==1)  $pMaxStake=0;else $pMaxStake=$_POST['MaxStake'];
			if(empty($_POST['NoLayRange'])==1) $pNoValume=0;else $pNoValume=$_POST['NoLayRange']; 
			if(empty($_POST['YesLayRange'])==1)  $pYesValume=0;else $pYesValume=$_POST['YesLayRange'];
			$pID=$_POST['FancyId'];
			if(empty($_POST['upDwnLimit'])==1) $upDwnLimit=0;else $upDwnLimit=$_POST['upDwnLimit'];
			if($_POST['fancyType']==4){
				$upDwnLimit=$_POST['upDwnLimit'];
				//echo "call sp_UpdMatchfancy($pMatchID,'$pHeadName',$pTypeID,'$pRemarks','$pdate','$ptime',$pSessInptYes,$pSessInptNo,$pfancyRange,$pPlayerId,$pactive,'$presult',$pupDwnBack,$pupDwnLay,$pMFancyID,$pSprtId,$prateDiff,$ppointDiff,$pMaxStake,$pNoValume,$pYesValume,$pID,$upDwnLimit)";
				$query = $this->db->query("call sp_UpdMatchfancy($pMatchID,'$pHeadName',$pTypeID,'$pRemarks','$pdate','$ptime',$pSessInptYes,$pSessInptNo,$pfancyRange,$pPlayerId,$pactive,'$presult',$pupDwnBack,$pupDwnLay,$pMFancyID,$pSprtId,$prateDiff,$ppointDiff,$pMaxStake,$pNoValume,$pYesValume,$pID,$upDwnLimit)");
			}else{
				$upDwnLimit=0;
				$query = $this->db->query("call sp_UpdMatchfancy($pMatchID,'$pHeadName',$pTypeID,'$pRemarks','$pdate','$ptime',$pSessInptYes,$pSessInptNo,$pfancyRange,$pPlayerId,$pactive,'$presult',$pupDwnBack,$pupDwnLay,$pMFancyID,$pSprtId,$prateDiff,$ppointDiff,$pMaxStake,$pNoValume,$pYesValume,$pID,$upDwnLimit)");
			}
			//echo $this->db->queries[1];die();
			$res = $query->result_array();
			$query->next_result();
			$query->free_result();
			return $res;
			
		}
		function getMatchOddsLimit($matchId,$marketId){ //sourabh 170201
	    
			$mSql="select sum(result) as result,sum(oddsLimit) as oddsLimit,sum(volumeLimit) as volumeLimit from ( select 0 as result,oddsLimit,volumeLimit from matchmst where MstCode=".$matchId." UNION SELECT IFNULL(max(result),0) as result,0 as oddsLimit,0 as volumeLimit FROM tblresult where marketid=".$marketId." and matchId=".$matchId.") a";
			$query = $this->db->query($mSql);
			return $query->result_array();
		}
		function get_Master_AltSubAdmin($userType,$adminId){//170210
			$this->db->select('l.mstrid as id,l.mstruserid as label,h.HelperID');
			$this->db->from('createmaster l');
			$this->db->join('tblHelper h','l.mstrid=h.MasterID','left');
			$this->db->where('l.usetype', $userType);
			$this->db->where('IFNULL(h.HelperID,'.$adminId.')', $adminId);
			$query = $this->db->get();
			return $data = $query->result_array();
		}
		function get_Helper_MenuList($adminId)//170210
		{
			$this->db->select('*');
			$this->db->from('tblHelperRight');
			$this->db->where('HelperID', $adminId);
			$query = $this->db->get();
			return $query->result_array();
		}
		function save_path($image){
            $saveImagePath = array(  'img_name'	=> $image,
                'date'	    => date('Y-m-d H:i:s',now()),
            );
            $condition=$this->db->insert('slider_img', $saveImagePath);
            return $condition;
        }
        function get_sliderImage(){
            $this->db->select('*');
            $this->db->from('slider_img');
            $query = $this->db->get();
            return $query->result_array();
        }
        function get_DashBoardImage(){
            $this->db->select('*');
            $this->db->from('slider_img');
            $this->db->where('active', 1);
            $query = $this->db->get();
            return $query->result_array();
        }
        function update_slider($id,$status){
            $updateData = array('active' => $status);
            $this->db->where('id', $id);
            $condition=$this->db->update('slider_img', $updateData);
            return $condition;
        }
        function deleteImage($id){
            $this->db->where('id', $id);
            $condition=$this->db->delete('slider_img');
            return $condition;
        }
		function updateSeriesSatatus($seriesId,$active){//170221
			$dataArray = array('active' => $active);
    		$this->db->where('seriesId',$seriesId);
            $this->db->update('seriesmst', $dataArray);
            return true; 
		}
		function updateMarketStake($MarketId,$stake){//170221
			$dataArray = array('gin_play_stake' => $stake);
    		$this->db->where('Id',$MarketId);
            $this->db->update('market', $dataArray);
            return true; 
		}
  
    function setLiability(){
        $updateData = array('upDwnLimit' => $_POST['liability']);
        $this->db->where('ID', $_POST['FancyId']);
        $condition=$this->db->update('matchfancy', $updateData);
        return $condition;
    }
    function updatePartnerShip($admin,$master,$dealer,$userId,$HelperID){
    	$dataArray = array( 'Admin' => $admin,'Master'=>$master,'Dealer'=>$dealer,'HelperID'=>$HelperID);
        $this->db->where('UserID',$userId);
        $query=$this->db->update('tblpartner', $dataArray);
        //echo $this->db->queries[0];
        return $query;
    }
     function updateUserCommission($oddsComm,$sessionComm,$otherComm,$ID,$HelperID){
    	$dataArray = array( 'Commission' => $oddsComm,'SessionComm'=>$sessionComm,'OtherComm'=>$otherComm,'HelperID'=>$HelperID);
        $this->db->where('mstrid',$ID);
        $query=$this->db->update('createmaster', $dataArray);
        //echo $this->db->queries[0];die();
        return $query;
    }
     function changeLgnPassword(){
     	$this->db->select('mstruserid as usename,mstrpassword as usepass,usetype');
		$this->db->from('createmaster');
		$this->db->where('mstrid', $_POST['userId']);
		$this->db->where('mstrpassword', sha1($_POST['oldPassword']));
		$query = $this->db->get();
		if($query->num_rows()==1){

			$password=sha1($_POST['newPassword']);
	    	$dataArray = array( 'mstrpassword' => $password,'chkupdatePass'=>1);
	        $this->db->where('mstrid',$_POST['userId']);
	        $query=$this->db->update('createmaster', $dataArray);
	        //echo $this->db->queries[1];die();			
			return $query;
		}
		else{
			return 0;
		}
     	
    }
	function changeLgnBitC(){
	    	$dataArray = array('chkupdatePass'=>1);
	        $this->db->where('mstrid',$_POST['userId']);
	        $query=$this->db->update('createmaster', $dataArray);
			return 1;//$query;
    }
	function chaneMarketPPStatus($userId,$matchId,$marketId,$fancyId,$usertype,$IsPlay){
		$GetpId=$this->Get_ParantId($userId);
		$ParantId=$GetpId[0]->parentId;
		//echo $IsPlay;
		/*if ($IsPlay==0) {
			$IsPlay1=0;
		}else{
			$IsPlay1=0;
		}*/
		//echo "call sp_SetRights($userId,$ParantId,$userId,$matchId,'$marketId',$fancyId,$IsPlay1,$usertype)";
		$query =$this->db->query("call sp_SetRights($userId,$ParantId,$userId,$matchId,'$marketId',$fancyId,$IsPlay,$usertype)");
		$res = $query->result_array();
		$query->next_result();
		$query->free_result();
		return $res;
    }
    function sp_getMTreeTemp($userId){
		
		$query =$this->db->query("call sp_getMTreeTemp($userId)");
		$res = $query->result_array();
		$query->next_result();
		$query->free_result();
		return $res;
	}
	function getBetDelay($userId){
		$this->db->select('set_timeout');
		$this->db->from('createmaster');
		$this->db->where('mstrid',$userId);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function checkAutoFancyisActive($MatchId){
		$this->db->select('autoActive');
                $this->db->select('ID');

		$this->db->from('matchfancy');
		$this->db->where('Matchid',$MatchId);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	 function updatefancyAutoSetToUserPannel($ID){
    	$dataArray = array( 'autoActive' => 1);
        $this->db->where('ID',$ID);
        $query=$this->db->update('matchfancy', $dataArray);
        //echo $this->db->queries[0];die();
        return $query;
    }
 

	
	function Tuncate_matchlst(){
		
		/*$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
		$this->db->where('active', '1');
		$this->db->delete('seriesmst');
		$this->db->where('mstrid !=', '1');
		$this->db->delete('createmaster');
		$this->db->truncate('matchmst');
		$this->db->truncate('matchfancy');
		$this->db->truncate('market');
		$this->db->truncate('tblbets');
		$this->db->truncate('tblchipdet');
		$this->db->truncate('tblchips');
		$this->db->truncate('tblresult');
		$this->db->truncate('tblsessionfancy');
		$this->db->truncate('bet_entry');
		$this->db->query("SET FOREIGN_KEY_CHECKS = 1");*/
	}
    
}