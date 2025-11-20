<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
    	parent::__construct();
    	$this->load->model('main_model', 'main');
    	$this->load->library('custom_lib');
		$this->controller = strtolower(__CLASS__);
		
	}

	public function get_notification_count($notifTypeID = 1){
		$info = $this->custom_lib->_require_login();
		$profile = $this->custom_lib->_get_profile();
		$menuColor = $info['menuColor'];
	    $tableColor = $info['tableColor'];
	    $thColor = $info['thColor'];
	    $btnColor = $info['btnColor'];

		$keyID = decode($info['current_keyID']);
		/* $filter = array(
			'a.userID' => decode($info['userID']),
			'd.keyID' => $keyID
		);
		$sloc_access = $this->custom_lib->_get_sloc_access( $filter );
		if($sloc_access){
			$sloc_field = 'a.refID';
			$sloc_arr = array();
			foreach ($sloc_access as $r) {
				$sloc_arr[] = $r->slocID;
			}
		} else {
			$sloc_arr = array(0, 0);
			$sloc_field = 'a.refID';
		} */
		$filter = array(
			'a.keyID' => decode($info['current_keyID'])
		);
		$key_arr = false;
		$key_field = false;
		$join = array(
					'users c' =>	'a.createdBy = c.userID',
					'usernotif d' =>	'a.notifID = d.notifID and d.userID = '.decode($info['userID']).' and d.statusID = 1',
				);
		$order_by = false;
		$group_by = 'd.userID';
		$limit = false;
		$recFound = $this->main->get_join_datatables('notification a', $join, true, $order_by, $group_by, 'count(a.notifID) as count', $filter, $key_field, $key_arr, false, $limit);

		if(!empty($recFound)){
			$count = $recFound->count;
		} else {
			$count = '';
		}
		/**/
		echo json_encode(array('counter' => $count));
		
	}

	public function update_usernotif(){
		$info = $this->custom_lib->_require_login();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$statusID = $this->input->post('statusID');

			$trigger = $this->input->post('trigger');
			$notifID = $this->input->post('notifID');
			$userID = decode($info['userID']);

			if($trigger == 'read'){
				if($notifID){ //INDIVIDUAL NOTIF
					$filter = array('notifID' => $notifID, 'userID' => $userID);
				} else { //SHOW ALL, READ ALL
					$filter = array('userID' => $userID, 'statusID !=' => 15 );
				}
			} elseif ($trigger == 'view') { //WHEN NOTIF ICON IS CLICKED
				$filter = array('userID' => $userID, 'statusID' => 1 );
			} elseif($trigger == 'clear'){
				if(is_array($notifID)){
					foreach ($notifID as $id) {
						
						$filter = array('notifID' => $id, 'userID' => $userID);
						$set = array('statusID' => $statusID);
						$this->main->update_data('usernotif', $set, $filter );
					}
					$item = $this->custom_lib->_get_notifications()->item;
					echo json_encode(array('success' => true, 'item' => $item));
					exit();
				} else {
					$filter = array('notifID' => $notifID, 'userID' => $userID);
				}
			}
			$set = array('statusID' => $statusID);
			$this->main->update_data('usernotif', $set, $filter );
		
			$item = $this->custom_lib->_get_notifications()->item;
			$count = $this->custom_lib->_get_notifications()->counter;
			echo json_encode(array('success' => true, 'item' => $item, 'counter' => $count));
		}
		
	}

	public function logout($msg=null, $userID=null, $empID=null){
		
		
		if(decode($msg) && $userID){
			$set = array(
				'lastLogoutTS' => date_now(),
				'isLogout' => 1,
			);
			$data['empID'] = $empID;
			$this->main->update_data('users', $set, array('userID' => $userID ));
			$msg = '<div class="alert alert-danger">'.decode($msg).'</div>';
			$this->session->set_flashdata('message', $msg);
			$this->load->view('login/login_content', $data);
		} else {
			$info = $this->custom_lib->_require_login();
	
			$set = array('current' => 0);
			$this->main->update_data('userkey', $set, array('userID' => decode($info['userID']) ));
	
			$set = array('current' => 1);
			$this->main->update_data('userkey', $set, array('userkeyID' => decode($info['current_userKeyID']) ));
	
			$set = array(
				'lastLogoutTS' => date_now(),
				'isLogout' => 1,
			);
			$this->main->update_data('users', $set, array('userID' => decode($info['userID']) ));
			$user_logs = array(
				'userID'	=>	decode($info['userID']),
				'userFullName' =>	$info['userFullName'],
				'logTS'	=>	date_now(),
				'page'	=>	'Admin/logout',
				'logDetail'	=>	'Successfully logout'
			);
			$this->main->user_logs($user_logs);
	
			$this->session->unset_userdata(APP_SESS_NAME);
			redirect('login');
		}
	}

	public function _err_page(){
        
        $info = $this->custom_lib->_require_login();
		$data['profile'] = $this->custom_lib->_get_profile();
		//$data['menuColor'] = $info['menuColor'];
	    //$data['tableColor'] = $info['tableColor'];
	    //$data['thColor'] = $info['thColor'];
	    //$data['btnColor'] = $info['btnColor'];
		$data['title']     = "Page 404";
        $data['content']   = $this->load->view('admin/404.php', $data, TRUE);
		$this->load->view('admin/templates', $data);


    }

	public function _error_page(){

		//FOR 500 page error
        
        $info = $this->custom_lib->_require_login();
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = $info['menuColor'];
	    $data['tableColor'] = $info['tableColor'];
	    $data['thColor'] = $info['thColor'];
	    $data['btnColor'] = $info['btnColor'];
		$data['title']     = "Page 500";
        $data['content']   = $this->load->view('admin/500.php', $data, TRUE);
		$this->load->view('admin/templates', $data);


    }

    public function _no_access_page(){
        $info = $this->custom_lib->_require_login();
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = $info['menuColor'];
	    $data['tableColor'] = $info['tableColor'];
	    $data['thColor'] = $info['thColor'];
	    $data['btnColor'] = $info['btnColor'];
		$data['title']     = "Access Denied";
        $data['content']   = $this->load->view('admin/404.php', $data, TRUE);
		$this->load->view('admin/templates', $data);
    }

	public function index(){

		// $module_access = $this->custom_lib->module_access('dashboard');
		// if(!$module_access->view){redirect('admin/logout');}
		//redirect('admin/dashboard/');
		redirect('admin/dashboard/0');
	}

	// public function dashboard (){

		
	// 	$info = $this->custom_lib->_require_login();
	// 	$data['js_file'] = '';
	// 	$data['js_file'] = '';
	// 	$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	//     $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	//     $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	//     $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
	// 	$data['profile'] = $this->custom_lib->_get_profile();

		
		
	// 	$data['title'] = 'Dashboard';
	// 	$data['parent_title'] = '';

		
	// 	$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		
	// 	$data['content'] = $this->load->view('admin/dashboard', $data , TRUE);
	// 	$this->load->view('admin/templates', $data);
	// }

	



	/*  
	module: Users Controller
	desc: CRUD of users (With Module Access Based on User Type)
	date created: 2022-03-14
	created by: Alj
	Change Management 
		1. Date: 
		2. Description:
		3. Modified By:	
	*/
	public function _check_bc_and_sLoc($keyID){
		$info = $this->custom_lib->_require_login();
		//this will return sloc(s) for all bc submitted
		//decode the all bcID
		
		
		foreach($keyID as $key => &$value){
			$value = decode($value); //the same as $array[$key] = 12321;
		}
		
		$key_IDs = implode(",",$keyID);	//convertion of array into string - comma delimited
		
		//run a query to system table to get all unique bcID 
		$sql = 'select bcID from `key` where keyID in ('. $key_IDs .') group by bcID';
		
		$recFound = $this->main->get_query($sql, false, false);
		
		$bcID = array();
		foreach($recFound as $r){
			array_push($bcID, $r->bcID);
		}
		
		$bc_IDs = implode(",",$bcID);	//convertion of array into string - comma delimited
		
		//run a query to system table to get all unique bcID 
		$sql = 'select * from storagelocation inner join cgdtl on cgdtl.sLocID = storagelocation.sLocID inner join vet on cgdtl.vetID = vet.vetID where vet.keyID in ('. $key_IDs .') and storagelocation.statusID IS NOT NULL';
		
		return $this->main->get_query($sql, false, false);
		
	}
	
	public function get_sLoc(){
		
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$keyID = $this->input->post('id');
			if(!empty($keyID)){
				$data['result'] = 0;
			}else{
				$data['result'] = 0;
			}
			echo json_encode($data);
		}
	}
	
	public function loadModuleAccessTemplateGrid($id=null){
		
		$info = $this->custom_lib->_require_login();
		if(decode($info['userTypeLevel']) <= 2){
			$readonly = '';
			$readonly2 = '';
		} else {
			$readonly = 'onclick="return false;" onkeydown="return false;"';
			$readonly2 = 'readonly="readonly"';
		}

		//$myID = is_null($id)?1:decode($id);
		$myID = $id=='null'?1:decode($id);
		
		
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		
		$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0',
					  'modules c' => 'b.moduleID = c.moduleID and c.statusID = 1'
				);
		$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'c.moduleDesc', false, '*','a.userTypeID='.$myID,false);
		
		foreach ($recFound->result() as $r) {
			$checked = ($r->view == 1)?'checked':'';
		    $check_view = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="view[]"' . $checked .' '.$readonly.'>';
		    
			$checked = ($r->add == 1)?'checked':'';
		    $check_add = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="add[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->edit == 1)?'checked':'';
		    $check_edit = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="edit[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->act == 1)?'checked':'';
		    $check_act = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="act[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->post == 1)?'checked':'';
		    $check_post = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="post[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->canc == 1)?'checked':'';
		    $check_canc = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="canc[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->prnt == 1)?'checked':'';
		    $check_prnt = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="prnt[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->ulod == 1)?'checked':'';
		    $check_ulod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="ulod[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->dlod == 1)?'checked':'';
		    $check_dlod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="dlod[]"' . $checked .' '.$readonly.'>';
			
			$checked = ($r->clear == 1)?'checked':'';
			$check_clear = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="clear[]"' . $checked .' '.$readonly.'>';

			$checked = ($r->appr == 1)?'checked':'';
			$check_appr = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="appr[]"' . $checked .' '.$readonly.'>';
			
			$data[] = array(	
				'<input type="checkbox" class="align-middle module-tbl-label" data-id="'.$r->moduleID.'" value="" '.$readonly2.'> <label class="form-check-label">&nbsp;'.$r->moduleDesc.'</label>',
				$check_view,
				$check_add,
				$check_edit,
				$check_act,
				$check_post,
				$check_canc,
				$check_prnt,
				$check_ulod,
				$check_dlod,
				$check_clear,
				$check_appr
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function loadUserModuleAccessGrid($id=null,$keyID=null,$userTypeID=null){
		
		//$myID = is_null($id)?1:decode($id);
		$myID = $id=='null'?1:decode($id);
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();

		$info = $this->custom_lib->_require_login();
		
		
		//get user type
		$join = array('usertype b' => 'a.userTypeID = b.userTypeID');
		$check_user = $this->main->check_join('users a', $join, $row_type=TRUE, $order=FALSE, $group=FALSE, $select=FALSE, array('userID' => $myID));
		if(decode($userTypeID)){
			$userTypeID = decode($userTypeID);
		} else {
			$userTypeID = $check_user['result'] ? $check_user['info']->userTypeID : 0;
		}
		$userTypeLevel = $check_user['result'] ? $check_user['info']->userTypeLevel : 0;
		if(decode($info['userTypeLevel']) <= 2){
			$readonly = '';
			$readonly2 = '';
		} else {
			$readonly = 'onclick="return false;" onkeydown="return false;"';
			$readonly2 = 'readonly="readonly"';
		}
		
		
		//loop preset detail
		$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0',
					  'modules c' => 'b.moduleID = c.moduleID and c.statusID = 1'
				);
		$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'c.moduleDesc asc', false, '*','a.userTypeID='.$userTypeID ,false);
		
		foreach ($recFound->result() as $r) {
		
			//change the value of preset based on saved user module
			$filter = array(
				'userID' => $myID,
				'moduleID' => $r->moduleID,
				'userTypeID' => $userTypeID
			);
			if(decode($keyID)){
				$filter['keyID'] = decode($keyID);
			}
			$userMod = $this->main->check_data('usermodules', $filter, TRUE);
			
			$check_val = $userMod['result'] ? $userMod['info']->view : $r->view;
			$checked = ($check_val == 1)?'checked':'';
		    $check_view = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="view[]"' . $checked .' '.$readonly.'>';
		    
			$check_val = $userMod['result'] ? $userMod['info']->add : $r->add;
			$checked = ($check_val == 1)?'checked':'';
		    $check_add = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="add[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->edit : $r->edit;
			$checked = ($check_val == 1)?'checked':'';
		    $check_edit = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="edit[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->act : $r->act;
			$checked = ($check_val == 1)?'checked':'';
		    $check_act = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="act[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->post : $r->post;
			$checked = ($check_val == 1)?'checked':'';
		    $check_post = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="post[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->canc : $r->canc;
			$checked = ($check_val == 1)?'checked':'';
		    $check_canc = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="canc[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->prnt : $r->prnt;
			$checked = ($check_val == 1)?'checked':'';
		    $check_prnt = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="prnt[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->ulod : $r->ulod;
			$checked = ($check_val == 1)?'checked':'';
		    $check_ulod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="ulod[]"' . $checked .' '.$readonly.'>';
			
			$check_val = $userMod['result'] ? $userMod['info']->dlod : $r->dlod;
			$checked = ($check_val == 1)?'checked':'';
		    $check_dlod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="dlod[]"' . $checked .' '.$readonly.'>';

			$check_val = $userMod['result'] ? $userMod['info']->clear : $r->clear;
			$checked = ($check_val == 1)?'checked':'';
			$check_clear = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="clear[]"' . $checked .' '.$readonly.'>';

			$check_val = $userMod['result'] ? $userMod['info']->appr : $r->appr;
			$checked = ($check_val == 1)?'checked':'';
			$check_appr = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="appr[]"' . $checked .' '.$readonly.'>';
			
			$data[] = array(	
				'<input type="checkbox" class="align-middle module-tbl-label" data-id="'.$r->moduleID.'" value="" '.$readonly2.'> <label class="form-check-label">&nbsp;'.$r->moduleDesc.'</label>',
				$check_view,
				$check_add,
				$check_edit,
				$check_act,
				$check_post,
				$check_canc,
				$check_prnt,
				$check_ulod,
				$check_dlod,
				$check_clear,
				$check_appr
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function get_bcpresetdtl($id=null){
		$info = $this->custom_lib->_require_login();
		$id = clean_data(decode($this->input->post('id')));

		if(!$id){
			$id = 0;
		}

		$bcIDPreset = array();
		$filter = array(
			'presetHdrID' => $id
		);
		$join = array(
			'presethdr b' => 'a.presetHdrID = b.presetHdrID and b.userTypeID = '.$id
		);
		$get_bc_preset = $this->main->get_join('bcpresetdtl a', $join);
		$data_bc = '<option value=""> Select...</option>';
		foreach($get_bc_preset as $r){
			array_push($bcIDPreset,$r->bcID);
		}
		$filter = array(
			'statusID' => 1
		);
		$recFound = $this->main->get_join_datatables('businesscenter a', $join=false, false, 'a.bcName', false, '*', $filter);
		$get_bc = $recFound->result();
		$data_bc	= '<option value="-1"> Select All</option>';
		
		foreach($get_bc as $row){
			
			$selected = in_array($row->bcID, $bcIDPreset) ? 'selected' : '';
			$data_bc .= '<option value="' .encode($row->bcID) .'" ' . $selected. '>'. $row->bcName . '</option>';
		}

		$data['result'] = 1;
		$data['info'] = array(
			'bcID' =>$data_bc
		);

		echo json_encode($data);
		exit();
	}
	
	public function users($userType = false, $statusID = false){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		$data['profile'] = $this->custom_lib->_get_profile();

		$backgroundColorClass = get_user_theme(array('a.userID' => decode($info['userID'])), true)->backgroundColor == 'dark' || get_user_theme(array('a.userID' => decode($info['userID'])), true)->backgroundColor == 'dark2' ? 'bg-dark text-info' : '';
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('users');
		$data['new_button'] = '<div class="row"><div class="col-lg-6">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '<button type="button" class="add-user-btn '.$btn_class.'"><span class="fas fa-plus"></span></button>';
			
		}
		$data['new_button'] .= '<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		if($module_access->ulod){
			$data['new_button'] .= '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Upload Data" class="upload-user-btn '.$btn_class.'"><span class="fas fa-upload"></span></button>';
		}
		$data['new_button'] .= '</div>';

		$data['new_button'] .= '<div class="col-lg-6">';

		$user_status = $this->main->get_data('stats', 'statusID IN (1, 2)');
		
		if($statusID){

			$get_status = $this->main->get_data('stats', array('statusID' => decode($statusID)), FALSE);
			$statDesc = $get_status[0]->statDesc;
		} else {
			//$get_status = $this->main->get_data('stats', array('statusID' => 1), FALSE);
			$statDesc = 'ALL STATUS';
		}
		$data['userStatusID'] = !$statusID ? decode(0) : $statusID;
		$data['userType'] = $userType;

		

		$data['title'] = 'Users';
		$mainLink = 'admin/users/0/';
		$data['haveGcash'] = FALSE;
		$filterUType = array('a.statusID' => 1, 'userTypeLevel >=' => decode($info['userTypeLevel']));
		$filterUType = "a.statusID = 1 and userTypeLevel >= ".decode($info['userTypeLevel'])." and userTypeName NOT IN ('SS', 'COOR')";

		$dropDownArray = $user_status; 
		$dropDownDisplay = $statDesc;
		if(!empty($dropDownArray)){
			$data['new_button'] .= '
				<div class="btn-group dropdown float-right">
					<button type="button" class="btn btn-sm btn-round btn-'.$data['btnColor'].' mb-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-filter mr-1"></i>'.$dropDownDisplay.'
					</button>
					<ul class="dropdown-menu '.$backgroundColorClass.'" role="menu" aria-labelledby="dropdownMenu">';
			$data['new_button'] .= '<li><a class="dropdown-item" href="'.base_url('admin/users').'">ALL STATUS</a></li>';
			foreach($dropDownArray as $r){

				$data['new_button'] .= '<li><a class="dropdown-item" href="'.base_url($mainLink.encode($r->statusID)).'">'.$r->statDesc.'</a></li>';
			}
			$data['new_button'] .= '</ul></div>';
		}
		$data['new_button'] .= '</div></div>';

		if(!$module_access->view){redirect('admin');}
		
		
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Users Config';
		$data['controller']   = $this->controller;
		//select bavi - van salesman
		$where = array('key.statusID' => 1, 'key.buID' => 1);
		$join = array('businessunit ' => 'key.buID = businessunit.buID',
					  'businesscenter ' => 'key.bcID = businesscenter.bcID',
					  'company' => 'key.coID = company.coID'
		);
		$recFound = $this->main->get_join_datatables('key', $join, false, 'key.keyCode', false, 'key.*,key.keyCode,  company.coSDesc, businessunit.buSDesc, businesscenter.bcCode',$where,false);
		$data['key'] = $recFound->result();
		// $data['bc'] = $this->main->get_data('businesscenter', array('statusID' => 1));
		// $data['sLoc'] = $this->main->get_data('storagelocation', array('statusID' => 1));
		// $data['uType'] = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeLevel >=' => decode($info['userTypeLevel'])));
		
		$join 	= array(
			'presethdr b' => 'a.userTypeID = b.userTypeID'
		);
		$select = false;
		$data['uType'] = $this->main->get_join('usertype a', $join, false, 'a.userTypeName', false, $select, $filterUType);

		$data['upline'] = $this->main->get_data('users', array('statusID' => 1, 'userID >' => 0));

		
		//exit();

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/user_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function userGrid($statusID = false, $userType = false){
		$info = $this->custom_lib->_require_login();
		$module_access = $this->custom_lib->module_access('users');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array(
			'usertype b' => array('a.userTypeID = b.userTypeID and a.userTypeID != 0' => 'INNER'),
			'users c' => array('a.userUplineID = c.userID' => 'INNER'),
			'agency_tbl d' => array('a.agencyID = d.agency_id' => 'LEFT'),
		);

		$where = FALSE;
		$where_in_field = FALSE;
		$where_in = array();
		
		if($statusID){
			$where = 'a.statusID = '.decode($statusID);
		}
		if($userType == 'ss' || $userType == 'coor'){
			
			if($where != ''){
				$where .= ' AND b.userTypeName = "'. strtoupper($userType).'"';
			} else {
				$where .= ' b.userTypeName = "'. strtoupper($userType).'"';
			}
		} else {
			
			if($where != ''){
				$where .= ' AND b.userTypeName NOT IN ("ss", "coor")';
			} else {
				$where .= ' b.userTypeName NOT IN ("ss", "coor")';
			}
			
		}
		
		$recFound = $this->main->get_join_datatables('users a', $join, false, 'a.statusID, a.userID DESC', false, 'a.*,b.*, a.statusID as userStatusID, c.userFirstName as uplineFN, c.userLastName as uplineLN, d.agency_name',$where,$where_in_field, $where_in, false, false, false);
		
		$toggle = '';
		$primary_action = '';
		$reset = '';
		$email_switch_status = '';
		$email_switch = '';
		$display = '';
		foreach ($recFound->result() as $r) {
			if(decode($info['userTypeLevel']) <= $r->userTypeLevel){

				if($r->userStatusID == 1){
					
					if($module_access->act){
						$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->userID) . '" data-val="' . $r->userFirstName .'&nbsp;'. $r->userLastName . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
					}
				}elseif($r->userStatusID == 2){
					
					
					if($module_access->act){
						$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->userID) . '" data-val="' . $r->userFirstName .'&nbsp;'. $r->userLastName . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
					}
				}
	
				if($module_access->act){
					$reset = '<a href="" class="reset-user" data-id="'.encode($r->userID).'"><span class="fas fa-redo-alt fa-md"></span></a>';
				}
				
				
				if($module_access->edit){
					$primary_action = '<a href="" class="edit-user" data-id="'.encode($r->userID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
					$primary_action .= '<a href="'.base_url('admin/user-key/'.encode($r->userID)).'" title="Modify User Key Access" class="modify-user-access text-warning" data-id="'.encode($r->userID).'" data-user-type-id="'.$r->userTypeID.'"><span class="fas fa-directions fa-md"></span></a>';
					
					$primary_action .= '<a href="'.base_url('user-store/'.encode($r->userID)).'" title="View Assigned Stores" class="view-assigned-store text-primary"><span class="fas fa-arrow-alt-circle-right fa-md"></span></a>';
					if($r->emailSwitch==1){
						$email_switch = '<a href="" title="Turn Off Email Notif" class="email-switch-off text-danger" data-id="'.encode($r->userID).'"><span class="fas fa-envelope fa-md"></span></a>';
						$email_switch_status = 'ON';
					} else {
						$email_switch = '<a href="" title="Turn On Email Notif" class="email-switch-on text-primary" data-id="'.encode($r->userID).'"><span class="fas fa-envelope-open-text fa-md"></span></a>';
						$email_switch_status = 'OFF';
					}
				} else {
					if($r->emailSwitch==1){
						$email_switch = '';
						$email_switch_status = 'ON';
					} else {
						$email_switch = '';
						$email_switch_status = 'OFF';
					}
				}
				$duplicate = '';
				if($module_access->add){
					$duplicate = '<a href="" class="duplicate-user text-info" data-id="'.encode($r->userID).'"><span class="fas fa-copy fa-md"></span></a>';
				}
			} else {
				$primary_action = '';
				$toggle = '';
				$reset = '';
				$duplicate = '';
				$email_switch = '';
			}
			
			$fname = $r->userTitle ? $r->userTitle.' '.$r->userFirstName : $r->userFirstName;

			$display = $r->userStatusID == 1 ? 'success' : 'warning';
			$badgeDisplayStatus = $r->userStatusID == 1 ? 'ACTIVE' : 'INACTIVE';
			$badge = '<span class="badge badge-'.$display.'">'.$badgeDisplayStatus.'</span>';
			$mobileNumber = !$r->mobileNumber ? '' : $r->mobileNumber;
			$data[] = array(
				$fname,
				$r->userLastName,
				$r->userEmail,
				$r->employeeNo,
				$r->userTypeName,
				$r->uplineFN . '&nbsp;' . $r->uplineLN,
				$email_switch_status,
				time_stamp_display($r->lastLoginTS),
				$mobileNumber,
				$r->agency_name,
				$badge,
				$primary_action.'&nbsp;'.$toggle.'&nbsp;'.$reset.'&nbsp;'.$duplicate.'&nbsp;'.$email_switch
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_user(){

		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userTitle = clean_data($this->input->post('user-title'));
			$userFirstName = clean_data($this->input->post('user-fname'));
			$userLastName = clean_data($this->input->post('user-lname'));
			$userEmail = clean_data($this->input->post('user-email'));
			$password = clean_data($this->input->post('user-password'));
			$emp_id = clean_data($this->input->post('user-employee-no'));
			$keyID = clean_data($this->input->post('key-id'));
			$sLocID = clean_data($this->input->post('sLoc-id'));
			$userTypeID = clean_data($this->input->post('uType-id'));
			$uplineID = clean_data($this->input->post('upline-id'));
			$agencyID = clean_data($this->input->post('agency-id'));
			$mobileNumber = clean_data($this->input->post('mobile-number'));

			$agencyID = !empty($agencyID) ? decode($agencyID) : 0;
			$mobileNumber = !empty($mobileNumber) ? trim(substr($mobileNumber, -10)) : 0;
			
			$view = clean_data($this->input->post('view'));
			$add = clean_data($this->input->post('add'));
			$edit = clean_data($this->input->post('edit'));
			$act = clean_data($this->input->post('act'));
			$post = clean_data($this->input->post('post'));
			$canc = clean_data($this->input->post('canc'));
			$prnt = clean_data($this->input->post('prnt'));
			$ulod = clean_data($this->input->post('ulod'));
			$dlod = clean_data($this->input->post('dlod'));
			$clear = clean_data($this->input->post('clear'));
			$appr = clean_data($this->input->post('appr'));

			$bcID = clean_data($this->input->post('bc-id'));
			$sendEmailNotif = clean_data(decode($this->input->post('send-email-notif')));
			
			//decode the value of arrays		
			//for view
			if(!empty($view)){
				foreach($view as $key => &$value){$value = decode($value);}
				//the same as $array[$key] = 12321;
				unset($value);
			}
			//for add
			if(!empty($add)){
				foreach($add as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for edit
			if(!empty($edit)){
				foreach($edit as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for act
			if(!empty($act)){
				foreach($act as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for post
			if(!empty($post)){
				foreach($post as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for canc
			if(!empty($canc)){
				foreach($canc as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for prnt
			if(!empty($prnt)){
				foreach($prnt as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for ulod
			if(!empty($ulod)){
				foreach($ulod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for dlod
			if(!empty($dlod)){
				foreach($dlod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for clear
			if(!empty($clear)){
				foreach($clear as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for appr
			if(!empty($appr)){
				foreach($appr as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//check for required fields
			if(!empty($userFirstName) && !empty($userLastName) && !empty($userEmail) && !empty($password) && !empty($emp_id) && !empty($userTypeID) && !empty($keyID)){
				$check_email = $this->main->check_data('users', array('userEmail' =>  $userEmail));
				if($check_email == FALSE){
					$check_mobile_no['result'] = FALSE;
					if($mobileNumber != 0){
						$check_mobile_no = $this->main->check_data('users', array('mobileNumber' =>  $mobileNumber), TRUE);
					}
					if($check_mobile_no['result'] == FALSE){
						$check_empID = $this->main->check_data('users', array('employeeNo' =>  $emp_id));
						if($check_empID == FALSE){
	
							$set = array(
								'userTitle' => strtoupper($userTitle),
								'userFirstName' => strtoupper($userFirstName),
								'userLastName' => strtoupper($userLastName),
								'userEmail' => $userEmail,
								'password' => encode($password),
								'employeeNo' => $emp_id,
								'agencyID' => $agencyID,
								'mobileNumber' => $mobileNumber,
								'userTypeID' => decode($userTypeID),
								'userUplineID' => decode($uplineID),
								'statusID' => 1,
								'themeID'  => 1
							);
	
							$result = $this->main->insert_data('users', $set, TRUE);
							//get new user ID
							$userID = @$result['id'];
							
	
							//INSERT DEFAULT USER THEME
							$set = array(
								'userID' => $userID,
								'backgroundColor' => 'bg3',
								'sideBarColor' => 'blue2',
								'topBarColor' => 'white',
								'logoHeaderColor' => 'blue',
								'btnColor' => 'danger',
								'menuColor' => 'danger',
								'tableColor' => 'danger',
								'thColor' => 'danger',
								'statusID' => 1
							);
							$result = $this->main->insert_data('usertheme', $set, TRUE);
							
							if($result == FALSE){
								$msg = '<div class="alert alert-danger">Error in User Enrollment Please Call for Support!</div>';
							}else{
								
								
								//save preset module ID to user modules
								$myID = decode($userTypeID);
								$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0', 'modules c' => 'b.moduleID = c.moduleID');
								$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'b.presetDtlID', false, '*','a.userTypeID='.$myID,false,false,false,false,false);
								
								$result_usermodule=true;
	
								
								
								foreach ($recFound->result() as $r) {
									$check_userModule = $this->main->check_data('usermodules', array('userID' =>  $userID, 'moduleID'	=>	$r->moduleID), TRUE);
									
									if($check_userModule['result'] == FALSE){
										
										//find moduleID in arrays of check box
										if(is_array($view)){$view_val = in_array($r->moduleID,$view) ? 1 : 0;}else{$view_val=0;}
										if(is_array($add )){$add_val  = in_array($r->moduleID,$add ) ? 1 : 0;}else{$add_val=0;}
										if(is_array($edit)){$edit_val = in_array($r->moduleID,$edit) ? 1 : 0;}else{$edit_val=0;}
										if(is_array($act )){$act_val  = in_array($r->moduleID,$act ) ? 1 : 0;}else{$act_val=0;}
										if(is_array($post)){$post_val = in_array($r->moduleID,$post) ? 1 : 0;}else{$post_val=0;}
										if(is_array($canc)){$canc_val = in_array($r->moduleID,$canc) ? 1 : 0;}else{$canc_val=0;}
										if(is_array($prnt)){$prnt_val = in_array($r->moduleID,$prnt) ? 1 : 0;}else{$prnt_val=0;}
										if(is_array($ulod)){$ulod_val = in_array($r->moduleID,$ulod) ? 1 : 0;}else{$ulod_val=0;}
										if(is_array($dlod)){$dlod_val = in_array($r->moduleID,$dlod) ? 1 : 0;}else{$dlod_val=0;}
										if(is_array($clear)){$clear_val = in_array($r->moduleID,$clear) ? 1 : 0;}else{$clear_val=0;}
										if(is_array($appr)){$appr_val = in_array($r->moduleID,$appr) ? 1 : 0;}else{$appr_val=0;}
										
										foreach ($keyID as $row) {
										
											$keyID_val = decode($row);
											//setup an array for data insertion
											$set_user_module = array(
												'userID' 	=> $userID,
												'moduleID' 	=> $r->moduleID,
												'keyID'		=> $keyID_val,
												'userTypeID'=> decode($userTypeID),
												'statusID' 	=> 1,
												'createdTS' => date_now(),
												'view' 		=> $view_val,
												'add' 		=> $add_val,
												'edit' 		=> $edit_val,
												'act' 		=> $act_val,
												'post' 		=> $post_val,
												'canc' 		=> $canc_val,
												'prnt' 		=> $prnt_val,
												'ulod' 		=> $ulod_val,
												'dlod' 		=> $dlod_val,
												'clear' 	=> $clear_val,
												'appr' 		=> $appr_val
											);
	
											
																				
											$result = $this->main->insert_data('usermodules', $set_user_module, true);
											if($result == FALSE){
												$result_usermodule=FALSE;
											}
										}
									}
								}
	
								$result_bcpresetdtl_flag=true;
								$this->main->void_table('userbc', array('userID' =>  $userID));
								foreach($bcID as $r){
									$bcIDVal = decode($r);
									$set = array(
										'userID' => $userID,
										'bcID' 		=> $bcIDVal,
										'statusID' => 1,
										'createdTS' => date_now()
									);
									$result_bcpresetdtl = $this->main->insert_data('userbc', $set, true);
									if($result_bcpresetdtl == FALSE){
										$result_bcpresetdtl_flag=FALSE;
									}
								}
								if($result_bcpresetdtl_flag == FALSE){
									$msg = '<div class="alert alert-danger">Error in User BC Enrollment Please Call for Support!</div>';
								}
								
								$result_userkey=true;
								if($result_usermodule == FALSE){
									$msg = '<div class="alert alert-danger">Error in User Modules Enrollment Please Call for Support!</div>';
								}else{
									//add each user's bc
									foreach ($keyID as $r) {
										
										$keyID_val = decode($r);
										//check for existing data
										$check_userKey = $this->main->check_data('userkey', array('userID' =>  $userID, 'keyID'	=>	$keyID_val), TRUE);
	
										if($check_userKey['result'] == FALSE){
											$set_key = array(
												'userID' => $userID,
												'keyID' => $keyID_val,
												'createdTS' => date_now(),
												'statusID' => 1
											);
	
											$result = $this->main->insert_data('userkey', $set_key);
											if($result == FALSE){
												$result_userkey=FALSE;
											}
										}
									}
								}
								
								$result_usersloc=true;
								if($result_userkey == FALSE){
									$msg = '<div class="alert alert-danger">Error in User BC Enrollment Please Call for Support!</div>';
								}else{
									//add each user's sloc
									if(!empty($sLocID)){
										foreach ($sLocID as $r) {
											$sLocID_val = decode($r);
											$check_userSloc = $this->main->check_data('usersloc', array('userID' =>  $userID, 'slocID'	=>	$sLocID_val), TRUE);
											if($check_userSloc['result'] == FALSE){
												$set_sLoc = array(
													'userID' => $userID,
													'sLocID' => $sLocID_val,
													'createdTS' => date_now(),
													'statusID' => 1
												);
		
												$result = $this->main->insert_data('usersloc', $set_sLoc);
												if($result == FALSE){
													$result_usersloc=FALSE;
												}
											}
										}
									}
								}
								
								if($result_usersloc == FALSE){
									$msg = '<div class="alert alert-danger">Error in User SLoc Enrollment Please Call for Support!</div>';
								}else{
								
									$user_logs = array(
										'userID'	=>	decode($info['userID']),
										'userFullName' =>	$info['userFullName'],
										'logTS'	=>	date_now(),
										'page'	=>	'Admin/add_user',
										'logDetail'	=>	'Successfully added User ID:'.@$userID
									);
									$this->main->user_logs($user_logs);
									$msg = '<div class="alert alert-success">User successfully added.</div>';
									if($sendEmailNotif==1){
										$combiName = $userTitle ? $userTitle.' '.$userFirstName : $userFirstName;
										$this->_user_email_notif(strtoupper($combiName), $userEmail, $password, $msg, 'new');
									}
								}
							}
						}else{
							$msg = '<div class="alert alert-danger">Error employee no. already exist.</div>';
						}
					} else {
						$msg = '<div class="alert text-black alert-danger">Error mobile no. already exist.</div>';
					}
				}else{
					$msg = '<div class="alert alert-danger">Error email already exist.</div>';
				}
				
			}else{
				$msg = '<div class="alert alert-danger">Error make sure all fields are filled up.</div>';
			}

			$this->session->set_flashdata('message', $msg);

			$userTypeName = $this->main->get_data('usertype', array('userTypeID' => decode($userTypeID) ), TRUE )->userTypeName;
			switch ($userTypeName) {
				case 'SS':
					redirect('admin/users-ss/'.encode(1));
					break;
				case 'COOR':
					redirect('admin/users-coor/'.encode(1));
					break;
				default:
					redirect('admin/users/'.encode(1));
					break;
			}
			
		}else{
			redirect('admin');
		}
	}

	public function modal_user(){
		$info = $this->custom_lib->_require_login();
		
		$id = decode($this->input->post('id'));
		//$id=29;
		$check_user = $this->main->check_data('users', array('userID' => $id), TRUE);
		
		if($check_user['result'] == TRUE){
			//get user BCs
			$userkeyID = array();
			$get_user_key 	= $this->main->get_data('userkey', array('userID'=> $id,'statusID' => 1));
			
			//load into new array
			foreach($get_user_key as $i){
				array_push($userkeyID,$i->keyID);
			}
			
			$where = array('key.statusID' => 1, 'key.buID' => 1);
			$join = array('businessunit ' => 'key.buID = businessunit.buID',
						  'businesscenter ' => 'key.bcID = businesscenter.bcID',
						  'company' => 'key.coID = company.coID'
			);
			
			 
			$recFound = $this->main->get_join_datatables('key', $join, false, 'key.keyCode', false, 'key.*,key.keyCode,  company.coSDesc, businessunit.buSDesc, businesscenter.bcCode',$where,false);
			
			$get_key = $recFound->result();
			$data_key	= '<option value="-1"> Select All</option>';
			
			foreach($get_key as $row){
				
				$selected = in_array($row->keyID, $userkeyID) ? 'selected' : '';
				$data_key .= '<option value="' .encode($row->keyID) .'" ' . $selected. '>'. $row->keyCode . ' : ' . $row->coSDesc . ' - '. $row->buSDesc . ' [' . $row->bcCode .']' . '</option>';
			}
			
			//get user SLocs
			$uSlocID = array();	
			$get_user_sloc 	= $this->main->get_data('usersloc', array('userID'=> $id,'statusID' => 1));
			
			//load into new array
			foreach($get_user_sloc as $i){
				array_push($uSlocID,$i->slocID);
			}
			
			$get_sloc	= $this->main->get_data('storagelocation', array('statusID !=' => NULL));
			$data_sloc 	= '<option value="-1"> Select All</option>';
			
			foreach($get_sloc as $row){
				if(in_array($row->slocID, $uSlocID)){
					$data_sloc .= '<option value="' . encode($row->slocID) . '" selected>' . $row->slocName . '</option>';
				}else{
					$data_sloc .= '<option value="' . encode($row->slocID) . '">' . $row->slocName . '</option>';
				}
			}
			
			//get upline 
			$get_upline = $this->main->get_data('users', array('statusID' => 1, 'userID !=' => $id));
			$data_upline = '';
			
			
			foreach($get_upline as $row){
				
				$selected = ($check_user['info']->userUplineID == $row->userID) ? 'selected' : '';
				
				$uplineName = $row->userID == 1 ? ' NOT AVAILABLE' : $row->userFirstName . '&nbsp;' . $row->userLastName;
				
				$data_upline .= '<option value="'.encode($row->userID).'" '. $selected .'>'. $uplineName .'</option>';
			}
			
			//get user type
			$filter = array('a.statusID' => 1, 'userTypeLevel >=' => decode($info['userTypeLevel']));
			$join 	= array(
				'presethdr b' => 'a.userTypeID = b.userTypeID'
			);
			$select = false;
			$get_uType = $this->main->get_join('usertype a', $join, false, 'a.userTypeName', false, $select, $filter);
			$data_uType = '';
			
			$userTypeName = '';
			foreach($get_uType as $row){
				if($row->userTypeID == $check_user['info']->userTypeID){
					$userTypeName = $row->userTypeName;
					$data_uType .= '<option value="' . encode($row->userTypeID) . '" selected>' . $row->userTypeName . '</option>';
				}else{
					$data_uType .= '<option value="' . encode($row->userTypeID) . '">' . $row->userTypeName . '</option>';
				}
			}

			$data_agency = '';
			if($userTypeName == 'SS' || $userTypeName == 'COOR'){
				$filter = array('a.agency_status' => 1);
				$get_agency = $this->main->get_data('agency_tbl a', $filter, false, false, 'a.agency_name');
				
				foreach($get_agency as $row){
					if($row->agency_id == $check_user['info']->agencyID){
						
						$data_agency .= '<option value="' . encode($row->agency_id) . '" selected>' . $row->agency_name . '</option>';
					}else{
						$data_agency .= '<option value="' . encode($row->agency_id) . '">' . $row->agency_name . '</option>';
					}
				}
			}


			$bcIDPreset = array();
			$filter = array(
				'userID' => $id
			);
			$get_user_bc = $this->main->get_data('userbc', $filter);
			//$data_bc = '<option value=""> Select...</option>';
			foreach($get_user_bc as $r){
				array_push($bcIDPreset,$r->bcID);
			}
			$filter = array(
				'statusID' => 1
			);
			$recFound = $this->main->get_join_datatables('businesscenter a', $join=false, false, 'a.bcName', false, '*', $filter);
			$get_bc = $recFound->result();
			$data_bc	= '<option value="-1"> Select All</option>';
			
			foreach($get_bc as $row){
				
				$selected = in_array($row->bcID, $bcIDPreset) ? 'selected' : '';
				$data_bc .= '<option value="' .encode($row->bcID) .'" ' . $selected. '>'. $row->bcName . '</option>';
			}
			
			//load data to json
			$data['result'] = 1;
			$data['info'] = array(
				'userID'	=>		$check_user['info']->userID,
				'title'		=>		$check_user['info']->userTitle,
				'fname'		=>		$check_user['info']->userFirstName,
				'lname'		=>		$check_user['info']->userLastName,
				'email'		=>		$check_user['info']->userEmail,
				'employeeNo'=>		$check_user['info']->employeeNo,
				'keyID'		=>		$data_key,
				'slocID'	=>		$data_sloc,
				'uTypeID'	=>		$data_uType,
				'uplineID'	=>		$data_upline,
				'userTypeName'	=>		$userTypeName,
				'mobileNumber'	=>		$check_user['info']->mobileNumber,
				'agencyID'	=>		$data_agency,
				'bcID'		=>		$data_bc
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
		exit();
	}

	public function update_user(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userID = decode($this->input->post('id'));
			$userTitle = clean_data($this->input->post('user-title'));
			$userFirstName = clean_data($this->input->post('user-fname'));
			$userLastName = clean_data($this->input->post('user-lname'));
			$userEmail = clean_data($this->input->post('user-email'));
			$emp_id = clean_data($this->input->post('user-employee-no'));
			$keyID = clean_data($this->input->post('key-id'));
			$userModKeyID = clean_data($this->input->post('key-id'));
			$sLocID = clean_data($this->input->post('sLoc-id'));
			$userTypeID = clean_data($this->input->post('uType-id'));
			$uplineID = clean_data($this->input->post('upline-id'));
			$agencyID = clean_data($this->input->post('agency-id'));
			$mobileNumber = clean_data($this->input->post('mobile-number'));

			$agencyID = !empty($agencyID) ? decode($agencyID) : 0;
			$mobileNumber = !empty($mobileNumber) ? trim(substr($mobileNumber, -10)) : 0;
			
			$view = clean_data($this->input->post('view'));
			$add = clean_data($this->input->post('add'));
			$edit = clean_data($this->input->post('edit'));
			$act = clean_data($this->input->post('act'));
			$post = clean_data($this->input->post('post'));
			$canc = clean_data($this->input->post('canc'));
			$prnt = clean_data($this->input->post('prnt'));
			$ulod = clean_data($this->input->post('ulod'));
			$dlod = clean_data($this->input->post('dlod'));
			$clear = clean_data($this->input->post('clear'));
			$appr = clean_data($this->input->post('appr'));

			$bcID = clean_data($this->input->post('bc-id'));
			$userStatusID = clean_data($this->input->post('userStatusID'));

			$ignoreUserModule = 0; //always not ignore
			//decode the value of arrays		
			//for view
			if(!empty($view)){
				foreach($view as $key => &$value){$value = decode($value);}
				//the same as $array[$key] = 12321;
				unset($value);
			}
			//for add
			if(!empty($add)){
				foreach($add as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for edit
			if(!empty($edit)){
				foreach($edit as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for act
			if(!empty($act)){
				foreach($act as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for post
			if(!empty($post)){
				foreach($post as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for canc
			if(!empty($canc)){
				foreach($canc as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for prnt
			if(!empty($prnt)){
				foreach($prnt as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for ulod
			if(!empty($ulod)){
				foreach($ulod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for dlod
			if(!empty($dlod)){
				foreach($dlod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for clear
			if(!empty($clear)){
				foreach($clear as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for appr
			if(!empty($appr)){
				foreach($appr as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//check for required fields
			if(!empty($userFirstName) && !empty($userLastName) && !empty($userEmail) && !empty($emp_id)&& !empty($keyID)&& !empty($userTypeID)){
				
				$check_email = $this->main->check_data('users', array('userEmail' =>  $userEmail,	'userID !='	=>	$userID), TRUE);
				
				if($check_email['result'] == FALSE){
					$check_mobile_no['result'] = FALSE;
					
					if($mobileNumber != 0 || $mobileNumber){
						$check_mobile_no = $this->main->check_data('users', array('mobileNumber' =>  $mobileNumber, 'userID !='	=>	$userID), TRUE, false, FALSE);
						
					}
					
					if($check_mobile_no['result'] == FALSE){

						$check_empID = $this->main->check_data('users', array('employeeNo' =>  $emp_id, 'userID !='	=>	$userID), TRUE);
						
						if($check_empID['result'] == FALSE){
	
							$set = array(
								'userTitle' => strtoupper($userTitle),
								'userFirstName' => strtoupper($userFirstName),
								'userLastName' => strtoupper($userLastName),
								'userEmail' => $userEmail,
								'employeeNo' => $emp_id,
								'agencyID' => $agencyID,
								'mobileNumber' => $mobileNumber,
								'userTypeID' => decode($userTypeID),
								'userUplineID' => decode($uplineID),
								'modifiedTS' =>	date_now()
							);
	
							$result = $this->main->update_data('users', $set, array('userID' => $userID));
	
							//CHECK USER THEME
							$check_user_theme = $this->main->check_data('usertheme', array('userID' =>  $userID), TRUE, FALSE, FALSE);
							if(!$check_user_theme['result']){
								
								$set = array(
									'userID' => $userID,
									'backgroundColor' => 'bg3',
									'sideBarColor' => 'blue2',
									'topBarColor' => 'white',
									'logoHeaderColor' => 'blue',
									'btnColor' => 'danger',
									'menuColor' => 'danger',
									'tableColor' => 'danger',
									'thColor' => 'danger',
									'statusID' => 1
								);
								$result = $this->main->insert_data('usertheme', $set, TRUE);
							}
	
							if($result == FALSE){
								$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
							}else{
								$result_usermodule=true;
								if(!$ignoreUserModule){
	
									//update user modules
									$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0', 'modules c' => 'b.moduleID = c.moduleID');
									$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'b.presetDtlID', false, '*','a.userTypeID='.decode($userTypeID),false);
		
									$this->main->void_table('usermodules', array('userID' =>  $userID));
									
									foreach ($recFound->result() as $r) {
		
										
										//find moduleID in arrays of check box
										if(is_array($view)){$view_val = in_array($r->moduleID,$view) ? 1 : 0;}else{$view_val=0;}
										if(is_array($add )){$add_val  = in_array($r->moduleID,$add ) ? 1 : 0;}else{$add_val=0;}
										if(is_array($edit)){$edit_val = in_array($r->moduleID,$edit) ? 1 : 0;}else{$edit_val=0;}
										if(is_array($act )){$act_val  = in_array($r->moduleID,$act ) ? 1 : 0;}else{$act_val=0;}
										if(is_array($post)){$post_val = in_array($r->moduleID,$post) ? 1 : 0;}else{$post_val=0;}
										if(is_array($canc)){$canc_val = in_array($r->moduleID,$canc) ? 1 : 0;}else{$canc_val=0;}
										if(is_array($prnt)){$prnt_val = in_array($r->moduleID,$prnt) ? 1 : 0;}else{$prnt_val=0;}
										if(is_array($ulod)){$ulod_val = in_array($r->moduleID,$ulod) ? 1 : 0;}else{$ulod_val=0;}
										if(is_array($dlod)){$dlod_val = in_array($r->moduleID,$dlod) ? 1 : 0;}else{$dlod_val=0;}
										if(is_array($clear)){$clear_val = in_array($r->moduleID,$clear) ? 1 : 0;}else{$clear_val=0;}
										if(is_array($appr)){$appr_val = in_array($r->moduleID,$appr) ? 1 : 0;}else{$appr_val=0;}
																			
										//setup an array for data update/insert
		
										//loop submitted user role key
										foreach($userModKeyID as $row_key){
		
											$userModKeyIDVal = decode($row_key);
		
											$set_user_module = array(
												'userID' 	=> $userID,
												'moduleID' 	=> $r->moduleID,
												'keyID'		=> $userModKeyIDVal,
												'userTypeID'	=> decode($userTypeID),
												'statusID' 	=> 1,
												'createdTS' => date_now(),
												'view' 		=> $view_val,
												'add' 		=> $add_val,
												'edit' 		=> $edit_val,
												'act' 		=> $act_val,
												'post' 		=> $post_val,
												'canc' 		=> $canc_val,
												'prnt' 		=> $prnt_val,
												'ulod' 		=> $ulod_val,
												'dlod' 		=> $dlod_val,
												'clear' 	=> $clear_val,
												'appr' 		=> $appr_val
											);
			
			
												
											$check_userModule = $this->main->check_data('usermodules', array('userID' =>  $userID, 'moduleID'	=>	$r->moduleID, 'keyID' => $userModKeyIDVal), TRUE);
											
											if($check_userModule['result'] == FALSE){
												//insert
												$result = $this->main->insert_data('usermodules', $set_user_module);
												
											}else{
												//update
												$where = array(
													'userID' => $userID,
													'moduleID' => $r->moduleID,
													'keyID'		=> $userModKeyIDVal,
													'userTypeID'	=> decode($userTypeID),
												);
												$result = $this->main->update_data('usermodules', $set_user_module, $where);
											}
											
											if($result == FALSE){
												$result_usermodule=FALSE;
											}
										}
									} //end of user module loop
								}
	
								$result_bcpresetdtl_flag=true;
								$this->main->void_table('userbc', array('userID' =>  $userID));
								foreach($bcID as $r){
									$bcIDVal = decode($r);
									$set = array(
										'userID' => $userID,
										'bcID' 		=> $bcIDVal,
										'statusID' => 1,
										'createdTS' => date_now()
									);
									$result_bcpresetdtl = $this->main->insert_data('userbc', $set, true);
									if($result_bcpresetdtl == FALSE){
										$result_bcpresetdtl_flag=FALSE;
									}
								}
								if($result_bcpresetdtl_flag == FALSE){
									$msg = '<div class="alert text-black alert-danger">Error in User BC Enrollment Please Call for Support!</div>';
								}
								
								$result_userkey=true;
								if($result_usermodule == FALSE){
									$msg = '<div class="alert text-black alert-danger">Error in Updating User Modules! Please Call for Support!</div>';
								}else{
									
									//deactivate all user key
									$set_key = array('statusID' => 2);
									$where = array(
										'userID' => $userID
									);
									$this->main->update_data('userkey', $set_key, $where);
									
									//add each user's key
									foreach ($keyID as $r) {
										
										$keyID_val = decode($r);
										//check for existing data
										$check_userKey = $this->main->check_data('userkey', array('userID' =>  $userID, 'keyID'	=>	$keyID_val), TRUE);
										
										if($check_userKey['result'] == true){
											//if found - activate
											$set_key = array('statusID' => 1);
											$where = array(
												'userID' => $userID,
												'keyID'=> $keyID_val
											);
											
											$result = $this->main->update_data('userkey', $set_key, $where);
											
										}else{
											//insert data
											$set_key = array(
												'userID' => $userID,
												'keyID' => $keyID_val,
												'createdTS' => date_now(),
												'statusID' => 1
											);
	
											$result = $this->main->insert_data('userkey', $set_key);
											
										}
										//check result
										if($result == FALSE){
											$result_userkey=FALSE;
										}
									}
								}
								
								$result_usersloc=true;
								if($result_userkey == FALSE){
									$msg = '<div class="alert text-black alert-danger">Error in Updating User Key! Please Call for Support!</div>';
								}else{
									
									//deactivate all user sloc
									$set_sLoc = array('statusID' => 2);
									$where = array(
										'userID' => $userID
									);
									$this->main->update_data('usersloc', $set_sLoc, $where);
									
									//add each user's sloc
									if(!empty($sLocID)){
										foreach ($sLocID as $r) {
											
											$sLocID_val = decode($r);
											//check for existing data
											$check_userSloc = $this->main->check_data('usersloc', array('userID' =>  $userID, 'slocID'	=>	$sLocID_val), TRUE);
											
											if($check_userSloc['result'] == true){
												//if found - activate
												$set_sLoc = array('statusID' => 1);
												$where = array(
													'userID' => $userID,
													'slocID'=> $sLocID_val
												);
												
												$result = $this->main->update_data('usersloc', $set_sLoc, $where);
												
											}else{
												$set_sLoc = array(
													'userID' => $userID,
													'sLocID' => $sLocID_val,
													'createdTS' => date_now(),
													'statusID' => 1
												);
		
												$result = $this->main->insert_data('usersloc', $set_sLoc);
											}
											//check result
											if($result == FALSE){
												$result_usersloc=FALSE;
											}
										}
									}
								}
								
															
								if($result_usersloc == FALSE){
									$msg = '<div class="alert text-black alert-danger">Error in Updating User SLoc! Please Call for Support!</div>';
								}else{
									
									$user_logs = array(
										'userID'	=>	decode($info['userID']),
										'userFullName' =>	$info['userFullName'],
										'logTS'	=>	date_now(),
										'page'	=>	'Admin/update_user',
										'logDetail'	=>	'Successfully updated User ID:'.@$userID
									);
									
									
									$this->main->user_logs($user_logs);
									$msg = '<div class="alert text-black alert-success">User updated.</div>';
									
	
								}
							}
						}else{
							$msg = '<div class="alert text-black alert-danger">Error employee no. already exist.</div>';
						}
					} else {
						$msg = '<div class="alert text-black alert-danger">Error mobile no. already exist.</div>';
					}

				}else{
					$msg = '<div class="alert text-black alert-danger">Error email already exist.</div>';
				}

				
			}else{
				$msg = '<div class="alert text-black alert-danger">Error make sure all fields are filled up.</div>';
			}

			$this->session->set_flashdata('message', $msg);
			//redirect('admin/users/'.$userStatusID);
			$userTypeName = $this->main->get_data('usertype', array('userTypeID' => decode($userTypeID) ), TRUE )->userTypeName;
			switch ($userTypeName) {
				case 'SS':
					redirect('admin/users-ss/'.encode(1));
					break;
				case 'COOR':
					redirect('admin/users-coor/'.encode(1));
					break;
				default:
					redirect('admin/users/'.encode(1));
					break;
			}
		}else{
			redirect('admin');
		}
	}

	public function deactivate_user(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userID = decode(clean_data($this->input->post('id')));
			$userStatusID = clean_data($this->input->post('userStatusID'));
			if(!empty($userID)){
				$check_admin_user = $this->main->check_data('users', array('userID' => $userID, 'statusID' => 1));
				if($check_admin_user == TRUE){
					$set = array('statusID' => 2);
					$where = array('userID' => $userID);

					$result = $this->main->update_data('users', $set, $where);
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_user',
							'logDetail'	=>	'Successfully deactivated User ID:'.@$userID
						);
				        $this->main->user_logs($user_logs);
						$msg = '<div class="alert text-black alert-success">User successfully deactivated.</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/users/'.$userStatusID);
					}else{
						$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/users/'.$userStatusID);
					}
				}else{
					$msg = '<div class="alert text-black alert-danger">Error user already inactive!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/users/'.$userStatusID);
				}
			}else{
				$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/users/'.$userStatusID);
			}
		}else{
			redirect('admin');
		}
	}

	public function activate_user(){
		$info = $this->custom_lib->_require_login();

		$param = $this->uri->segment(3);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userID = decode(clean_data($this->input->post('id')));
			$userStatusID = clean_data($this->input->post('userStatusID'));
			if(!empty($userID)){
				$check_admin_user = $this->main->check_data('users', array('userID' => $userID, 'statusID' => 2));
				if($check_admin_user == TRUE){
					$set = array('statusID' => 1);
					$where = array('userID' => $userID);

					$result = $this->main->update_data('users', $set, $where);
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/activate_user',
							'logDetail'	=>	'Successfully activated User ID:'.@$userID
						);
				        $this->main->user_logs($user_logs);
						$msg = '<div class="alert text-black alert-success">User successfully activated.</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/users/'.$userStatusID);
					}else{
						$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
						$this->session->set_flashdata('message', $msg);
						redirect('admin/users/'.$userStatusID);
					}
				}else{
					$msg = '<div class="alert text-black alert-danger">Error user already active!</div>';
					$this->session->set_flashdata('message', $msg);
					redirect('admin/users/'.$userStatusID);
				}
			}else{
				$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
				$this->session->set_flashdata('message', $msg);
				redirect('admin/users/'.$userStatusID);
			}
		}else{
			redirect('admin');
		}
	}

	public function user_email_switch_off(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userID = decode(clean_data($this->input->post('id')));
			if(!empty($userID)){
				$check_admin_user = $this->main->check_data('users', array('userID' => $userID, 'emailSwitch' => 2));
				if($check_admin_user == FALSE){
					$set = array('emailSwitch' => 2);
					$where = array('userID' => $userID);

					$result = $this->main->update_data('users', $set, $where);
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/user_email_switch_off',
							'logDetail'	=>	'Successfully turn off email of User ID:'.@$userID
						);
				        $this->main->user_logs($user_logs);
						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'User email switch off successfully.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps, please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
						'success'       =>    false,
						'successMsg'    =>    'Opps, user email already switch off.'
					));
				}
			}else{
				
				echo json_encode(array(
					'success'       =>    false,
					'successMsg'    =>    'Opps, please try again!'
				));
			}
		}else{
			echo json_encode(array(
				'success'       =>    false,
				'successMsg'    =>    'Opps, please try again!'
			));
		}
	}

	public function user_email_switch_on(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userID = decode(clean_data($this->input->post('id')));
			if(!empty($userID)){
				$check_admin_user = $this->main->check_data('users', array('userID' => $userID, 'emailSwitch' => 1));
				if($check_admin_user == FALSE){
					$set = array('emailSwitch' => 1);
					$where = array('userID' => $userID);

					$result = $this->main->update_data('users', $set, $where);
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/user_email_switch_on',
							'logDetail'	=>	'Successfully turn on email of User ID:'.@$userID
						);
				        $this->main->user_logs($user_logs);
						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'User email switch on successfully.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps, please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
						'success'       =>    false,
						'successMsg'    =>    'Opps, user email already switch on.'
					));
				}
			}else{
				
				echo json_encode(array(
					'success'       =>    false,
					'successMsg'    =>    'Opps, please try again!'
				));
			}
		}else{
			echo json_encode(array(
				'success'       =>    false,
				'successMsg'    =>    'Opps, please try again!'
			));
		}
	}

	public function update_password(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id = decode($this->input->post('id'));
			$password = clean_data($this->input->post('password'));
			$password2 = clean_data($this->input->post('password2'));
			$userStatusID = clean_data($this->input->post('userStatusID'));

			if(!empty($id) && !empty($password) && !empty($password2)){
				if($password == $password2){
					$check_name = $this->main->check_data('users', array('userID' => $id), TRUE);
					if($check_name['result'] == TRUE){
						$set = array(
							'password' => encode($password),
							'userReset' => 1
						);

						$where = array('userID' => $id);
						$result = $this->main->update_data('users', $set, $where);
						if($result == TRUE){
							$user_logs = array(
								'userID'	=>	decode($info['userID']),
								'userFullName' =>	$info['userFullName'],
								'page'	=>	'Admin/update_password',
								'logTS'	=>	date_now(),
								'logDetail'	=>	'Reset successfull on userID: '.@$id
							);
			                $this->main->user_logs($user_logs);

							$msg = '<div class="alert text-black alert-success">User password has been reset.</div>';
							if($check_name['info']->userEmail){
								$this->_user_email_notif($check_name['info']->userFirstName, $check_name['info']->userEmail, $password, $msg, 'reset');
							}
						}else{
							$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
						}
					}else{
						$msg = '<div class="alert text-black alert-danger">Error please try again!</div>';
					}
				}else{
					$msg = '<div class="alert text-black alert-danger">Error password didnt match.</div>';
				}
			}else{
				$msg = '<div class="alert text-black alert-danger">Error make sure all fields are fill up.</div>';
			}

			$this->session->set_flashdata('message', $msg);
			redirect('admin/users/'.$userStatusID);
		}else{
			redirect('admin');
		}
	}

	public function _user_email_notif ($firstname, $email, $uPassword, $msg_out, $identifier){
		$info = $this->custom_lib->_require_login();
		//$expThColor = expColor($info['thColor'])->expThColor;
        //$expFontColor = expColor($info['thColor'])->expFontColor;

		$expThColor = EMAIL_SKIN;
        $expFontColor = EMAIL_SKIN_FONT_COLOR;
        $page_name = "Admin/_".$identifier."_user_email_notif";

        $table_data = '
        	<table border="0" width="100%">
				<tr>
					<td width="20%"> Email : </th>
					<td> '.$email.' </td>
				</tr>
				<tr>
					<td width="20%"> Password&nbsp;: </th>
					<td> '.$uPassword.' </td>
				</tr>
			</table>';

        if ($identifier == 'new') {
        	$message = "This is to inform you that ".$info['userFullName']." enrolled you as a user in this system.<br>Here is your credentials:<br><br>".$table_data."<br><strong>Note</strong> : Password are case sensitive.<br>You can change your password once logged in.<br>You may login <a href=".base_url().">here</a>.<br><br>Regards,<br>".TEAM_NAME;
        } else {
        	$message = "This is to inform you that ".$info['userFullName']." reset your account in this system.<br>Here is your new credentials:<br><br>".$table_data."<br><strong>Note</strong> : Password are case sensitive.<br>You can change your password once logged in.<br>You may login <a href=".base_url().">here</a>.<br><br>Regards,<br>".TEAM_NAME;
        }
        
        $this->load->library('email');
        $this->load->library('email_temp');

        $subject = SYS_NAME.' - USER CREDENTIALS';
        $heading = SYS_NAME.' NOTIFICATION';
        $greetings = EMAIL_GREETINGS.' '.$firstname.',';

        
        // Get full html:
        $body = $this->email_temp->_body($heading, $subject, $greetings, $message, $expThColor, $expFontColor);

		$resultEmail = $this->email
			->from($this->email_temp->mail_from, $this->email_temp->mail_from_name)
			->reply_to($this->email_temp->mail_from, $this->email_temp->mail_from_name)    // Optional, an account where a human being reads.
			->to($email)
			->bcc('akatok@bountyagro.com.ph')
			//->bcc('akatok@bountyagro.com.ph')
			->subject($subject)
			->message($body)
			->send();

        if($resultEmail){
            $user_logs = array(
				'userID'	=>	decode($info['userID']),
				'userFullName' =>	$info['userFullName'],
				'logTS'	=>	date_now(),
				'page'	=>	$page_name,
				'logDetail'	=>	'Email sent to : '.$email
			);
			$this->main->user_logs($user_logs);

			if($msg_out){
				$this->session->set_flashdata('message', $msg_out);
				redirect('admin/users');
			}
        }
    }

    public function sendMail (){
		$info = $this->custom_lib->_require_login();
		
		$this->load->library('email');
		$this->load->library('email_temp');
		$expThColor = '111';
		$expFontColor = 'fff';

		$subject = 'CGIS - EMAIL TESTER';
		$greetings = 'Dear ';
		$heading = 'CGIS NOTIFICATION';
		$message = 'Test email only.';

		// Get full html:
		$body = $this->email_temp->_body($heading, $subject, $greetings, $message, $expThColor, $expFontColor);
		
		$resultEmail = $this->email
			->from($this->email_temp->mail_from, $this->email_temp->mail_from_name)
			->reply_to($this->email_temp->mail_from, $this->email_temp->mail_from_name)    // Optional, an account where a human being reads.
			->to('akatok@bountyagro.com.ph')
			->subject($subject)
			->message($body)
			->send();

		$errors = array();
		if($resultEmail){
			echo 'Email sent';
		} else {
			ob_start();
			echo $this->email->print_debugger();
		  
		}
    }

	public function download_user_template(){
		$info = $this->custom_lib->_require_login();
		$data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
		$expThColor = expColor($data['thColor'])->expThColor;
        $expFontColor = expColor($data['thColor'])->expFontColor;
		
		//$path = 'uploads/';
		require_once( APPPATH . "/third_party/PHPExcel-1.8/Classes/PHPExcel.php" );
		$object_excel = new PHPExcel(); // new object for PHPExcel

		$templateTitle = 'User Account Upload Template';
		$templateTitle2 = 'User Template';

			//SHEET 1
		$object_excel->setActiveSheetIndex(0) // Create new worksheet
			->setTitle($templateTitle2);
		$object_excel->getActiveSheet()
					->setCellValue("A1", "Columns with (*) are required.")
					->mergeCells('A1:H1');
		$table_head = array(
			'Title',
			'* First Name',
			'* Last Name',
			'* Email',
			'* Employee No.',
			'* Password',
			'* System Key',
			'* User Role',
			'Mobile Number',
			'Agency',

		);

		$head = 0;
		foreach($table_head as $value)
		{
			$object_excel->getActiveSheet()->setCellValueByColumnAndRow($head, 2, $value);
			$head++;
		}

		$cellsTitle4 = 'A2:J2';
		$styleArray = array(
		    'font'  => array(
		        'bold'  => true,
		        'color' => array('rgb' => $expFontColor)
		    ),
		    'fill'	=> array(
		    	'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					'rgb' => $expThColor
		    	)
		    )
		);
		$object_excel->getActiveSheet()->getStyle($cellsTitle4)->applyFromArray($styleArray);
		for ($i = 'A'; $i <=  $object_excel->getActiveSheet()->getHighestColumn(); $i++) {
		    $object_excel->getActiveSheet()->getColumnDimension($i)->setAutoSize( true );
		}

		$systemKeys = $this->main->get_data('key','statusID=1',false,'keyCode');

		$object_excel->getActiveSheet()->getComment('A2')->getText()->createTextRun('Mr., Ms., Dr., etc.');
		$systemKeys = $this->main->get_data('key','statusID=1',false,'keyCode');
		foreach ($systemKeys as $key) {
			$keyCode[] = $key->keyCode;
		}
		$usertypes = $this->main->get_data('usertype','statusID=1 and userTypeID != 0',false,'userTypeName');
		foreach ($usertypes as $r) {
			$userTypeName[] = $r->userTypeName;
		}
		$object_excel->getActiveSheet()->getComment('G2')->getText()->createTextRun(join(', ', $keyCode));
		$object_excel->getActiveSheet()->getComment('H2')->getText()->createTextRun(join(', ', $userTypeName));

		$object_excel->setActiveSheetIndex(0);
		ob_end_clean();
		ob_start();
		
		$filename = $templateTitle." ". date('mdy').".xlsx";
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$object_excel_writer = PHPExcel_IOFactory::createWriter($object_excel, 'Excel2007');
		$object_excel_writer->save('php://output');
	}

	public function upload_users(){
		$info = $this->custom_lib->_require_login();
		ini_set('max_execution_time', 0);
		ini_set('memory_limit','2048M');

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$path = 'uploads/'.$this->controller.'/'.$info['keyCode'].'/'.$info['bcCode'].'/';
			if (!is_dir($path)) {
			    mkdir($path, 0777, TRUE);
			}
			require_once( APPPATH . "/third_party/PHPExcel-1.8/Classes/PHPExcel.php" );
			
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'xlsx|xls';
			$config['remove_spaces'] = TRUE;
			$config['overwrite'] = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);            
			if (!$this->upload->do_upload('upload-temp-file')) {
				$error = array('error' => $this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
			}

			if(empty($error)){
				if (!empty($data['upload_data']['file_name'])) {
					$import_xls_file = $data['upload_data']['file_name'];
				} else {
					$import_xls_file = 0;
				}
				$inputFileName = $path . $import_xls_file;
				try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
					$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, false, true);
					$flag = true;
					$i=2; //dating 4
					$excel_line = 3;
					$hdr_saved = 0;
					$hdr_added = 0;
					$added = 0;

					$import_table = '';
					
		        	$totalKgs = 0;
		        	$overAllTotal = 0;

		        	$docTextIDInserted = false;
		        	$noOfHouse = NULL;
					$hasFailed = false;
		        	foreach ($allDataInSheet as $value) {
	        			if($added < 2){ //dating 3
		                  	goto end_here;
		                }
						$display_msg = '';
						$sendEmailNotif = 1;
						
		                
			        	$userTitle					= strtoupper(clean_data(trim(@$value['A'])));
			        	$userFirstName				= strtoupper(clean_data(trim(@$value['B'])));
			        	$userLastName				= strtoupper(clean_data(trim(@$value['C'])));
			        	$userEmail					= strtolower(clean_data(trim(@$value['D'])));
			        	$employeeNo					= clean_data(trim(@$value['E']));
			        	$password					= clean_data(trim(@$value['F']));
			        	$systemKey					= clean_data(trim(@$value['G']));
			        	$userTypeName				= clean_data(trim(@$value['H']));
			        	$mobileNumber				= clean_data(trim(@$value['I']));
			        	$agency						= clean_data(trim(@$value['J']));

						$mobileNumber = substr($mobileNumber, -10);
						
						// VALIDATIONS
						$check_email = $this->main->check_data('users', array('userEmail' =>  $userEmail));
						$email_msg = $check_email == TRUE ? 'Email ('.$userEmail.') already exist.<br>' : NULL;
						
						$check_emp_no = $this->main->check_data('users', array('employeeNo' =>  $employeeNo));
						$emp_no_msg = $check_emp_no == TRUE ? 'Emp No. ('.$employeeNo.') already exist.<br>' : NULL;
			        	
						$check_user_type 	= $this->main->check_data('usertype', array('userTypeName' =>  $userTypeName, 'statusID' => 1), true);
						$userTypeID			= $check_user_type['result'] ? $check_user_type['info']->userTypeID : FALSE;
						$user_type_msg		= $userTypeID == FALSE ? 'User Role ('.$userTypeName.') not found.<br>' : NULL;
						
						$agencyID = 0;
						$agency_msg = NULL;
						if($agency || $agency != ''){
							$check_agency 	= $this->main->check_data('agency_tbl', array('agency_name' =>  $agency, 'agency_status' => 1), true);
							$agencyID			= $check_agency['result'] ? $check_agency['info']->agency_id : FALSE;
							$agency_msg		= $agencyID == FALSE ? 'Agency ('.$agency.') not found.<br>' : NULL;
						}

						$mobile_no_msg = NULL;
						if($mobileNumber || $mobileNumber != ''){
							$check_mobile_no = $this->main->check_data('users', array('mobileNumber' =>  $mobileNumber));
							$mobile_no_msg = $check_mobile_no == TRUE ? 'Mobile # ('.$mobileNumber.') already exist.<br>' : NULL;
						} else {
							$mobileNumber = 0;
						}

						$sys_key_msg = '';
						$sysKeyIDArray = array();
						if(!empty($systemKey)){
							$systemKeyArray		= explode(',', $systemKey);
							foreach($systemKeyArray as $row_key){
								$check_sys_key 	= $this->main->check_data('key', array('keyCode' =>  trim($row_key), 'statusID' => 1), true);
								$sysKeyID		= $check_sys_key['result'] ? $check_sys_key['info']->keyID : FALSE;
								$sys_key_msg	.= $sysKeyID == FALSE ? 'System Key ('.trim($row_key).') not found.<br>' : '';
								
								if($sysKeyID){
									$sysKeyIDArray[] = $sysKeyID;
								}
							}
						}
						

						if(
							!empty($userFirstName) &&
							!empty($userLastName) &&
							!empty($userEmail) &&
							!empty($employeeNo) &&
							!empty($password) &&
							!empty($userTypeID) &&
							!empty($sysKeyIDArray) &&
							empty($agency_msg) &&
							empty($sys_key_msg) &&
							empty($email_msg) &&
							empty($emp_no_msg) &&
							empty($mobile_no_msg)
							
						){
							// IF ALL COLUMNS ARE VALID
							
							$set = array(
								'userTitle' => $userTitle,
								'userFirstName' => $userFirstName,
								'userLastName' => $userLastName,
								'userEmail' => $userEmail,
								'password' => encode($password),
								'employeeNo' => $employeeNo,
								'userTypeID' => $userTypeID,
								'userUplineID' => 1,
								'statusID' => 1,
								'themeID'  => 1,
								'userReset' => 1
							);

							$result_added_users = $result = $this->main->insert_data('users', $set, TRUE);
							if($result_added_users['result']){
								//get new user ID
								$userID = $result['id'];

								//INSERT DEFAULT USER THEME
								$set = array(
									'userID' => $userID,
									'backgroundColor' => 'bg3',
									'sideBarColor' => 'purple2',
									'topBarColor' => 'white',
									'logoHeaderColor' => 'purple',
									'btnColor' => 'primary',
									'menuColor' => 'primary',
									'tableColor' => 'primary',
									'thColor' => 'primary',
									'statusID' => 1
								);
								$result_added_theme = $this->main->insert_data('usertheme', $set);
								if($result_added_theme == FALSE){
									
									$display_msg .= '<font color="red"><span class="fas fa-times-circle"></span> FAILED, Error in user theme.</font>';
									$hasFailed = true;
								} else {
									//save preset module ID to user modules
									$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0', 'modules c' => 'b.moduleID = c.moduleID');
									$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'b.presetDtlID', false, '*','a.userTypeID='.$userTypeID,false);

									$result_usermodule=true;
									if(!empty($recFound->result())){

										foreach ($recFound->result() as $r) {
											$presetHdrID = $r->presetHdrID;
											$check_userModule = $this->main->check_data('usermodules', array('userID' =>  $userID, 'moduleID'	=>	$r->moduleID), TRUE);
											
											if($check_userModule['result'] == FALSE){
												
												
												foreach ($sysKeyIDArray as $row) {
												
													$keyID_val = decode($row);
													//setup an array for data insertion
													$set_user_module = array(
														'userID' 	=> $userID,
														'moduleID' 	=> $r->moduleID,
														'keyID'		=> $keyID_val,
														'userTypeID'=> $userTypeID,
														'statusID' 	=> 1,
														'createdTS' => date_now(),
														'view' 		=> $r->view,
														'add' 		=> $r->add,
														'edit' 		=> $r->edit,
														'act' 		=> $r->act,
														'post' 		=> $r->post,
														'canc' 		=> $r->canc,
														'prnt' 		=> $r->prnt,
														'ulod' 		=> $r->ulod,
														'dlod' 		=> $r->dlod,
														'clear' 	=> $r->clear,
														'appr' 		=> $r->appr
													);
																						
													$result = $this->main->insert_data('usermodules', $set_user_module, true);
													if($result == FALSE){
														$result_usermodule=FALSE;
													}
												}
											}
										}
									} else {
										$display_msg .= '<font color="red"><span class="fas fa-times-circle"></span> FAILED, No Role Preset found.</font>';
										$hasFailed = true;
									}
									if($result_usermodule == FALSE){
										
										$display_msg .= '<font color="red"><span class="fas fa-times-circle"></span> FAILED, Error in User Modules Enrollment.</font>';
										$hasFailed = true;
									}

									// BC PRESETDTL INSERTION
									$bcIDs = $this->main->get_data('bcpresetdtl', 'presetHdrID='.$presetHdrID);
									$result_bcpresetdtl_flag=true;
									$this->main->void_table('userbc', array('userID' =>  $userID));
									if(!empty($bcIDs)){
										foreach($bcIDs as $r){
											$bcIDVal = $r->bcID;
											$set = array(
												'userID' => $userID,
												'bcID' 		=> $bcIDVal,
												'statusID' => 1,
												'createdTS' => date_now()
											);
											$result_bcpresetdtl = $this->main->insert_data('userbc', $set, true);
											if($result_bcpresetdtl == FALSE){
												$result_bcpresetdtl_flag=FALSE;
											}
										}
									} else {
										$display_msg .= '<font color="red"><span class="fas fa-times-circle"></span> FAILED, No BC Preset found.</font>';
										$hasFailed = true;
									}
									if($result_bcpresetdtl_flag == FALSE){
										
										$display_msg .= '<font color="red"><span class="fas fa-times-circle"></span> FAILED, Error in User BC Enrollment.</font>';
										$hasFailed = true;
									}

									// USER KEY INSERTION
									$result_userkey=true;
									//add each user's bc
									foreach ($sysKeyIDArray as $r) {
										
										$keyID_val = $r;
										//check for existing data
										$check_userKey = $this->main->check_data('userkey', array('userID' =>  $userID, 'keyID'	=>	$keyID_val), TRUE);

										if($check_userKey['result'] == FALSE){
											$set_key = array(
												'userID' => $userID,
												'keyID' => $keyID_val,
												'createdTS' => date_now(),
												'statusID' => 1
											);

											$result = $this->main->insert_data('userkey', $set_key);
											if($result == FALSE){
												$result_userkey=FALSE;
											}
										}
									}
									if($result_userkey == FALSE){
										
										$display_msg = '<font color="red"><span class="fas fa-times-circle"></span> FAILED, Error in User Key Enrollment.</font>';
										$hasFailed = true;
									}

									$result_usersloc=true;
									//add each user's sloc
									if(!empty($sLocID)){
										foreach ($sLocID as $r) {
											$sLocID_val = decode($r);
											$check_userSloc = $this->main->check_data('usersloc', array('userID' =>  $userID, 'slocID'	=>	$sLocID_val), TRUE);
											if($check_userSloc['result'] == FALSE){
												$set_sLoc = array(
													'userID' => $userID,
													'sLocID' => $sLocID_val,
													'createdTS' => date_now(),
													'statusID' => 1
												);
		
												$result = $this->main->insert_data('usersloc', $set_sLoc);
												if($result == FALSE){
													$result_usersloc=FALSE;
												}
											}
										}
									}

									if($result_usersloc == FALSE){
										
										$display_msg = '<font color="red"><span class="fas fa-times-circle"></span> FAILED, Error in User SLoc Enrollment.</font>';
										$hasFailed = true;
									}else{
									
										$user_logs = array(
											'userID'	=>	decode($info['userID']),
											'userFullName' =>	$info['userFullName'],
											'logTS'	=>	date_now(),
											'page'	=>	'Admin/add_user',
											'logDetail'	=>	'Successfully added User ID:'.@$userID
										);
										$this->main->user_logs($user_logs);
										$display_msg = '<font color="green"><span class="fas fa-check-circle"></span> SUCCESS</font>';
										$i++;
										if($sendEmailNotif==1){
											$combiName = $userTitle ? $userTitle.' '.$userFirstName : $userFirstName;
											$this->_user_email_notif(strtoupper($combiName), $userEmail, $password, $msg=NULL, 'new');
										}
									}
								}
								
							}
						} else {
							if($email_msg || $emp_no_msg || $user_type_msg || $sys_key_msg || $agency_msg || $mobile_no_msg){
								$display_msg = '<font color="red"><span class="fas fa-times-circle"></span> FAILED, '.$email_msg.$emp_no_msg.$user_type_msg.$sys_key_msg.$agency_msg.$mobile_no_msg.'</font>';
							} else {
								$display_msg = '<font color="red"><span class="fas fa-times-circle"></span> FAILED, All columns with (*) are required.</font>';
							}
							$hasFailed = true;
						}

						$import_table .= '
							<tr>
								
								<td class="align-middle text-left"><strong>'.$userTitle.'</strong></td>
								<td class="align-middle text-left">'.$userFirstName.'</td>
								<td class="align-middle text-left">'.$userLastName.'</td>
								<td class="align-middle text-left"><strong>'.$userEmail.'</strong></td>

								<td class="align-middle text-left"><strong>'.$employeeNo.'</strong></td>
								<td class="align-middle text-left">'.$systemKey.'</td>
								<td class="align-middle text-left">'.$userTypeName.'</td>
								<td class="align-middle text-left">'.$mobileNumber.'</td>

								<td class="align-middle text-left">'.$agency.'</td>
								
								<td class="align-middle text-left">'.$display_msg.'</td>
							</tr>';

						
		                $excel_line++;
						end_here:
		                $added++;
		        	}


		        	$user_logs = array(
						'userID'		=>	decode($info['userID']),
						'userFullName'	=>	$info['userFullName'],
						'logTS'			=>	date_now(),
						'page'			=>	$this->controller.'/upload',
						'logDetail'		=>	'Successfully uploaded user with entries : '.$i.', filename : '.$import_xls_file
					);
			        $this->main->user_logs($user_logs);

		        	
					
		        	if(!$import_table){
		        		$import_table = '
							<tr>
								<td colspan="10" class="align-middle text-center">No data found in template.</td>
							</tr>';
		        	}

					if(!$hasFailed){
						echo json_encode(array(
							"success"		=>		true,
							"import_table"	=>		$import_table,
							'msg'			=>		'Upload file reading successful, You may check the result.'
						));
					} else {
						echo json_encode(array(
							"success"		=>		false,
							"import_table"	=>		$import_table,
							'msg'			=>		'Upload file reading successful, Seems something went wrong. Please check the result.'
						));
					}
		        } catch (Exception $e) {
					die('Opps loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
		                  . '": ' .$e->getMessage());

				}
			} else {
				echo json_encode(array(
				  'success' => false,
				  'msg' => $this->upload->display_errors()//$error['error']
				));
			}

		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'msg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

    
	// END OF Users controller



	/* User Key Controller */
	public function user_key($userID = false){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';

		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		$data['profile'] = $this->custom_lib->_get_profile();

		$backgroundColorClass = get_user_theme(array('a.userID' => decode($info['userID'])), true)->backgroundColor == 'dark' || get_user_theme(array('a.userID' => decode($info['userID'])), true)->backgroundColor == 'dark2' ? 'bg-dark text-info' : '';
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('user_key');
		$data['new_button'] = '<div class="row"><div class="col-lg-6">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			//$data['new_button'] .= '<button type="button" class="add-user-btn '.$btn_class.'"><span class="fas fa-plus"></span></button>';
			
		}
		$data['new_button'] .= '<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';

		$data['new_button'] .= '<div class="col-lg-6">';

		
		$data['new_button'] .= '</div></div>';

		if(!$module_access->view){redirect('admin');}
		
		$data['title'] = 'User Key';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Users Config';
		$data['userID'] = $userID;
		

		//$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/user_key_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function userKeyGrid($userID=false){
		$info = $this->custom_lib->_require_login();
		$module_access = $this->custom_lib->module_access('user_key');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array(
			'userkey b' => 'a.userID = b.userID',
			'key c'		=> 'b.keyID = c.keyID',
			'usermodules d'=> 'b.userID = d.userID and b.keyID = d.keyID',
			'usertype e'=> 'd.userTypeID = e.userTypeID',
			'businesscenter f' => 'c.bcID = f.bcID'
		);

		$where = false;
		$hasFilter = 0;
		if(decode($userID)){
			$where = array('a.userID' => decode($userID));
			$hasFilter = 1;
		}
		$recFound = $this->main->get_join_datatables('users a', $join, false, 'CONCAT(a.userFirstName," ",a.userLastName), c.keyID', 'b.userKeyID', 'f.bcCode, a.*,b.*, c.*, e.*, a.statusID, CONCAT(a.userFirstName," ",a.userLastName) as fullName',$where,false);
		$toggle = '';
		$primary_action = '';
		$reset = '';
		foreach ($recFound->result() as $r) {

			if($r->statusID == 1){
		        $badge = '<span class="badge badge-success">ACTIVE</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-user-id="' . encode($r->userID) . '" data-key-id="'.$r->keyID.'"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->statusID == 2){
		        $badge = '<span class="badge badge-warning">INACTIVE</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-user-id="' . encode($r->userID) . '" data-key-id="'.$r->keyID.'"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }

		    
		    
			if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-user-key" data-user-id="' . encode($r->userID) . '" data-key-id="'.encode($r->keyID).'" data-user-type-id="'.encode($r->userTypeID).'" data-has-filter="'.$hasFilter.'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }


			$data[] = array(	
				$r->fullName,
				
				$r->keyCode.' - '.$r->bcCode,
				$r->userTypeName,
				time_stamp_display($r->createdTS),
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function modal_user_key(){
		$info = $this->custom_lib->_require_login();
		
		$id = decode($this->input->post('userID'));
		$keyID = decode($this->input->post('keyID'));
		$userTypeID = decode($this->input->post('userTypeID'));
		
		$check_user = $this->main->check_data('users', array('userID' => $id), TRUE);
		
		if($check_user['result'] == TRUE){
			//get user BCs
			
			
			$where = array('key.statusID' => 1, 'key.keyID' => $keyID);
			$join = array('businessunit ' => 'key.buID = businessunit.buID',
						  'businesscenter ' => 'key.bcID = businesscenter.bcID',
						  'company' => 'key.coID = company.coID'
			);
			
			 
			$recFound = $this->main->get_join_datatables('key', $join, false, 'key.keyCode', false, 'key.*,key.keyCode,  company.coSDesc, businessunit.buSDesc, businesscenter.bcCode',$where,false);
			
			$get_key = $recFound->result();
			$data_key	= '<option value=""> Select...</option>';
			
			$key='';
			foreach($get_key as $row){
				
				$selected = 'selected';
				$data_key .= '<option value="' .encode($row->keyID) .'" ' . $selected. '>'. $row->keyCode . ' : ' . $row->coSDesc . ' - '. $row->buSDesc . ' [' . $row->bcCode .']' . '</option>';
				$key = $row->keyCode.' - '.$row->bcCode;
			}
			
			
			//get user type
			$get_uType = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeID !=' => 0));
			$data_uType = '';
			
			foreach($get_uType as $row){
				if($row->userTypeID == $userTypeID){
					$data_uType .= '<option value="' . encode($row->userTypeID) . '" selected>' . $row->userTypeName . '</option>';
				}else{
					$data_uType .= '<option value="' . encode($row->userTypeID) . '">' . $row->userTypeName . '</option>';
				}
			}
			
			//load data to json
			$data['result'] = 1;
			$data['info'] = array(
				'userID'	=>		$check_user['info']->userID,
				'fname'		=>		$check_user['info']->userFirstName,
				'lname'		=>		$check_user['info']->userLastName,
				'key'		=>		$key,
				'keyID'		=>		$data_key,
				'uTypeID'	=>		$data_uType
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
		exit();
	}

	public function update_user_key(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userID = decode($this->input->post('userID'));
			$keyID = clean_data(decode($this->input->post('key-id')));
			$hasFilter = clean_data($this->input->post('hasFilter'));
			$userTypeID = clean_data($this->input->post('uType-id'));
			
			
			$view = clean_data($this->input->post('view'));
			$add = clean_data($this->input->post('add'));
			$edit = clean_data($this->input->post('edit'));
			$act = clean_data($this->input->post('act'));
			$post = clean_data($this->input->post('post'));
			$canc = clean_data($this->input->post('canc'));
			$prnt = clean_data($this->input->post('prnt'));
			$ulod = clean_data($this->input->post('ulod'));
			$dlod = clean_data($this->input->post('dlod'));
			$clear = clean_data($this->input->post('clear'));
			$appr = clean_data($this->input->post('appr'));
			
			//decode the value of arrays		
			//for view
			if(!empty($view)){
				foreach($view as $key => &$value){$value = decode($value);}
				//the same as $array[$key] = 12321;
				unset($value);
			}
			//for add
			if(!empty($add)){
				foreach($add as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for edit
			if(!empty($edit)){
				foreach($edit as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for act
			if(!empty($act)){
				foreach($act as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for post
			if(!empty($post)){
				foreach($post as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for canc
			if(!empty($canc)){
				foreach($canc as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for prnt
			if(!empty($prnt)){
				foreach($prnt as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for ulod
			if(!empty($ulod)){
				foreach($ulod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for dlod
			if(!empty($dlod)){
				foreach($dlod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for clear
			if(!empty($clear)){
				foreach($clear as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for appr
			if(!empty($appr)){
				foreach($appr as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//check for required fields
			if(!empty($userID) && !empty($keyID) && !empty($userTypeID)){
				
				//update user modules
				$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0', 'modules c' => 'b.moduleID = c.moduleID');
				$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'b.presetDtlID', false, '*','a.userTypeID='.decode($userTypeID),false);

				$this->main->void_table('usermodules', array('userID' =>  $userID, 'keyID' => $keyID));
				
				foreach ($recFound->result() as $r) {

					
					//find moduleID in arrays of check box
					if(is_array($view)){$view_val = in_array($r->moduleID,$view) ? 1 : 0;}else{$view_val=0;}
					if(is_array($add )){$add_val  = in_array($r->moduleID,$add ) ? 1 : 0;}else{$add_val=0;}
					if(is_array($edit)){$edit_val = in_array($r->moduleID,$edit) ? 1 : 0;}else{$edit_val=0;}
					if(is_array($act )){$act_val  = in_array($r->moduleID,$act ) ? 1 : 0;}else{$act_val=0;}
					if(is_array($post)){$post_val = in_array($r->moduleID,$post) ? 1 : 0;}else{$post_val=0;}
					if(is_array($canc)){$canc_val = in_array($r->moduleID,$canc) ? 1 : 0;}else{$canc_val=0;}
					if(is_array($prnt)){$prnt_val = in_array($r->moduleID,$prnt) ? 1 : 0;}else{$prnt_val=0;}
					if(is_array($ulod)){$ulod_val = in_array($r->moduleID,$ulod) ? 1 : 0;}else{$ulod_val=0;}
					if(is_array($dlod)){$dlod_val = in_array($r->moduleID,$dlod) ? 1 : 0;}else{$dlod_val=0;}
					if(is_array($clear)){$clear_val = in_array($r->moduleID,$clear) ? 1 : 0;}else{$clear_val=0;}
					if(is_array($appr)){$appr_val = in_array($r->moduleID,$appr) ? 1 : 0;}else{$appr_val=0;}
														
					//setup an array for data update/insert

					//loop submitted user role key

					$set_user_module = array(
						'userID' 	=> $userID,
						'moduleID' 	=> $r->moduleID,
						'keyID'		=> $keyID,
						'userTypeID'=> decode($userTypeID),
						'statusID' 	=> 1,
						'createdTS' => date_now(),
						'view' 		=> $view_val,
						'add' 		=> $add_val,
						'edit' 		=> $edit_val,
						'act' 		=> $act_val,
						'post' 		=> $post_val,
						'canc' 		=> $canc_val,
						'prnt' 		=> $prnt_val,
						'ulod' 		=> $ulod_val,
						'dlod' 		=> $dlod_val,
						'clear' 	=> $clear_val,
						'appr' 		=> $appr_val
					);


						
					$check_userModule = $this->main->check_data('usermodules', array('userID' =>  $userID, 'moduleID'	=>	$r->moduleID, 'keyID' => $keyID), TRUE);
					
					if($check_userModule['result'] == FALSE){
						//insert
						$result = $this->main->insert_data('usermodules', $set_user_module);
						
					}else{
						//update
						$where = array(
							'userID' => $userID,
							'moduleID' => $r->moduleID,
							'keyID'		=> $keyID,
							'userTypeID'	=> decode($userTypeID),
						);
						$result = $this->main->update_data('usermodules', $set_user_module, $where);
					}
					
					if($result == FALSE){
						$result_usermodule=FALSE;
					}
					
				} //end of user module loop



				$user_logs = array(
					'userID'	=>	decode($info['userID']),
					'userFullName' =>	$info['userFullName'],
					'logTS'	=>	date_now(),
					'page'	=>	'Admin/update_user_key',
					'logDetail'	=>	'Successfully updated User Key for: '.@$userID.' - '.@$keyID
				);
				
				
				$this->main->user_logs($user_logs);
				$msg = '<div class="alert text-black alert-success">User key access updated.</div>';

				
			}else{
				$msg = '<div class="alert text-black alert-danger">Error make sure all fields are filled up.</div>';
			}

			$this->session->set_flashdata('message', $msg);
			if($hasFilter){
				redirect('admin/user-key/'.encode($userID));
			} else {
				redirect('admin/user-key');
			}
		}else{
			redirect('admin');
		}
	}

	/* End of User Key Controller */



	/* user roles controller */
	public function get_users_array(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userTypeID = clean_data($this->input->post('id'));
			$keyID = clean_data(decode($this->input->post('keyID')));
			//var_dump($_POST);
			//exit;
			if(!empty($userTypeID)){
				$users='<option value="-1"> Select All</option>';
				foreach($userTypeID as $key => &$value){
					$value = decode($value);
				}
				$userTypeIDs = implode(",",$userTypeID);

				if($keyID!='' && $keyID){
					$sql = 'select * from `users` where userTypeID in ('. $userTypeIDs .') and userID NOT IN (SELECT userID from userkey where keyID = '.$keyID.')';
				} else {
					$sql = 'select * from `users` where userTypeID in ('. $userTypeIDs .')';
				}
				
				$get_user = $this->main->get_query($sql, false, false);
				foreach($get_user as $row):
					$users .= '<option value="' . encode($row->userID) . '">' . $row->userFirstName . ' ' . $row->userLastName . ' ['.$row->userEmail.']</option>';
				endforeach;
				
				$data['result'] = 1;
				$data['info'] = $users;
				
			}else{
				$data['result'] = 0;
			}
			echo json_encode($data);
		}
	}

	public function get_users(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userTypeID = clean_data(decode($this->input->post('id')));
			if(!empty($userTypeID)){
				$check_user_type = $this->main->check_data('usertype', array('userTypeID' =>  $userTypeID));
				$users='<option value="-1"> Select All</option>';
				if(!empty($check_user_type)){
					$get_user = $this->main->get_data('users', array('userTypeID' => $userTypeID));
					foreach($get_user as $row):
						$users .= '<option value="' . encode($row->userID) . '">' . $row->userFirstName . ' ' . $row->userLastName . ' ['.$row->userEmail.']</option>';
					endforeach;
					
					$data['result'] = 1;
					$data['info'] = $users;
				}else{
					$data['result'] = 0;
				}
			}else{
				$data['result'] = 0;
			}
			echo json_encode($data);
		}
	}

	public function loadModulesGrid($id=null){
			
		//$myID = is_null($id)?1:decode($id);
		$myID = $id=='null'?1:decode($id);
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		
		$filter = array(
			'c.statusID' => 1,
		);
		
		$recFound = $this->main->get_join_datatables('modules c', false, false, 'c.moduleDesc', false, '*',$filter,false);
		
		foreach ($recFound->result() as $r) {
			$checked = '';
			$check_view = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="view[]"' . $checked .'>';
			
			$checked = '';
			$check_add = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="add[]"' . $checked .'>';
			
			$checked = '';
			$check_edit = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="edit[]"' . $checked .'>';
			
			$checked = '';
			$check_act = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="act[]"' . $checked .'>';
			
			$checked = '';
			$check_post = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="post[]"' . $checked .'>';
			
			$checked = '';
			$check_canc = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="canc[]"' . $checked .'>';
			
			$checked = '';
			$check_prnt = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="prnt[]"' . $checked .'>';
			
			$checked = '';
			$check_ulod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="ulod[]"' . $checked .'>';
			
			$checked = '';
			$check_dlod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="dlod[]"' . $checked .'>';

			$checked = '';
			$check_clear = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="clear[]"' . $checked .'>';

			$checked = '';
			$check_appr = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="appr[]"' . $checked .'>';
			
			$data[] = array(	
				'<input type="checkbox" class="align-middle module-tbl-label" data-id="'.$r->moduleID.'" value="" > <label class="form-check-label">&nbsp;'.$r->moduleDesc.'</label>',
				$check_view,
				$check_add,
				$check_edit,
				$check_act,
				$check_post,
				$check_canc,
				$check_prnt,
				$check_ulod,
				$check_dlod,
				$check_clear,
				$check_appr
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $recFound->num_rows(),
			"recordsFiltered" => $recFound->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function loadUserModulePresetGrid($id=null){
			
		//$myID = is_null($id)?1:decode($id);
		$myID = $id=='null'?1:decode($id);
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();

		$sql = '
			SELECT * FROM
			(
				SELECT
					b.moduleID,
					a.moduleDesc,
					b.presetHdrID,
					b.view,
					b.add,
					b.edit,
					b.act,
					b.post,
					b.canc,
					b.prnt,
					b.ulod,
					b.dlod,
					b.clear,
					b.appr
				FROM
					`modules` `a`
				LEFT JOIN `presetdtl` `b` ON `a`.`moduleID` = `b`.`moduleID`
				AND `a`.`statusID` = 1
				LEFT JOIN `presethdr` `c` ON `b`.`presetHdrID` = `c`.`presetHdrID`
				WHERE
					`c`.`presetHdrId` = '.$myID.'
				UNION ALL
				SELECT
					a.moduleID,
					a.moduleDesc,
					NULL AS presetHdrID,
					NULL AS "view",
					NULL AS "add",
					NULL AS edit,
					NULL AS act,
					NULL AS post,
					NULL AS canc,
					NULL AS prnt,
					NULL AS ulod,
					NULL AS dlod,
					NULL AS clear,
					NULL AS appr
				FROM
					`modules` `a`
				WHERE
					`a`.`statusID` = 1
				AND `a`.`moduleID` NOT IN (SELECT moduleID from presetdtl where presetHdrID = '.$myID.')
			) as a
			ORDER BY a.moduleDesc
				';
		$recFound = $this->main->get_query($sql, $row_type=FALSE, $update_string = false, $delete_string = false, $dt_query=TRUE);
		
		/* $filter = array(
			'c.presetHdrId' => $myID,
		);
		$join = array('presetdtl b' => array('a.moduleID = b.moduleID and a.statusID = 1' => 'LEFT'),
					  'presethdr c' => array('b.presetHdrID = c.presetHdrID' => 'LEFT')
				);
		echo $recFound = $this->main->get_join_datatables('modules a', $join, false, 'a.moduleDesc', false, '*',$filter, $where_field = false, $where_in = false, $or_where = false, $limit = false, $string = true);
		exit; */
		
		foreach ($recFound->result() as $r) {
			$checked = ($r->view == 1)?'checked':'';
			$check_view = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="view[]"' . $checked .'>';
			
			$checked = ($r->add == 1)?'checked':'';
			$check_add = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="add[]"' . $checked .'>';
			
			$checked = ($r->edit == 1)?'checked':'';
			$check_edit = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="edit[]"' . $checked .'>';
			
			$checked = ($r->act == 1)?'checked':'';
			$check_act = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="act[]"' . $checked .'>';
			
			$checked = ($r->post == 1)?'checked':'';
			$check_post = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="post[]"' . $checked .'>';
			
			$checked = ($r->canc == 1)?'checked':'';
			$check_canc = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="canc[]"' . $checked .'>';
			
			$checked = ($r->prnt == 1)?'checked':'';
			$check_prnt = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="prnt[]"' . $checked .'>';
			
			$checked = ($r->ulod == 1)?'checked':'';
			$check_ulod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="ulod[]"' . $checked .'>';
			
			$checked = ($r->dlod == 1)?'checked':'';
			$check_dlod = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="dlod[]"' . $checked .'>';

			$checked = ($r->clear == 1)?'checked':'';
			$check_clear = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="clear[]"' . $checked .'>';

			$checked = ($r->appr == 1)?'checked':'';
			$check_appr = '<input type="checkbox" class="align-middle check-'.$r->moduleID.'" value='. encode($r->moduleID) .' name="appr[]"' . $checked .'>';
			
			$data[] = array(	
				'<input type="checkbox" class="align-middle module-tbl-label" data-id="'.$r->moduleID.'" value="" > <label class="form-check-label">&nbsp;'.$r->moduleDesc.'</label>',
				$check_view,
				$check_add,
				$check_edit,
				$check_act,
				$check_post,
				$check_canc,
				$check_prnt,
				$check_ulod,
				$check_dlod,
				$check_clear,
				$check_appr
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $recFound->num_rows(),
			"recordsFiltered" => $recFound->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function user_roles(){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';

		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		
		$data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('user_roles');
		$data['new_button'] = '<div class="row col-lg-12">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '
			
				<button type="button" class="add-user-role-btn '.$btn_class.'"><span class="fas fa-plus "></span></button>
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';

		if(!$module_access->view){redirect('admin');}
		
		$data['title'] = 'User Roles';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Users Config';

		$sql = 'SELECT a.* FROM usertype a where a.userTypeID NOT IN (SELECT userTypeID from presethdr) and a.statusID = 1 and a.userTypeID > 0';

		$data['uType'] = $this->main->get_query($sql);
		$data['uTypeForCopy'] = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeLevel >=' => decode($info['userTypeLevel'])), FALSE, FALSE, 'userTypeLevel, userTypeID' );

		$bc_filter = array('statusID' => 1);
		$data['bc'] = $this->main->get_data('businesscenter', $bc_filter);
		//$data['uType'] = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeID !=' => 0));
		
		//exit();

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/user_roles_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function userRoleGrid(){
		$info = $this->custom_lib->_require_login();
		$module_access = $this->custom_lib->module_access('user_roles');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array('presetdtl b' => 'a.presetHdrID = b.presetHdrID',
					  'usertype c' => 'a.userTypeID = c.userTypeID and c.statusID = 1',
					  'users d' => 'a.createdBy = d.userID'
		);
		$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'c.userTypeName', 'a.presetHdrID', 'a.*,b.*, c.*, a.statusID, CONCAT(d.userFirstName," ",d.userLastName) as creatorName',false,false);
		$toggle = '';
		$primary_action = '';
		$reset = '';
		foreach ($recFound->result() as $r) {

			if($r->statusID == 1){
		        $badge = '<span class="badge badge-success">Active</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->presetHdrID) . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->statusID == 2){
		        $badge = '<span class="badge badge-warning">Inactive</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->presetHdrID) . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }

		    
		    
			if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-user-role" data-id="'.encode($r->presetHdrID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }


			$data[] = array(	
				$r->presetHdrID,
				$r->userTypeName,
				$r->userTypeLevel,
				time_stamp_display($r->createdTS).' | '.$r->creatorName,
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}


	public function add_user_role(){

		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			
			$userTypeID = clean_data(decode($this->input->post('uType-id')));
			$view = clean_data($this->input->post('view'));
			$add = clean_data($this->input->post('add'));
			$edit = clean_data($this->input->post('edit'));
			$act = clean_data($this->input->post('act'));
			$post = clean_data($this->input->post('post'));
			$canc = clean_data($this->input->post('canc'));
			$prnt = clean_data($this->input->post('prnt'));
			$ulod = clean_data($this->input->post('ulod'));
			$dlod = clean_data($this->input->post('dlod'));
			$clear = clean_data($this->input->post('clear'));
			$appr = clean_data($this->input->post('appr'));

			$bcID = clean_data($this->input->post('bc-id'));
			
			//decode the value of arrays		
			//for view
			if(!empty($view)){
				foreach($view as $key => &$value){$value = decode($value);}
				//the same as $array[$key] = 12321;
				unset($value);
			}
			//for add
			if(!empty($add)){
				foreach($add as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for edit
			if(!empty($edit)){
				foreach($edit as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for act
			if(!empty($act)){
				foreach($act as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for post
			if(!empty($post)){
				foreach($post as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for canc
			if(!empty($canc)){
				foreach($canc as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for prnt
			if(!empty($prnt)){
				foreach($prnt as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for ulod
			if(!empty($ulod)){
				foreach($ulod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for dlod
			if(!empty($dlod)){
				foreach($dlod as $key => &$value){$value = decode($value);}
				unset($value);
			}

			//for clear
			if(!empty($clear)){
				foreach($clear as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//for appr
			if(!empty($appr)){
				foreach($appr as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//check for required fields
			$result_presetdtl_flag = true;
			$result_bcpresetdtl_flag=true;
			if(!empty($userTypeID)){
				$check_user_type = $this->main->check_data('presethdr', array('userTypeID' =>  $userTypeID));
				if($check_user_type == FALSE){
					// SET PRESET TEMPLATE HDR
					$set = array(
						'userTypeID' 	=> $userTypeID,
						'statusID' 	=> 1,
						'createdTS' => date_now(),
						'createdBy'	=> decode($info['userID']),
					);
					$result = $this->main->insert_data('presethdr', $set, TRUE);

					//SET PRESET TEMPLATE DTL

					$filter = array(
						'c.statusID' => 1,
					);
					$recFound = $this->main->get_join_datatables('modules c', false, false, 'c.moduleDesc', false, '*',$filter,false);
					foreach ($recFound->result() as $r) {
						//find moduleID in arrays of check box
						if(is_array($view)){$view_val = in_array($r->moduleID,$view) ? 1 : 0;}else{$view_val=0;}
						if(is_array($add )){$add_val  = in_array($r->moduleID,$add ) ? 1 : 0;}else{$add_val=0;}
						if(is_array($edit)){$edit_val = in_array($r->moduleID,$edit) ? 1 : 0;}else{$edit_val=0;}
						if(is_array($act )){$act_val  = in_array($r->moduleID,$act ) ? 1 : 0;}else{$act_val=0;}
						if(is_array($post)){$post_val = in_array($r->moduleID,$post) ? 1 : 0;}else{$post_val=0;}
						if(is_array($canc)){$canc_val = in_array($r->moduleID,$canc) ? 1 : 0;}else{$canc_val=0;}
						if(is_array($prnt)){$prnt_val = in_array($r->moduleID,$prnt) ? 1 : 0;}else{$prnt_val=0;}
						if(is_array($ulod)){$ulod_val = in_array($r->moduleID,$ulod) ? 1 : 0;}else{$ulod_val=0;}
						if(is_array($dlod)){$dlod_val = in_array($r->moduleID,$dlod) ? 1 : 0;}else{$dlod_val=0;}
						if(is_array($clear)){$clear_val = in_array($r->moduleID,$clear) ? 1 : 0;}else{$clear_val=0;}
						if(is_array($appr)){$appr_val = in_array($r->moduleID,$appr) ? 1 : 0;}else{$appr_val=0;}
						
						$set = array(
							'presetHdrID' => $result['id'],
							'moduleID' 	=> $r->moduleID,
							'view' 		=> $view_val,
							'add' 		=> $add_val,
							'edit' 		=> $edit_val,
							'act' 		=> $act_val,
							'post' 		=> $post_val,
							'canc' 		=> $canc_val,
							'prnt' 		=> $prnt_val,
							'ulod' 		=> $ulod_val,
							'dlod' 		=> $dlod_val,
							'clear' 	=> $clear_val,
							'appr' 		=> $appr_val
						);
						$result_presetdtl = $this->main->insert_data('presetdtl', $set, true);
						if($result_presetdtl == FALSE){
							$result_presetdtl_flag=FALSE;
						}
					}

					foreach($bcID as $r){
						$bcIDVal = decode($r);
						$set = array(
							'presetHdrID' => $result['id'],
							'bcID' 		=> $bcIDVal
						);
						$result_bcpresetdtl = $this->main->insert_data('bcpresetdtl', $set, true);
						if($result_bcpresetdtl == FALSE){
							$result_bcpresetdtl_flag=FALSE;
						}
					}

					if($result_presetdtl_flag == FALSE){
						$msg = 'Error in Modules Preset Enrollment Please Call for Support!';
						echo json_encode(array(
							'success' => false,
							'successMsg'=> $msg
						));
						exit;
					}elseif($result_bcpresetdtl_flag == FALSE){
						$msg = 'Error in BC Preset Enrollment Please Call for Support!';
						echo json_encode(array(
							'success' => false,
							'successMsg'=> $msg
						));
						exit;
					}else{
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/add_user_role',
							'logDetail'	=>	'Successfully added User Role ID:'.@$result['id']
						);
						$this->main->user_logs($user_logs);
						$msg = 'Data successfully added.';
						echo json_encode(array(
							'success' => true,
							'successMsg'=> $msg
						));
						exit;
					}

				}else{
					$msg = 'Error user role already exist.</div>';
					echo json_encode(array(
						'success' => false,
						'successMsg'=> $msg
					));
					exit;
				}

				
			}else{
				$msg = 'Error make sure all fields are filled up.';
				echo json_encode(array(
					'success' => false,
					'successMsg'=> $msg
				));
				exit;
			}

			
		}else{
			$msg = 'Error, Posted data are required.';
			echo json_encode(array(
				'success' => false,
				'successMsg'=> $msg
			));
			exit;
		}
	}

	public function modal_user_role(){
		$info = $this->custom_lib->_require_login();
		
		$id = decode($this->input->post('id'));
		//$id=29;
		$check_user_role = $this->main->check_data('presethdr', array('presetHdrID' => $id), TRUE);
		
		if($check_user_role['result'] == TRUE){
			
			
			//get user type
			$get_uType = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeID !=' => 0));
			$data_uType = '';
			
			foreach($get_uType as $row){
				if($row->userTypeID == $check_user_role['info']->userTypeID){
					$data_uType .= '<option value="' . encode($row->userTypeID) . '" selected>' . $row->userTypeName . '</option>';
				}else{
					$data_uType .= '<option value="' . encode($row->userTypeID) . '">' . $row->userTypeName . '</option>';
				}
			}

			$bcIDPreset = array();
			$filter = array(
				'presetHdrID' => $id
			);
			$get_bc_preset = $this->main->get_data('bcpresetdtl', $filter);
			$data_bc = '<option value=""> Select...</option>';
			foreach($get_bc_preset as $r){
				array_push($bcIDPreset,$r->bcID);
			}
			$filter = array(
				'statusID' => 1
			);
			$recFound = $this->main->get_join_datatables('businesscenter a', $join=false, false, 'a.bcName', false, '*', $filter);
			$get_bc = $recFound->result();
			$data_bc	= '<option value="-1"> Select All</option>';
			
			foreach($get_bc as $row){
				
				$selected = in_array($row->bcID, $bcIDPreset) ? 'selected' : '';
				$data_bc .= '<option value="' .encode($row->bcID) .'" ' . $selected. '>'. $row->bcName . '</option>';
			}
			
			//load data to json
			$data['result'] = 1;
			$data['info'] = array(
				'presetHdrID' => $check_user_role['info']->presetHdrID,
				//'userTypeName' => $check_user_role['info']->userTypeName,
				'uTypeID'=>$data_uType,
				'bcID' =>$data_bc
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
		exit();
	}

	public function update_user_role(){

		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$presetHdrID = clean_data(decode($this->input->post('id')));;
			$userTypeID = clean_data(decode($this->input->post('uType-id')));
			$userID = clean_data($this->input->post('userID'));
			$view = clean_data($this->input->post('view'));
			$add = clean_data($this->input->post('add'));
			$edit = clean_data($this->input->post('edit'));
			$act = clean_data($this->input->post('act'));
			$post = clean_data($this->input->post('post'));
			$canc = clean_data($this->input->post('canc'));
			$prnt = clean_data($this->input->post('prnt'));
			$ulod = clean_data($this->input->post('ulod'));
			$dlod = clean_data($this->input->post('dlod'));
			$clear = clean_data($this->input->post('clear'));
			$appr = clean_data($this->input->post('appr'));

			$bcID = clean_data($this->input->post('bc-id'));
			$applyChangesToUsersOnly = clean_data(decode($this->input->post('apply-changes-to-user')));
			$neglectDataAccessChange = clean_data(decode($this->input->post('neglect-data-access-change')));
			
			//decode the value of arrays		
			//for view
			if(!empty($view)){
				foreach($view as $key => &$value){$value = decode($value);}
				//the same as $array[$key] = 12321;
				unset($value);
			}
			//for add
			if(!empty($add)){
				foreach($add as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for edit
			if(!empty($edit)){
				foreach($edit as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for act
			if(!empty($act)){
				foreach($act as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for post
			if(!empty($post)){
				foreach($post as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for canc
			if(!empty($canc)){
				foreach($canc as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for prnt
			if(!empty($prnt)){
				foreach($prnt as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for ulod
			if(!empty($ulod)){
				foreach($ulod as $key => &$value){$value = decode($value);}
				unset($value);
			}
			//for dlod
			if(!empty($dlod)){
				foreach($dlod as $key => &$value){$value = decode($value);}
				unset($value);
			}

			//for clear
			if(!empty($clear)){
				foreach($clear as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//for appr
			if(!empty($appr)){
				foreach($appr as $key => &$value){$value = decode($value);}
				unset($value);
			}
			
			//check for required fields
			$result_presetdtl_flag = TRUE;
			$result_usermodules_flag=TRUE;
			$result_bcpresetdtl_flag=true;
			if(!empty($userTypeID)){
				$check_user_type = $this->main->check_data('presethdr', array('userTypeID' =>  $userTypeID, 'presetHdrID !=' => $presetHdrID));
				if($check_user_type == FALSE){
					if($applyChangesToUsersOnly){
						$filter = array(
							'c.statusID' => 1,
						);
						$recFound = $this->main->get_join_datatables('modules c', false, false, 'c.moduleDesc', false, '*',$filter,false);
						foreach ($recFound->result() as $r) {
							//find moduleID in arrays of check box
							if(is_array($view)){$view_val = in_array($r->moduleID,$view) ? 1 : 0;}else{$view_val=0;}
							if(is_array($add )){$add_val  = in_array($r->moduleID,$add ) ? 1 : 0;}else{$add_val=0;}
							if(is_array($edit)){$edit_val = in_array($r->moduleID,$edit) ? 1 : 0;}else{$edit_val=0;}
							if(is_array($act )){$act_val  = in_array($r->moduleID,$act ) ? 1 : 0;}else{$act_val=0;}
							if(is_array($post)){$post_val = in_array($r->moduleID,$post) ? 1 : 0;}else{$post_val=0;}
							if(is_array($canc)){$canc_val = in_array($r->moduleID,$canc) ? 1 : 0;}else{$canc_val=0;}
							if(is_array($prnt)){$prnt_val = in_array($r->moduleID,$prnt) ? 1 : 0;}else{$prnt_val=0;}
							if(is_array($ulod)){$ulod_val = in_array($r->moduleID,$ulod) ? 1 : 0;}else{$ulod_val=0;}
							if(is_array($dlod)){$dlod_val = in_array($r->moduleID,$dlod) ? 1 : 0;}else{$dlod_val=0;}
							if(is_array($clear)){$clear_val = in_array($r->moduleID,$clear) ? 1 : 0;}else{$clear_val=0;}
							if(is_array($appr)){$appr_val = in_array($r->moduleID,$appr) ? 1 : 0;}else{$appr_val=0;}

							//UPDATE USER MODULE
							if(!empty($userID)){
								foreach($userID as $row){
									$userIDVal = decode($row);
									// CHECK IF USER, KEY, ROLE AND MODULE EXIST
									$filter = array(
										'userTypeID' =>  $userTypeID,
										'userID' => $userIDVal,
										'moduleID' => $r->moduleID,
										'keyID' => decode($info['current_keyID'])
									);
									$check_user_module = $this->main->check_data('usermodules', $filter, TRUE);
									if($check_user_module['result']){
										// UPDATE	
									
										$where = array(
											'userID' =>  $userIDVal,
											'moduleID'	=>	$r->moduleID,
											'userTypeID' => $userTypeID
										);

										$set = array(
											'userID' 	=> $userIDVal,
											'moduleID' 	=> $r->moduleID,
											'statusID'	=> 1,
											'view' 		=> $view_val,
											'add' 		=> $add_val,
											'edit' 		=> $edit_val,
											'act' 		=> $act_val,
											'post' 		=> $post_val,
											'canc' 		=> $canc_val,
											'prnt' 		=> $prnt_val,
											'ulod' 		=> $ulod_val,
											'dlod' 		=> $dlod_val,
											'clear' 	=> $clear_val,
											'appr' 		=> $appr_val
										);
										//$result_usermodules = $this->main->insert_data('usermodules', $set, true);
										$result_usermodules = $this->main->update_data('usermodules', $set, $where);
									} else {
										// INSERT NEW WITH ACTIVE USER KEY
										$get_user_keys = $this->main->get_data('userkey', 'statusID = 1 and userID = '. $userIDVal);
										if(!empty($get_user_keys)){
											foreach($get_user_keys as $user_key){
												$keyID = $user_key->keyID;

												$set = array(
													'userID' 	=> $userIDVal,
													'moduleID' 	=> $r->moduleID,
													'keyID' 	=> $keyID,
													'userTypeID' => $userTypeID,
													'statusID'	=> 1,
													'createdTS'	=> date_now(),
													'view' 		=> $view_val,
													'add' 		=> $add_val,
													'edit' 		=> $edit_val,
													'act' 		=> $act_val,
													'post' 		=> $post_val,
													'canc' 		=> $canc_val,
													'prnt' 		=> $prnt_val,
													'ulod' 		=> $ulod_val,
													'dlod' 		=> $dlod_val,
													'clear' 	=> $clear_val,
													'appr' 		=> $appr_val
												);
												$result_usermodules = $this->main->insert_data('usermodules', $set);
											}
										}
									}
									if($result_usermodules == FALSE){
										$result_usermodules_flag=FALSE;
									}
								}
							}
						}

						if(!$neglectDataAccessChange){

							$userbc_ctr = 0;
							foreach($bcID as $r){
								//UPDATE USER MODULE
								$bcIDVal = decode($r);
								if(!empty($userID)){
									foreach($userID as $row){
										$userIDVal = decode($row);
										if($userbc_ctr==0){
											$this->main->void_table('userbc', array('userID' =>  $userIDVal));
										}
										$set = array(
											'userID' => $userIDVal,
											'bcID' 		=> $bcIDVal,
											'statusID' => 1,
											'createdTS' => date_now()
										);
										$result_usermodules = $this->main->insert_data('userbc', $set, true);
										if($result_usermodules == FALSE){
											$result_usermodules_flag=FALSE;
										}
									}
								}
								$userbc_ctr++;
							}
						}
					} else {
						// SET PRESET TEMPLATE HDR
						$set = array(
							'userTypeID' 	=> $userTypeID,
							'statusID' 	=> 1,
							'modifiedTS' => date_now(),
							'modifiedBy'	=> decode($info['userID']),
						);
						$where = array(
							'presetHdrID' => $presetHdrID
						);
						$result = $this->main->update_data('presethdr', $set, $where);
	
						//SET PRESET TEMPLATE DTL
						if($result){
							$this->main->void_table('presetdtl', array('presetHdrID' =>  $presetHdrID));
							$this->main->void_table('bcpresetdtl', array('presetHdrID' =>  $presetHdrID));
							$filter = array(
								'c.statusID' => 1,
							);
							$recFound = $this->main->get_join_datatables('modules c', false, false, 'c.moduleDesc', false, '*',$filter,false);
							foreach ($recFound->result() as $r) {
								//find moduleID in arrays of check box
								if(is_array($view)){$view_val = in_array($r->moduleID,$view) ? 1 : 0;}else{$view_val=0;}
								if(is_array($add )){$add_val  = in_array($r->moduleID,$add ) ? 1 : 0;}else{$add_val=0;}
								if(is_array($edit)){$edit_val = in_array($r->moduleID,$edit) ? 1 : 0;}else{$edit_val=0;}
								if(is_array($act )){$act_val  = in_array($r->moduleID,$act ) ? 1 : 0;}else{$act_val=0;}
								if(is_array($post)){$post_val = in_array($r->moduleID,$post) ? 1 : 0;}else{$post_val=0;}
								if(is_array($canc)){$canc_val = in_array($r->moduleID,$canc) ? 1 : 0;}else{$canc_val=0;}
								if(is_array($prnt)){$prnt_val = in_array($r->moduleID,$prnt) ? 1 : 0;}else{$prnt_val=0;}
								if(is_array($ulod)){$ulod_val = in_array($r->moduleID,$ulod) ? 1 : 0;}else{$ulod_val=0;}
								if(is_array($dlod)){$dlod_val = in_array($r->moduleID,$dlod) ? 1 : 0;}else{$dlod_val=0;}
								if(is_array($clear)){$clear_val = in_array($r->moduleID,$clear) ? 1 : 0;}else{$clear_val=0;}
								if(is_array($appr)){$appr_val = in_array($r->moduleID,$appr) ? 1 : 0;}else{$appr_val=0;}
								
								$set = array(
									'presetHdrID' => $presetHdrID,
									'moduleID' 	=> $r->moduleID,
									'view' 		=> $view_val,
									'add' 		=> $add_val,
									'edit' 		=> $edit_val,
									'act' 		=> $act_val,
									'post' 		=> $post_val,
									'canc' 		=> $canc_val,
									'prnt' 		=> $prnt_val,
									'ulod' 		=> $ulod_val,
									'dlod' 		=> $dlod_val,
									'clear' 	=> $clear_val,
									'appr' 		=> $appr_val
								);
								$result_presetdtl = $this->main->insert_data('presetdtl', $set, true);
								if($result_presetdtl == FALSE){
									$result_presetdtl_flag=FALSE;
								}
	
								//UPDATE USER MODULE
								if(!empty($userID)){
									foreach($userID as $row){
										$userIDVal = decode($row);

										// CHECK IF USER, ROLE AND MODULE EXIST
										$filter = array(
											'userTypeID' =>  $userTypeID,
											'userID' => $userIDVal,
											'moduleID' => $r->moduleID,
											'keyID' => decode($info['current_keyID'])
										);
										$check_user_module = $this->main->check_data('usermodules', $filter, TRUE);
										if($check_user_module['result']){
											// UPDATE
											$where = array(
												'userID' =>  $userIDVal,
												'moduleID'	=>	$r->moduleID,
												'userTypeID' => $userTypeID
											);
	
											$set = array(
												'userID' 	=> $userIDVal,
												'moduleID' 	=> $r->moduleID,
												'statusID'	=> 1,
												'view' 		=> $view_val,
												'add' 		=> $add_val,
												'edit' 		=> $edit_val,
												'act' 		=> $act_val,
												'post' 		=> $post_val,
												'canc' 		=> $canc_val,
												'prnt' 		=> $prnt_val,
												'ulod' 		=> $ulod_val,
												'dlod' 		=> $dlod_val,
												'clear' 	=> $clear_val,
												'appr' 		=> $appr_val
											);
											
											$result_usermodules = $this->main->update_data('usermodules', $set, $where);
											
										} else {
											// INSERT NEW WITH ACTIVE USER KEY
											$get_user_keys = $this->main->get_data('userkey', 'statusID = 1 and userID = '. $userIDVal);
											if(!empty($get_user_keys)){
												foreach($get_user_keys as $user_key){
													$keyID = $user_key->keyID;

													$set = array(
														'userID' 	=> $userIDVal,
														'moduleID' 	=> $r->moduleID,
														'keyID' 	=> $keyID,
														'userTypeID' => $userTypeID,
														'statusID'	=> 1,
														'createdTS'	=> date_now(),
														'view' 		=> $view_val,
														'add' 		=> $add_val,
														'edit' 		=> $edit_val,
														'act' 		=> $act_val,
														'post' 		=> $post_val,
														'canc' 		=> $canc_val,
														'prnt' 		=> $prnt_val,
														'ulod' 		=> $ulod_val,
														'dlod' 		=> $dlod_val,
														'clear' 	=> $clear_val,
														'appr' 		=> $appr_val
													);
													$result_usermodules = $this->main->insert_data('usermodules', $set);
												}
											}
										}

										
										if($result_usermodules == FALSE){
											$result_usermodules_flag=FALSE;
										}

									}
								}
							}
							
							
							$userbc_ctr = 0;
							foreach($bcID as $r){
								$bcIDVal = decode($r);
								$set = array(
									'presetHdrID' => $presetHdrID,
									'bcID' 		=> $bcIDVal
								);
								$result_bcpresetdtl = $this->main->insert_data('bcpresetdtl', $set, true);
								if($result_bcpresetdtl == FALSE){
									$result_bcpresetdtl_flag=FALSE;
								}
	
								//UPDATE USER MODULE
								if(!$neglectDataAccessChange){
									if(!empty($userID)){
										foreach($userID as $row){
											$userIDVal = decode($row);
											if($userbc_ctr==0){
												$this->main->void_table('userbc', array('userID' =>  $userIDVal));
											}
											
											$set = array(
												'userID' => $userIDVal,
												'bcID' 		=> $bcIDVal,
												'statusID' => 1,
												'createdTS' => date_now()
											);
											$result_usermodules = $this->main->insert_data('userbc', $set, true);
											if($result_usermodules == FALSE){
												$result_usermodules_flag=FALSE;
											}
										}
									}
								}
								$userbc_ctr++;
							}
							
						}
					}

					if($result_presetdtl_flag == FALSE){
						$msg = 'Error in Modules Preset Enrollment Please Call for Support!';
						echo json_encode(array(
							'success' => false,
							'successMsg'=> $msg
						));
						exit;
					}elseif($result_usermodules_flag==FALSE){
						$msg = 'Error in User Modules Overwriting. Please Call for Support!';
						echo json_encode(array(
							'success' => false,
							'successMsg'=> $msg
						));
						exit;
					}elseif($result_bcpresetdtl_flag == FALSE){
						$msg = 'Error in BC Preset Enrollment Please Call for Support!';
						echo json_encode(array(
							'success' => false,
							'successMsg'=> $msg
						));
						exit;
					}else{
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/update_user_role',
							'logDetail'	=>	'Successfully updated User Role ID:'.$presetHdrID
						);
						$this->main->user_logs($user_logs);
						$msg = 'Data successfully updated.';
						echo json_encode(array(
							'success' => true,
							'successMsg'=> $msg
						));
						exit;
					}

				}else{
					$msg = 'Error user role already exist.</div>';
					echo json_encode(array(
						'success' => false,
						'successMsg'=> $msg
					));
					exit;
				}

				
			}else{
				$msg = 'Error make sure all fields are filled up.';
				echo json_encode(array(
					'success' => false,
					'successMsg'=> $msg
				));
				exit;
			}

			
		}else{
			$msg = 'Error, Posted data are required.';
			echo json_encode(array(
				'success' => false,
				'successMsg'=> $msg
			));
			exit;
		}
	}

	public function deactivate_user_role(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$presetHdrID = decode(clean_data($this->input->post('id')));

			if(!empty($presetHdrID)){
				$check_user_role = $this->main->check_data('presethdr', array('presetHdrID' => $presetHdrID, 'statusID' => 2), true);
				if($check_user_role['result'] == FALSE){

					$set = array('statusID' => 2);
					$where = array('presetHdrID' => $presetHdrID);
					$result = $this->main->update_data('presethdr', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_user_role',
							'logDetail'	=>	'Successfully deactivated User Role ID:'.@$presetHdrID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'User Role successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. User Role already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. User Role ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_user_role(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$presetHdrID = decode(clean_data($this->input->post('id')));

			if(!empty($presetHdrID)){
				$check_user_role = $this->main->check_data('presethdr', array('presetHdrID' => $presetHdrID, 'statusID' => 1), true);
				if($check_user_role['result'] == FALSE){

					$set = array('statusID' => 1);
					$where = array('presetHdrID' => $presetHdrID);
					$result = $this->main->update_data('presethdr', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_user_role',
							'logDetail'	=>	'Successfully deactivated User Role ID:'.@$presetHdrID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'User Role successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. User Role already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. User Role ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	/* end of user roles */




	/* ROLES CONTROLLER */

	public function roles(){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		
		$data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('roles');
		$data['new_button'] = '<div class="row col-lg-12">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '
			
				<button type="button" class="add-role-btn '.$btn_class.'"><span class="fas fa-plus "></span></button>
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';

		if(!$module_access->view){redirect('admin');}
		
		$data['title'] = 'Roles';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Users Config';


		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/roles_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function roleGrid(){
		$info = $this->custom_lib->_require_login();
		$module_access = $this->custom_lib->module_access('roles');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$filter = array('userTypeID >' => 0);
		$recFound = $this->main->get_join_datatables('usertype a', false, false, 'a.userTypeName', 'a.userTypeID', 'a.*', $filter, false);
		$toggle = '';
		$primary_action = '';
		$reset = '';
		foreach ($recFound->result() as $r) {

			if($r->statusID == 1){
		        $badge = '<span class="badge badge-success">Active</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->userTypeID) . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->statusID == 2){
		        $badge = '<span class="badge badge-warning">Inactive</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->userTypeID) . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }

		    
		    
			if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-role" data-id="'.encode($r->userTypeID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }


			$data[] = array(	
				$r->userTypeID,
				$r->userTypeName,
				$r->userTypeLevel,
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_role(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$userTypeName = clean_data($this->input->post('user-type-name'));
			$userTypeLevel = clean_data($this->input->post('user-type-level'));
			

			if(!empty($userTypeName)){

					

				$check_usertypename = $this->main->check_data('usertype', array('userTypeName' => $userTypeName));

				if($check_usertypename == FALSE){
					$set = array(
								
						'userTypeName' => strtoupper($userTypeName),
						'userTypeLevel' => strtoupper($userTypeLevel),
						'statusID' => 1
					);

					$result = $this->main->insert_data('usertype', $set, TRUE);
							
					if($result){

						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/add_role',
							'logDetail'	=>	'Successfully added Role:'.$userTypeName
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
		                	'success'       =>    true,
		                	'successMsg'    =>    'Role added successfully.'
		                ));
					}
				} else {
					echo json_encode(array(
	                	'success'       =>    false,
	                	'successMsg'    =>    'Role already exist.'
	                ));
				}
			}else{
				echo json_encode(array(
                	'success'       =>    false,
                	'successMsg'    =>    'Make sure all fields are filled.'
                ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Please contact your administrator.'
            ));
		}
	}

	public function modal_role(){
		$info = $this->custom_lib->_require_login();

		$id = decode($this->input->post('id'));

		$join = array(
			'stats b' => 'a.statusID = b.statusID and a.userTypeID = "'.$id.'"'
		);
		$check_user_type = $this->main->check_join('usertype a', $join, true);
		
		if($check_user_type['result'] == TRUE){
			

			$data['result'] = 1;
			$data['info'] = array(
				'userTypeName' => $check_user_type['info']->userTypeName,
				'userTypeLevel' => $check_user_type['info']->userTypeLevel,
				'userTypeID' => $check_user_type['info']->userTypeID
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
	}

	public function update_role(){
		$info = $this->custom_lib->_require_login();
		/*var_dump($_POST);
		exit();*/

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userTypeName = clean_data($this->input->post('user-type-name'));
			$userTypeLevel = clean_data($this->input->post('user-type-level'));
			$userTypeID = clean_data(decode($this->input->post('id')));

			if(!empty($userTypeName) && !empty($userTypeID)){
					
				$check_usertypename = $this->main->check_data('usertype', array('userTypeName' => $userTypeName, 'userTypeID !=' => $userTypeID));

				if($check_usertypename == FALSE){

					$set = array(
						'userTypeName' => strtoupper($userTypeName),
						'userTypeLevel' => strtoupper($userTypeLevel),
					);

					$result = $this->main->update_data('usertype', $set, array('userTypeID' => $userTypeID));
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/update_role',
							'logDetail'	=>	'Successfully updated role id:'.@$userTypeID
						);
				        $this->main->user_logs($user_logs);
						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Role successfully updated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				} else {
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. Role already exist.'
		            ));
				}
					
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Please make sure all required fields are filled.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function deactivate_role(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userTypeID = decode(clean_data($this->input->post('id')));

			if(!empty($userTypeID)){
				$check_usertypename = $this->main->check_data('usertype', array('userTypeID' => $userTypeID, 'statusID' => 2), true);
				if($check_usertypename['result'] == FALSE){

					$set = array('statusID' => 2);
					$where = array('userTypeID' => $userTypeID);
					$result = $this->main->update_data('usertype', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_role',
							'logDetail'	=>	'Successfully deactivated Role ID:'.@$userTypeID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Role successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. Role already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Role ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_role(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userTypeID = decode(clean_data($this->input->post('id')));

			if(!empty($userTypeID)){
				$check_usertypename = $this->main->check_data('usertype', array('userTypeID' => $userTypeID, 'statusID' => 1), true);
				if($check_usertypename['result'] == FALSE){

					$set = array('statusID' => 1);
					$where = array('userTypeID' => $userTypeID);
					$result = $this->main->update_data('usertype', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_role',
							'logDetail'	=>	'Successfully activated Role ID:'.@$userTypeID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Role successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. Role already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Role ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	/* END OF ROLES */


	/* USER SLOC CONTROLLER */

	public function user_sloc(){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		
		$data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('user_sloc');
		$data['new_button'] = '<div class="row col-lg-12">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '
			
				<button type="button" class="add-user-sloc-btn '.$btn_class.'"><span class="fas fa-plus "></span></button>
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';

		if(!$module_access->view){redirect('admin');}
		
		$data['title'] = 'User SLoc';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Users Config';
		
		$data['uType'] = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeID !=' => 0));

		$where = array('key.statusID' => 1, 'key.buID' => 1);
		$join = array('businessunit ' => 'key.buID = businessunit.buID',
					  'businesscenter ' => 'key.bcID = businesscenter.bcID',
					  'company' => 'key.coID = company.coID'
		);
		$recFound = $this->main->get_join_datatables('key', $join, false, 'key.keyCode', false, 'key.*,key.keyCode,  company.coSDesc, businessunit.buSDesc, businesscenter.bcCode',$where,false);
		$data['key'] = $recFound->result();

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/user_sloc_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function userSlocGrid(){
		$info = $this->custom_lib->_require_login();
		$module_access = $this->custom_lib->module_access('user_sloc');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$filter = array(
			'e.keyID' => decode($info['current_keyID'])
		);
		$join = array(
			'users b' => 'a.userID = b.userID',
			'storagelocation c' => 'a.slocID = c.slocID',
			'cgdtl d' => 'c.slocID = d.slocID',
			'vet e' => 'd.vetID = e.vetID'
		);
		$recFound = $this->main->get_join_datatables('usersloc a', $join, false, 'b.userFirstName, b.userEmail, c.slocName', false, 'c.*, b.*, a.*', $filter, false);
		$toggle = '';
		$primary_action = '';
		$reset = '';
		$current = '';
		foreach ($recFound->result() as $r) {

			if($r->statusID == 1){
		        $badge = '<span class="badge badge-success">Active</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->userSLocID) . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->statusID == 2){
		        $badge = '<span class="badge badge-warning">Inactive</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->userSLocID) . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }

			


			$data[] = array(	
				$r->userFirstName.' '.$r->userLastName,
				$r->userEmail,
				'['.$r->slocCode.'] '.$r->slocName,
				
				time_stamp_display($r->createdTS),
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_user_sloc(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$userID = clean_data($this->input->post('userID'));
			$sLocID = clean_data($this->input->post('sLoc-id'));
			$keyID = clean_data($this->input->post('key-id'));
			$applyChangesToAddtlSloc = clean_data(decode($this->input->post('apply-changes-to-addtl-sloc')));
			$applyChangesToAddtlKey = clean_data(decode($this->input->post('apply-changes-to-addtl-key')));
			$overWriteKey = clean_data(decode($this->input->post('overwrite-key')));
			$overWriteSloc = clean_data(decode($this->input->post('overwrite-sloc')));

			if(!empty($userID) && !empty($sLocID)){
				
				foreach($userID as $row){
					$userID_val = decode($row);

					if($overWriteKey){
						//deactivate all user key
						$set_key = array('statusID' => 2);
						$where = array(
							'userID' => $userID_val
						);
						$this->main->update_data('userkey', $set_key, $where);
					}
					$result_userkey=TRUE;
					//add each user's key
					foreach ($keyID as $r) {
									
						$keyID_val = decode($r);
						//check for existing data
						$check_userKey = $this->main->check_data('userkey', array('userID' =>  $userID_val, 'keyID'	=>	$keyID_val), TRUE);
						
						if($check_userKey['result'] == true){
							if($applyChangesToAddtlKey != 1){
								//if found - activate
								$set_key = array('statusID' => 1);
								$where = array(
									'userID' => $userID_val,
									'keyID'=> $keyID_val
								);
								
								$result = $this->main->update_data('userkey', $set_key, $where);
							} else {
								$result = 1;
							}
						}else{
							//insert data
							$set_key = array(
								'userID' => $userID_val,
								'keyID' => $keyID_val,
								'createdTS' => date_now(),
								'statusID' => 1
							);

							$result = $this->main->insert_data('userkey', $set_key);
							
						}
						//check result
						if($result == FALSE){
							$result_userkey=FALSE;
						}
					}

					$result_usersloc=true;
					if($result_userkey == FALSE){
						echo json_encode(array(
							'success'       =>    false,
							'successMsg'    =>    'Error in Adding User Key! Please Call for Support!'
						));
					} else {

						if($overWriteSloc){
							//deactivate all user sloc
							$set_sLoc = array('statusID' => 2);
							$where = array(
								'userID' => $userID_val
							);
							$this->main->update_data('usersloc', $set_sLoc, $where);
						}
						//add each user's sloc
						foreach ($sLocID as $r) {
											
							$sLocID_val = decode($r);
							//check for existing data
							$check_userSloc = $this->main->check_data('usersloc', array('userID' =>  $userID_val, 'slocID'	=>	$sLocID_val), TRUE);
	
							
							
							if($check_userSloc['result'] == true){
								
								if($applyChangesToAddtlSloc != 1){
									
									//if found - activate
									$set_sLoc = array('statusID' => 1);
									$where = array(
										'userID' => $userID_val,
										'slocID'=> $sLocID_val
									);
									
									$result = $this->main->update_data('usersloc', $set_sLoc, $where);
								} else {
									$result = 1;
								}
								
							}else{
								$set_sLoc = array(
									'userID' => $userID_val,
									'sLocID' => $sLocID_val,
									'createdTS' => date_now(),
									'statusID' => 1
								);
		
								$result = $this->main->insert_data('usersloc', $set_sLoc);
							}
							//check result
							if($result == FALSE){
								$result_usersloc=FALSE;
							}
						}
					}
				}

				if($result_usersloc == FALSE){
					echo json_encode(array(
						'success'       =>    false,
						'successMsg'    =>    'Error in Adding User SLoc! Please Call for Support!'
					));
				} else {
					$user_logs = array(
						'userID'	=>	decode($info['userID']),
						'userFullName' =>	$info['userFullName'],
						'logTS'	=>	date_now(),
						'page'	=>	'Admin/add_user_sloc',
						'logDetail'	=>	'Successfully added User SLoc'
					);
					$this->main->user_logs($user_logs);
					echo json_encode(array(
						'success'       =>    true,
						'successMsg'    =>    'User SLoc successfully added.'
					));
				}

			}else{
				echo json_encode(array(
                	'success'       =>    false,
                	'successMsg'    =>    'Make sure all fields are filled.'
                ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Please contact your administrator.'
            ));
		}
	}

	public function deactivate_user_sloc(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userSLocID = decode(clean_data($this->input->post('id')));

			if(!empty($userSLocID)){
				$check_usertypename = $this->main->check_data('usersloc', array('userSLocID' => $userSLocID, 'statusID' => 2), true);
				if($check_usertypename['result'] == FALSE){

					$set = array('statusID' => 2);
					$where = array('userSLocID' => $userSLocID);
					$result = $this->main->update_data('usersloc', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_user_sloc',
							'logDetail'	=>	'Successfully deactivated User SLoc ID:'.@$userSLocID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'User SLoc successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. User SLoc already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. User SLoc ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_user_sloc(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$userSLocID = decode(clean_data($this->input->post('id')));

			if(!empty($userSLocID)){
				$check_usertypename = $this->main->check_data('usersloc', array('userSLocID' => $userSLocID, 'statusID' => 1), true);
				if($check_usertypename['result'] == FALSE){

					$set = array('statusID' => 1);
					$where = array('userSLocID' => $userSLocID);
					$result = $this->main->update_data('usersloc', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/activate_user_sloc',
							'logDetail'	=>	'Successfully activated User SLoc ID:'.@$userSLocID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'User SLoc successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. User SLoc already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. User SLoc ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	/* END OF USER SLOC */



	/*  
	module: Business Center Controller
	desc: CRUD of Business Center (location)
	date created: 2020-05-03
	created by: Aljune
	Change Management #1
		Date: 2020-06-03
		Description: Continuation of CRUD (Add, Edit, Deactivation, & Activation)
		Modified By: Allayne
	*/
	public function branch($centerTypeID = false){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		
		$backgroundColorClass = get_user_theme(array('a.userID' => decode($info['userID'])), true)->backgroundColor == 'dark' || get_user_theme(array('a.userID' => decode($info['userID'])), true)->backgroundColor == 'dark2' ? 'bg-dark text-info' : '';
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$keyID = decode($info['current_keyID']);
		$bc_access = $this->custom_lib->_get_access( array('keyID' => $keyID, 'statusID' => 1), 'bcID' );
		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		
		$module_access = $this->custom_lib->module_access('business_center');
		$data['new_button'] = '<div class="row"><div class="col-lg-6">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){

			$data['new_button'] .= '
			
				<button type="button" class="add-bc '.$btn_class.'" ><span class="fas fa-plus"></span></button><button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';


		$data['new_button'] .= '<div class="col-lg-6">';

		$center_type = $this->main->get_data('centertype', array('statusID' => 1));

		if($centerTypeID){

			$get_center_type = $this->main->get_data('centertype', array('statusID' => 1, 'centerTypeID' => decode($centerTypeID)), FALSE);
			$centerType = $get_center_type[0]->centerType;
		} else {
			$get_center_type = $this->main->get_data('centertype', array('statusID' => 1), FALSE);
			$centerType = 'ALL CENTERS';
		}
		$data['centerTypeID'] = $centerTypeID;
		if(!empty($center_type)){
			$data['new_button'] .= '
				<div class="btn-group dropdown float-right">
					<button type="button" class="btn btn-sm btn-round btn-'.$data['btnColor'].' mb-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-filter mr-1"></i>'.$centerType.'
					</button>
					<ul class="dropdown-menu '.$backgroundColorClass.'" role="menu" aria-labelledby="dropdownMenu">';
			$data['new_button'] .= '<li><a class="dropdown-item" href="'.base_url('admin/branch').'">ALL CENTERS</a></li>';
			foreach($center_type as $r){

				$data['new_button'] .= '<li><a class="dropdown-item" href="'.base_url('admin/branch/'.encode($r->centerTypeID)).'">'.$r->centerType.'</a></li>';
			}
			$data['new_button'] .= '</ul></div>';
		}
		$data['new_button'] .= '</div></div>';

		
		
		if(!$module_access->view){redirect('admin');}
		
		$data['title'] = 'Branch';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Location Config';

		$data['centertype'] = $get_center_type;
		$data['region'] = $this->main->get_data('region', array('statusID' => 1));

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);

		$data['content'] = $this->load->view('admin/bc_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function bcGrid($centerTypeID = false){
		$info = $this->custom_lib->_require_login();
		$keyID = decode($info['current_keyID']);
		$userID = decode($info['userID']);
		
		$module_access = $this->custom_lib->module_access('business_center');
		
		$bc_access = $this->custom_lib->_get_data_access( array('userID' => $userID, 'statusID' => 1));
		$where_in_field = FALSE;
		$where_in = FALSE;
		if(!empty($bc_access)){
			$where_in_field = 'a.bcID';
			$where_in = $bc_access;
		}

		$where = FALSE;
		if($centerTypeID){
			$where['a.centerTypeID'] = decode($centerTypeID);
		}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array(
					'region b' => array('a.rgID = b.rgID' => 'INNER'),
					'stats c' => array('a.statusID = c.statusID' => 'INNER'),
					'centertype d' => array('a.centerTypeID = d.centerTypeID' => 'INNER'),
					'users e' => array('a.bc_added_by = e.userID' => 'INNER'),
					'users f' => array('a.bc_modified_by = f.userID' => 'LEFT'),
					);
		$recFound = $this->main->get_join_datatables('businesscenter a', $join, false, 'b.rgLDesc, a.bcName', false, '*, a.statusID as bcStatusID, CONCAT(e.userFirstName," ",e.userLastName) as userFullName, CONCAT(f.userFirstName," ",f.userLastName) as userFullNameModifier', $where, $where_in_field, $where_in);
		$primary_action = '';
		$toggle = '';
		foreach ($recFound->result() as $r) {

			if($r->bcStatusID == 1){
		        $badge = '<span class="badge badge-success">'.$r->statDesc.'</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->bcID) . '" data-val="' . $r->bcCode ." - ". $r->bcName. '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->bcStatusID == 2){
		        $badge = '<span class="badge badge-warning">'.$r->statDesc.'</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->bcID) . '" data-val="' . $r->bcCode ." - ". $r->bcName. '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }
		    if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-bc" data-id="'.encode($r->bcID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }

			$createdBy = $r->userFullName;
            $modifiedOn = $r->bc_modified_by == '' ? '' : time_stamp_display($r->bc_modified_date);
            $modifiedBy = $r->bc_modified_by == '' ? '' : $r->userFullNameModifier;

			$data[] = array(	
				$r->bcCode,
				$r->bcName,
				$r->pCode,
				$r->rgLDesc,
				$r->centerType,
				$createdBy,
				time_stamp_display($r->bc_added_date),
                $modifiedBy,
				$modifiedOn,
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}
	
	public function add_bc(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$rgID 	= decode(clean_data($this->input->post('rg-id')));
			$bcCode = clean_data($this->input->post('bc-code'));
			$bcName = clean_data($this->input->post('bc-name'));
			$pCode 	= clean_data($this->input->post('plant-code'));
			$centerTypeID 	= decode(clean_data($this->input->post('center-type-id')));
			
			
			if( !empty($rgID) && !empty($bcCode) && !empty($bcName) && !empty($pCode) ){
				
				$bcCode = trim(strtoupper($bcCode));
				$bcName = trim(strtoupper($bcName));
				$pCode 	= trim(strtoupper($pCode));
				
				$check_bc_code = $this->main->check_data('businesscenter', 
					array(
						'bcCode' =>  $bcCode,
						'pCode' =>  $pCode,
						'rgID' =>  $rgID
				));
				
				if($check_bc_code == TRUE){
					
					echo json_encode(array(
		            	'success'	=>	false,
		            	'successMsg'=>  'Opps. A combination of Business Center Code, Plant Code, and Region already exist.'
		            ));
					
				}else{	
						
					$set = array(
						'rgID' 		=> $rgID,
						'bcCode'	=> $bcCode,
						'pCode'		=> $pCode,
						'bcName'	=> $bcName,
						'centerTypeID' =>  $centerTypeID,
						'statusID' 	=> 1,
						'bc_added_by'    => decode($info['userID']),
						'bc_added_date'  => date_now(),
						'bc_modified_date'  => date_now(),
					);

					$result = $this->main->insert_data('businesscenter', $set, TRUE);

					if($result == TRUE){
						$user_logs = array(
							'userID'		=>	decode($info['userID']),
							'userFullName'	=>	$info['userFullName'],
							'logTS'			=>	date_now(),
							'page'			=>	'Admin/add_bc',
							'logDetail'		=>	'Successfully added bcID:'.@$result['id']
						);
						$this->main->user_logs($user_logs);

						echo json_encode(array(
							'success'       =>    true,
							'successMsg'    =>    'Center successfully added.',
							'bcID' => $result['id'],
			                'bcName' => trim(strtoupper($bcName))
						));
					}else{
						echo json_encode(array(
							'success'       =>    false,
							'successMsg'    =>    'Opps. Please try again.'
						));
					}
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Please make sure all required fields are filled.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}
	
	public function modal_bc(){
		$info 	= $this->custom_lib->_require_login();
		$id		= decode($this->input->post('id'));
		$centerTypeIDPosted		= $this->input->post('centerTypeID');
		if($centerTypeIDPosted){
			$centerTypeIDPosted = decode($centerTypeIDPosted);
		}
		
		$join 	= array(
			'stats b' => 'a.statusID = b.statusID and a.bcID = '.$id,
		);
		
		$check_bc = $this->main->check_join('businesscenter a', $join, true);
		
		if($check_bc['result'] == TRUE){
			$rgID	= $check_bc['info']->rgID;
			$bcCode	= $check_bc['info']->bcCode;
			$pCode	= $check_bc['info']->pCode;
			$bcName	= $check_bc['info']->bcName;
			$centerTypeID	= $check_bc['info']->centerTypeID;
			
			$get_rg 	= $this->main->get_data('region', array('statusID' => 1));
			$data_rg 	= '<option value=""> Select...</option>';
			
			foreach($get_rg as $row){
				if($row->rgID == $rgID){
					$data_rg .= '<option value="' . $row->rgID . '" selected>' . $row->rgLDesc . '</option>';
				}else{
					$data_rg .= '<option value="' . $row->rgID . '">' . $row->rgLDesc . '</option>';
				}
			}

			$filter = array('statusID' => 1);
			if($centerTypeIDPosted){
				$filter['centerTypeID'] = $centerTypeIDPosted;
			}
			$get_center_type = $this->main->get_data('centertype', $filter);
			$data_c_type 	= '<option value=""> Select...</option>';
			
			foreach($get_center_type as $row){
				if($row->centerTypeID == $centerTypeID){
					$data_c_type .= '<option value="' . $row->centerTypeID . '" selected>' . $row->centerType . '</option>';
				}else{
					$data_c_type .= '<option value="' . $row->centerTypeID . '">' . $row->centerType . '</option>';
				}
			}

			$data['result'] = 1;
			$data['info'] = array(
				'rgID' 		=> $data_rg,
				'centerTypeID' 		=> $data_c_type,
				'bcCode'	=> $bcCode,
				'pCode'		=> $pCode,
				'bcName'	=> $bcName
				
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
	}
	
	public function update_bc(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$bcID 	= decode($this->input->post('id'));
			$bcCode	= clean_data($this->input->post('bc-code'));
			$bcName	= clean_data($this->input->post('bc-name'));
			$pCode 	= clean_data($this->input->post('plant-code'));
			$rgID 	= clean_data($this->input->post('rg-id'));
			$centerTypeID 	= clean_data($this->input->post('center-type-id'));
			
			
			if( !empty($rgID) && !empty($bcCode) && !empty($bcName) && !empty($pCode) ){
				
				$bcCode = trim(strtoupper($bcCode));
				$bcName = trim(strtoupper($bcName));
				$pCode 	= trim(strtoupper($pCode));
				
				$check_bc_code = $this->main->check_data('businesscenter', 
					array(
						'bcCode'	=>  $bcCode,
						'pCode'		=>  $pCode,
						'rgID' 		=>  $rgID,
						'bcID !='	=>	$bcID,
				),true);
				
				
				if($check_bc_code['result'] == FALSE){

					$set = array(
						'rgID' 		=> $rgID,
						'bcCode'	=> $bcCode,
						'pCode'		=> $pCode,
						'bcName'	=> $bcName,
						'centerTypeID'	=> $centerTypeID,
						'bc_modified_by' => decode($info['userID']),
						'bc_modified_date'   => date_now()
					);

					$result = $this->main->update_data('businesscenter', $set, array('bcID' => $bcID));
					
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/update_bc',
							'logDetail'	=>	'Successfully updated bcID:'.@$bcID
						);
						$this->main->user_logs($user_logs);
						echo json_encode(array(
							'success'       =>    true,
							'successMsg'    =>    'Center successfully updated.',
							'centerTypeID'	=>	  $centerTypeID
						));
					}else{
						echo json_encode(array(
							'success'       =>    false,
							'successMsg'    =>    'Opps. Please try again.'
						));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. A combination of Business Center Code, Plant Code, and Region already exist.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Please make sure all required fields are filled.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
		
	}
	
	public function deactivate_bc(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$bcID = decode(clean_data($this->input->post('id')));
			if(!empty($bcID)){
				$check_bc = $this->main->check_data('businesscenter', array('bcID' => $bcID, 'statusID' => 2), true);
				if($check_bc['result'] == FALSE){

					$set = array(
						'statusID' => 2,
						'bc_modified_by' => decode($info['userID']),
						'bc_modified_date'   => date_now()
					);
					$where = array('bcID' => $bcID);
					$result = $this->main->update_data('businesscenter', $set, $where);

					if($result == TRUE){
			            $user_logs = array(
							'userID'		=>	decode($info['userID']),
							'userFullName' 	=>	$info['userFullName'],
							'logTS'			=>	date_now(),
							'page'			=>	'Admin/deactivate_bc',
							'logDetail'		=>	'Successfully deactivated bcID:'.@$bcID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Center successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. Business Center already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. bcID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_bc(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$bcID = decode(clean_data($this->input->post('id')));
			if(!empty($bcID)){
				$check_bc = $this->main->check_data('businesscenter', array('bcID' => $bcID, 'statusID' => 1), true);
				if($check_bc['result'] == FALSE){

					$set = array(
						'statusID' => 1,
						'bc_modified_by' => decode($info['userID']),
						'bc_modified_date'   => date_now()
					);
					$where = array('bcID' => $bcID);
					$result = $this->main->update_data('businesscenter', $set, $where);

					if($result == TRUE){
			            $user_logs = array(
							'userID'		=>	decode($info['userID']),
							'userFullName' 	=>	$info['userFullName'],
							'logTS'			=>	date_now(),
							'page'			=>	'Admin/activate_bc',
							'logDetail'		=>	'Successfully activated bcID:'.@$bcID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Center successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. Business Center already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. bcID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}
	/* 
	end of Business Center Controller Module
	*/


	/*  
	module: region Controller
	desc: CRUD of region (location)
	date created: 2021-04-26
	created by: Aljune
	Change Management #1
		Date: 2020-06-03
		Description: Continuation of CRUD (Add, Edit, Deactivation, & Activation)
		Modified By: Aljune
	*/

	public function region(){
		

		
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

	    $keyID = decode($info['current_keyID']);
	    $userID = decode($info['userID']);
		
		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('region');
		$data['new_button'] = '<div class="row col-lg-12">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '
			
				<button type="button" class="add-region '.$btn_class.'"><span class="fas fa-plus"></span></button>
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';
		
		
		if(!$module_access->view){redirect('admin');}
		
		$bc_access = $this->custom_lib->_get_data_access( array('userID' => $userID, 'statusID' => 1));
		$where_in_field = FALSE;
		$where_in = FALSE;
		if(!empty($bc_access)){
			$where_in_field = 'bcID';
			$where_in = $bc_access;
		}
		// $data['bc'] = $this->main->get_data('businesscenter', array('statusID' => 1), null, FALSE, false, false, false, $where_in_field, $where_in);

		$filter = array('statusID'	=>	1);
		// $data['region'] = $this->main->get_data('region', $filter);

		$data['title'] = 'Region';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'Location Config';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);

		$data['content'] = $this->load->view('admin/region_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function regionGrid(){
		$info = $this->custom_lib->_require_login();
		$keyID = decode($info['current_keyID']);
		$userID = decode($info['userID']);
		$module_access = $this->custom_lib->module_access('region');
		
		$bc_access = $this->custom_lib->_get_data_access( array('userID' => $userID, 'statusID' => 1));
		$where_in_field = FALSE;
		$where_in = FALSE;
		

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array(
					
					'stats c' => 'a.statusID = c.statusID',
					'users e' => array('a.region_added_by = e.userID' => 'INNER'),
					'users f' => array('a.region_modified_by = f.userID' => 'LEFT'),
		);
		$recFound = $this->main->get_join_datatables('region a', $join, false, 'a.rgLDesc', false, '*, a.statusID as regionStatusID, CONCAT(e.userFirstName," ",e.userLastName) as userFullName, CONCAT(f.userFirstName," ",f.userLastName) as userFullNameModifier', false, $where_in_field, $where_in);
		$toggle = '';
		$primary_action = '';
		foreach ($recFound->result() as $r) {

			if($r->regionStatusID == 1){
		        $badge = '<span class="badge badge-success">'.$r->statDesc.'</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->rgID) . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->regionStatusID == 2){
		        $badge = '<span class="badge badge-warning">'.$r->statDesc.'</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->rgID) . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }
		    if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-region" data-id="'.encode($r->rgID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }

			$createdBy = $r->userFullName;
            $modifiedOn = $r->region_modified_by == '' ? '' : time_stamp_display($r->region_modified_date);
            $modifiedBy = $r->region_modified_by == '' ? '' : $r->userFullNameModifier;

			$data[] = array(	
				$r->rgSDesc,
				$r->rgLDesc,
				$createdBy,
				time_stamp_display($r->region_added_date),
                $modifiedBy,
				$modifiedOn,
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_region(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$rgSDesc = clean_data($this->input->post('region-sDesc'));
			$rgLDesc = clean_data($this->input->post('region-lDesc'));
			

			if(!empty($rgLDesc) && !empty($rgSDesc) ){

				$check_rgLDesc = $this->main->check_data('region', array('rgLDesc' =>  $rgLDesc));
				if($check_rgLDesc == FALSE){

					$check_rgSDesc = $this->main->check_data('region', array('rgSDesc' =>  $rgSDesc));
					if($check_rgSDesc == FALSE){

						$set = array(
							'rgSDesc' => trim(strtoupper($rgSDesc)),
							'rgLDesc' => trim(strtoupper($rgLDesc)),
							'statusID' => 1,
							'region_added_by'    => decode($info['userID']),
                            'region_added_date'  => date_now(),
                            'region_modified_date'  => date_now(),
						);

						$result = $this->main->insert_data('region', $set, TRUE);

						if($result['id']){
							$user_logs = array(
								'userID'	=>	decode($info['userID']),
								'userFullName' =>	$info['userFullName'],
								'logTS'	=>	date_now(),
								'page'	=>	'Admin/add_region',
								'logDetail'	=>	'Successfully added region ID:'.@$result['id']
							);
					        $this->main->user_logs($user_logs);

							echo json_encode(array(
			                	'success'       =>    true,
			                	'successMsg'    =>    'Region added successfully.',
			                	'tgID' => $result['id'],
			                	'tgLDesc' => trim(strtoupper($rgLDesc))
			                ));
						}
					}else{
						echo json_encode(array(
		                	'success'       =>    false,
		                	'successMsg'    =>    'Region abbr already exist.'
		                ));
					}
				}else{
					echo json_encode(array(
	                	'success'       =>    false,
	                	'successMsg'    =>    'Region name already exist.'
	                ));
				}
				
			}else{
				echo json_encode(array(
                	'success'       =>    false,
                	'successMsg'    =>    'Make sure all fields are filled.'
                ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Please contact your administrator.'
            ));
		}	
	}

	public function modal_region(){
		$info = $this->custom_lib->_require_login();
		$keyID = decode($info['current_keyID']);
		// $bc_access = $this->custom_lib->_get_access( array('keyID' => $keyID, 'statusID' => 1), 'bcID' );
		

		$id = decode($this->input->post('id'));

		$join = array(
			'stats b' => 'a.statusID = b.statusID and a.rgID = "'.$id.'"',
		);
		$check_region = $this->main->check_join('region a', $join, true);
		
		if($check_region['result'] == TRUE){

			$data['result'] = 1;
			$data['info'] = array(
				'rgLDesc' => $check_region['info']->rgLDesc,
				'rgSDesc' => $check_region['info']->rgSDesc
				
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
	}

	public function update_region(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$rgID = decode($this->input->post('id'));
			$rgSDesc = clean_data($this->input->post('region-sDesc'));
			$rgLDesc = clean_data($this->input->post('region-lDesc'));
			

			if(!empty($rgID) && !empty($rgSDesc) && !empty($rgLDesc)){

				$check_rgLDesc = $this->main->check_data('region', array('rgLDesc' =>  $rgLDesc, 'rgID !=' => $rgID));
				if($check_rgLDesc == FALSE){
					$check_rgSDesc = $this->main->check_data('region', array('rgSDesc' =>  $rgSDesc, 'rgID !=' => $rgID));
					if($check_rgSDesc == FALSE){

						$set = array(
							'rgSDesc' => trim(strtoupper($rgSDesc)),
							'rgLDesc' => trim(strtoupper($rgLDesc)),
							'region_modified_by' => decode($info['userID']),
                            'region_modified_date'   => date_now()
						);

						$result = $this->main->update_data('region', $set, array('rgID' => $rgID));
						if($result == TRUE){
							$user_logs = array(
								'userID'	=>	decode($info['userID']),
								'userFullName' =>	$info['userFullName'],
								'logTS'	=>	date_now(),
								'page'	=>	'Admin/update_region',
								'logDetail'	=>	'Successfully updated region ID:'.@$rgID
							);
					        $this->main->user_logs($user_logs);
							echo json_encode(array(
				            	'success'       =>    true,
				            	'successMsg'    =>    'Region successfully updated.'
				            ));
						}else{
							echo json_encode(array(
				            	'success'       =>    false,
				            	'successMsg'    =>    'Opps. Please try again.'
				            ));
						}
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. region code already exist.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. region abbr already exist.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Please make sure all required fields are filled.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function deactivate_region(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$rgID = decode(clean_data($this->input->post('id')));
			if(!empty($rgID)){
				$check_region = $this->main->check_data('region', array('rgID' => $rgID, 'statusID' => 2), true);
				if($check_region['result'] == FALSE){

					$set = array(
						'statusID' => 2,
						'region_modified_by' => decode($info['userID']),
                        'region_modified_date'   => date_now()
					);
					$where = array('rgID' => $rgID);
					$result = $this->main->update_data('region', $set, $where);

					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_region',
							'logDetail'	=>	'Successfully deactivated region ID:'.@$rgID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Region successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. region already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. region ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_region(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$rgID = decode(clean_data($this->input->post('id')));
			if(!empty($rgID)){
				$check_region = $this->main->check_data('region', array('rgID' => $rgID, 'statusID' => 1), true);
				if($check_region['result'] == FALSE){

					$set = array(
						'statusID' => 1,
						'region_modified_by' => decode($info['userID']),
                        'region_modified_date'   => date_now()
					);
					$where = array('rgID' => $rgID);
					$result = $this->main->update_data('region', $set, $where);

					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/activate_region',
							'logDetail'	=>	'Successfully activated region ID:'.@$rgID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'Region successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. region already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. region ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	// END OF region CONTROLLER


	


	/* SYS MODULES */
	public function sys_modules(){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
		
		$data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('sys_modules');
		$data['new_button'] = '<div class="row col-lg-12">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '
			
				<button type="button" class="add-sys-module-btn '.$btn_class.'"><span class="fas fa-plus "></span></button>
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}
		$data['new_button'] .= '</div>';

		if(!$module_access->view){redirect('admin');}
		
		$data['title'] = 'System Modules';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'System Config';


		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/sys_modules_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function sysModuleGrid(){
		$info = $this->custom_lib->_require_login();
		$module_access = $this->custom_lib->module_access('sys_modules');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$filter = false;
		$recFound = $this->main->get_join_datatables('modules a', false, false, 'a.moduleDesc', 'a.moduleID', 'a.*', $filter, false);
		$toggle = '';
		$primary_action = '';
		$reset = '';
		foreach ($recFound->result() as $r) {

			if($r->statusID == 1){
		        $badge = '<span class="badge badge-success">Active</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-id="' . encode($r->moduleID) . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->statusID == 2){
		        $badge = '<span class="badge badge-warning">Inactive</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-id="' . encode($r->moduleID) . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }

		    
		    
			if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-sys-module" data-id="'.encode($r->moduleID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }


			$data[] = array(	
				$r->moduleID,
				$r->moduleDesc,
				$r->alias,
				$r->link,
				$r->linkName,
				time_stamp_display($r->createdTS),
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_sys_module(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$moduleDesc = clean_data($this->input->post('module-desc'));
			$alias = clean_data($this->input->post('alias'));
			$link = clean_data($this->input->post('link'));
			$linkName = clean_data($this->input->post('link-name'));
			

			if(!empty($moduleDesc) && !empty($alias)){

					

				$check_moduledesc = $this->main->check_data('modules', array('moduleDesc' => $moduleDesc));

				if($check_moduledesc == FALSE){
					$set = array(
								
						'moduleDesc' => strtoupper($moduleDesc),
						'alias' => $alias,
						'link' => $link,
						'linkName' => $linkName,
						'buID' => 1,
						'statusID' => 1
					);

					$result = $this->main->insert_data('modules', $set, TRUE);
							
					if($result){

						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/add_sys_module',
							'logDetail'	=>	'Successfully added Module:'.$moduleDesc
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
		                	'success'       =>    true,
		                	'successMsg'    =>    'System Module added successfully.'
		                ));
					}
				} else {
					echo json_encode(array(
	                	'success'       =>    false,
	                	'successMsg'    =>    'System Module already exist.'
	                ));
				}
			}else{
				echo json_encode(array(
                	'success'       =>    false,
                	'successMsg'    =>    'Make sure all fields are filled.'
                ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Please contact your administrator.'
            ));
		}
	}

	public function modal_sys_module(){
		$info = $this->custom_lib->_require_login();

		$id = decode($this->input->post('id'));

		$join = array(
			'stats b' => 'a.statusID = b.statusID and a.moduleID = "'.$id.'"'
		);
		$check_moduledesc = $this->main->check_join('modules a', $join, true);
		
		if($check_moduledesc['result'] == TRUE){
			

			$data['result'] = 1;
			$data['info'] = array(
				'moduleDesc' => $check_moduledesc['info']->moduleDesc,
				'moduleID' => $check_moduledesc['info']->moduleID,
				'alias' => $check_moduledesc['info']->alias,
				'link' => $check_moduledesc['info']->link,
				'linkName' => $check_moduledesc['info']->linkName
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
	}

	public function update_sys_module(){
		$info = $this->custom_lib->_require_login();
		/*var_dump($_POST);
		exit();*/

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$moduleDesc = clean_data($this->input->post('module-desc'));
			$alias = clean_data($this->input->post('alias'));
			$moduleID = clean_data(decode($this->input->post('id')));
			$link = clean_data($this->input->post('link'));
			$linkName = clean_data($this->input->post('link-name'));

			if(!empty($moduleDesc) && !empty($alias) && !empty($moduleID)){

					

				$check_moduledesc = $this->main->check_data('modules', array('moduleDesc' => $moduleDesc, 'moduleID !=' => $moduleID));

				if($check_moduledesc == FALSE){
					$set = array(
								
						'moduleDesc' => strtoupper($moduleDesc),
						'alias' => $alias,
						'link' => $link,
						'linkName' => $linkName,
						'buID' => 1,
						'statusID' => 1
					);

					$result = $this->main->update_data('modules', $set, array('moduleID' => $moduleID));
					if($result == TRUE){
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/update_sys_modules',
							'logDetail'	=>	'Successfully updated system module id:'.@$moduleID
						);
				        $this->main->user_logs($user_logs);
						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'System module successfully updated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				} else {
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. System module already exist.'
		            ));
				}
					
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Please make sure all required fields are filled.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function deactivate_sys_module(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$moduleID = decode(clean_data($this->input->post('id')));

			if(!empty($moduleID)){
				$check_moduledesc = $this->main->check_data('modules', array('moduleID' => $moduleID, 'statusID' => 2), true);
				if($check_moduledesc['result'] == FALSE){

					$set = array('statusID' => 2);
					$where = array('moduleID' => $moduleID);
					$result = $this->main->update_data('modules', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_sys_module',
							'logDetail'	=>	'Successfully deactivated Module ID:'.@$moduleID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'System Module successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. System Module already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. System Module ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_sys_module(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$moduleID = decode(clean_data($this->input->post('id')));

			if(!empty($moduleID)){
				$check_moduledesc = $this->main->check_data('modules', array('moduleID' => $moduleID, 'statusID' => 1), true);
				if($check_moduledesc['result'] == FALSE){

					$set = array('statusID' => 1);
					$where = array('moduleID' => $moduleID);
					$result = $this->main->update_data('modules', $set, $where);


					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_sys_module',
							'logDetail'	=>	'Successfully activated Module ID:'.@$moduleID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'System Module successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. System Module already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. System Module ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	/* END OF SYS MODULES */


	/*  
	module: System Key Controller
	desc: CRUD of CG Personnel
	date created: 2021-04-27
	created by: Aljune
	Change Management #1
		Date: 2021-04-27
		Description: Continuation of CRUD (Add, Edit, Deactivation, & Activation)
		Modified By: Aljune
	*/


	public function key(){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;
	    $keyID = decode($info['current_keyID']);

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('system_key');
		$data['new_button'] = '<div class="row col-lg-12">';

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		if($module_access->add){
			
			$data['new_button'] .= '
			
				<button type="button" class="add-key '.$btn_class.'" ><span class="fas fa-plus"></span></button>
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		}
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
			
		}

		if($module_access->canc){
			$data['new_button'] .= '<button type="button" class="cancel-tools '.$btn_class.'"  data-toggle="modal" data-target="#modal-clear-trans"><span class="fa fa-broom"></span></button>';
			
		}
		$data['new_button'] .= '</div>';

		
		if(!$module_access->view){redirect('admin');}
		$bc_access = $this->custom_lib->_get_access( array('keyID' => $keyID, 'statusID' => 1), 'bcID' );
		
		$bc_filter = array('statusID' => 1);
		$bc_access = $this->custom_lib->_get_data_access( array('userID' => decode($info['userID']), 'statusID' => 1));
		$where_in_field = FALSE;
		$where_in = FALSE;
		if(!empty($bc_access)){
			$where_in_field = 'bcID';
			$where_in = $bc_access;
		}
		$data['bc'] = $this->main->get_data('businesscenter', $bc_filter, false, FALSE, false, false, false, $where_in_field, $where_in);

		$data['uType'] = $this->main->get_data('usertype', array('statusID' => 1, 'userTypeID !=' => 0));

		$data['title'] = 'System Key';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'System Config';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);

		$data['content'] = $this->load->view('admin/key_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function keyGrid(){
		$info = $this->custom_lib->_require_login();
		$keyID = decode($info['current_keyID']);
		$bc_access = $this->custom_lib->_get_access( array('keyID' => $keyID, 'statusID' => 1), 'bcID' );
		$module_access = $this->custom_lib->module_access('system_key');
		

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array(
			'stats c' => 'a.statusID = c.statusID',
			'businesscenter d' => 'a.bcID = d.bcID'
		);
		$recFound = $this->main->get_join_datatables('key a', $join, false, 'a.keyID DESC', false, '*, a.statusID as keyStatusID', false);
		$toggle = '';
		$primary_action = '';
		foreach ($recFound->result() as $r) {

			if($r->keyStatusID == 1){
		        $badge = '<span class="badge badge-success">'.$r->statDesc.'</span>';
		        if($module_access->act){
		        	$toggle = '<a href="" class="toggle-active text-success" data-key-id="' . encode($r->keyID) . '" data-id="' . encode($r->keyID) . '"><span class="fas fa-toggle-on fa-lg"></a></span>';
		        }
		    }elseif($r->keyStatusID == 2){
		        $badge = '<span class="badge badge-warning">'.$r->statDesc.'</span>';
		        if($module_access->act){
		        	$toggle = '<a href="#" class="toggle-inactive text-warning" data-key-id="' . encode($r->keyID) . '" data-id="' . encode($r->keyID) . '"><span class="fas fa-toggle-off fa-lg"></span></a>';
		        }
		    }
		    if($module_access->edit){
		    	$primary_action = '<a href="" class="edit-key" data-id="'.encode($r->keyID).'"><span class="fas fa-pencil-alt fa-md"></span></a>';
		    }

			$data[] = array(	
				$r->keyID,
				$r->keyCode,
				$r->keyCode2,
				$r->bcName,
				$badge,
				$primary_action.'&nbsp;'.$toggle
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	public function add_key(){
		$info = $this->custom_lib->_require_login();

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$keyCode = clean_data($this->input->post('keyCode'));
			$keyCode2 = clean_data($this->input->post('keyCode2'));
			$bcID = decode(clean_data($this->input->post('bcID')));
			$userIDs = clean_data($this->input->post('userID'));

			$this->form_validation->set_rules('keyCode', 'Key Code', 'trim|required|min_length[4]|max_length[8]');
			$this->form_validation->set_rules('keyCode2', 'Suffix Code', 'trim|required|min_length[1]|max_length[1]');
			if ($this->form_validation->run() == false) {
                echo json_encode(array(
					'success'       =>    false,
					'successMsg' => validation_errors()
                ));
                exit();
            }
			if(!empty($keyCode) && !empty($bcID) ){

				$sql = "SELECT `keyID`
				FROM `key`
				WHERE `keyCode` = '".$keyCode."'
				AND `bcID` = ".$bcID."
				OR ( CONCAT(keyCode, keyCode2) = '".$keyCode.$keyCode2."')";

				$check_key = $this->main->get_query($sql, TRUE);

				
				if(empty($check_key)){
					$set = array(
						
						'keyCode' => trim(strtoupper($keyCode)),
						'keyCode2' => trim(strtoupper($keyCode2)),
						'buID' => 1,
						'coID' => 1,
						'statusID' => 1,
						'bcID'	=>	$bcID
					);

					$result = $this->main->insert_data('key', $set, TRUE);


					if($result['id']){
						if(!empty($userIDs)){
							foreach($userIDs as $r){
								$userID = decode($r);
								//$get_user = $this->main->get_data('users', array('userTypeID <=' => 2, 'userTypeID >' => 0));
								$check_user_key = $this->main->check_data('userkey', array('keyID' => $result['id'], 'userID' => $userID), true);
								if($check_user_key['result'] == FALSE){
									$get_user = $this->main->get_data('users', array('userID' => $userID));
									if(!empty($get_user)){
										foreach ($get_user as $r) {
											$set_key = array(
												'userID' => $r->userID,
												'keyID' => $result['id'],
												'createdTS' => date_now(),
												'statusID' => $r->statusID
											);
			
											$result_userkey = $this->main->insert_data('userkey', $set_key);
											$userTypeID = $r->userTypeID;
											$this->_insert_user_module_with_key($r->userID, $result['id'], $userTypeID);
										}
									}
								}
							}
						}

						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/add_key',
							'logDetail'	=>	'Successfully added System Key ID:'.@$result['id']
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
		                	'success'       =>    true,
		                	'successMsg'    =>    'System Key added successfully.'
		                ));
					}
				} else {
					echo json_encode(array(
	                	'success'       =>    false,
	                	'successMsg'    =>    'System key code already exist. See System Key ID : '.$check_key->keyID
	                ));
				}
			}else{
				echo json_encode(array(
                	'success'       =>    false,
                	'successMsg'    =>    'Make sure all fields are filled.'
                ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Please contact your administrator.'
            ));
		}	
	}

	public function _insert_user_module_with_key($userID=null, $keyID=null, $userTypeID=null){
		//loop preset detail
		$join = array(
			'presetdtl b' => 'a.presetHdrID = b.presetHdrID and a.statusID != 0',
			'modules c' => 'b.moduleID = c.moduleID and c.statusID = 1'
		);
		$recFound = $this->main->get_join_datatables('presethdr a', $join, false, 'c.moduleDesc asc', false, '*','a.userTypeID='.$userTypeID ,false);

		foreach ($recFound->result() as $r) {

			$set_user_module = array(
				'userID' 	=> $userID,
				'keyID'		=> $keyID,
				'userTypeID'=> $userTypeID,
				'statusID' 	=> 1,
				'createdTS' => date_now(),
				'moduleID' 	=> $r->moduleID,
				'view' 		=> $r->view,
				'add' 		=> $r->add,
				'edit' 		=> $r->edit,
				'act' 		=> $r->act,
				'post' 		=> $r->post,
				'canc' 		=> $r->canc,
				'prnt' 		=> $r->prnt,
				'ulod' 		=> $r->ulod,
				'dlod' 		=> $r->dlod,
				'clear' 	=> $r->clear,
				'appr' 		=> $r->appr,
			);
	
			$result = $this->main->insert_data('usermodules', $set_user_module, true);
			if($result == FALSE){
				$result_usermodule=FALSE;
			}
		}

	}

	public function modal_key(){
		$info = $this->custom_lib->_require_login();

		$id = decode($this->input->post('id'));

		$join = array(
			'stats b' => 'a.statusID = b.statusID and a.keyID = "'.$id.'"'
		);
		$check_key = $this->main->check_join('key a', $join, true);
		
		if($check_key['result'] == TRUE){
			$bcID		= $check_key['info']->bcID;
			$keyID		= $check_key['info']->keyID;

			$bc_filter = array('statusID' => 1);
			$get_bc = $this->main->get_data('businesscenter', $bc_filter);
			$data_bc	= '<option value=""> Select...</option>';
			
			foreach($get_bc as $row){
				$selected = '';
				if($row->bcID == $bcID){
					$selected = 'selected';
				}
				$data_bc .= '<option '.$selected.' value="' . encode($row->bcID) . '">' . $row->bcName . '</option>';
			}

			$data['result'] = 1;
			$data['info'] = array(
				'keyCode' => $check_key['info']->keyCode,
				'keyCode2' => $check_key['info']->keyCode2,
				'bcID' => $data_bc
			);
		}else{
			$data['result'] = 0;
		}

		echo json_encode($data);
	}

	public function update_key(){
		$info = $this->custom_lib->_require_login();
		

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$keyID = decode($this->input->post('id'));
			$keyCode = clean_data($this->input->post('keyCode'));
			$keyCode2 = clean_data($this->input->post('keyCode2'));
			$bcID = decode(clean_data($this->input->post('bcID')));

			$userIDs = clean_data($this->input->post('userID'));

			$this->form_validation->set_rules('keyCode', 'Key Code', 'trim|required|min_length[4]|max_length[8]');
			$this->form_validation->set_rules('keyCode2', 'Suffix Code', 'trim|required|min_length[1]|max_length[1]');
			if ($this->form_validation->run() == false) {
                echo json_encode(array(
					'success'       =>    false,
					'successMsg' => validation_errors()
                ));
                exit();
            }

			if(!empty($keyID) && !empty($keyCode) && !empty($bcID) ){
				
				$sql = "SELECT `keyID`
				FROM `key`
				WHERE `keyCode` = '".$keyCode."'
				AND `keyID` != ".$keyID."
				AND `bcID` = ".$bcID."
				OR ( CONCAT(keyCode, keyCode2) = '".$keyCode.$keyCode2."' AND `keyID` != ".$keyID." )";

				$check_key = $this->main->get_query($sql, TRUE);
				
				if(empty($check_key)){

					$set = array(
						
						'keyCode' => trim(strtoupper($keyCode)),
						'keyCode2' => trim(strtoupper($keyCode2)),
						'bcID'	=>	$bcID
					);

					$result = $this->main->update_data('key', $set, array('keyID' => $keyID));
					if($result == TRUE){
						if(!empty($userIDs)){
							foreach($userIDs as $r){
								$userID = decode($r);
								//$get_user = $this->main->get_data('users', array('userTypeID <=' => 2, 'userTypeID >' => 0));
								$check_user_key = $this->main->check_data('userkey', array('keyID' => $keyID, 'userID' => $userID), true);
								if($check_user_key['result'] == FALSE){
									$get_user = $this->main->get_data('users', array('userID' => $userID));
									if(!empty($get_user)){
										foreach ($get_user as $r) {
											$set_key = array(
												'userID' => $r->userID,
												'keyID' => $keyID,
												'createdTS' => date_now(),
												'statusID' => $r->statusID
											);
			
											$result_userkey = $this->main->insert_data('userkey', $set_key);
											$userTypeID = $r->userTypeID;
											$this->_insert_user_module_with_key($r->userID, $keyID, $userTypeID);
										}
									}
								}
							}
						}
						$user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/update_key',
							'logDetail'	=>	'Successfully updated System Key ID:'.@$keyID
						);
				        $this->main->user_logs($user_logs);
						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'System Key successfully updated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				} else {
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. System Key code already exist. See System Key ID : '.$check_key->keyID
		            ));
				}
					
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. Please make sure all required fields are filled.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function deactivate_key(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$keyID = decode(clean_data($this->input->post('id')));

			if(!empty($keyID)){
				$check_key = $this->main->check_data('key', array('keyID' => $keyID, 'statusID' => 2), true);
				if($check_key['result'] == FALSE){

					$set = array('statusID' => 2);
					$where = array('keyID' => $keyID);
					$result = $this->main->update_data('key', $set, $where);


					$set = array('statusID' => 2);
					$where = array('keyID' => $keyID);
					$result_userkey = $this->main->update_data('userkey', $set, $where);

					

					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/deactivate_key',
							'logDetail'	=>	'Successfully deactivated System Key ID:'.@$keyID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'System Key successfully deactivated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. System Key already inactive.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. System Key ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	public function activate_key(){
		$info = $this->custom_lib->_require_login();


		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$keyID = decode(clean_data($this->input->post('id')));
			
			if(!empty($keyID)){
				$check_key = $this->main->check_data('key', array('keyID' => $keyID, 'statusID' => 1), true);
				if($check_key['result'] == FALSE){

					$set = array('statusID' => 1);
					$where = array('keyID' => $keyID);
					$result = $this->main->update_data('key', $set, $where);

					$set = array('statusID' => 1);
					$where = array('keyID' => $keyID);
					$result_userkey = $this->main->update_data('userkey', $set, $where);

					if($result == TRUE){
			            $user_logs = array(
							'userID'	=>	decode($info['userID']),
							'userFullName' =>	$info['userFullName'],
							'logTS'	=>	date_now(),
							'page'	=>	'Admin/activate_key',
							'logDetail'	=>	'Successfully activated System Key ID:'.@$keyID
						);
				        $this->main->user_logs($user_logs);

						echo json_encode(array(
			            	'success'       =>    true,
			            	'successMsg'    =>    'System Key successfully activated.'
			            ));
					}else{
						echo json_encode(array(
			            	'success'       =>    false,
			            	'successMsg'    =>    'Opps. Please try again.'
			            ));
					}
				}else{
					echo json_encode(array(
		            	'success'       =>    false,
		            	'successMsg'    =>    'Opps. System Key already active.'
		            ));
				}
			}else{
				echo json_encode(array(
	            	'success'       =>    false,
	            	'successMsg'    =>    'Opps. System Key ID required.'
	            ));
			}
		}else{
			echo json_encode(array(
            	'success'       =>    false,
            	'successMsg'    =>    'Opps. Please contact system administrator.'
            ));
		}
	}

	// END OF SYSTEM KEY



	// LOGS

	public function logs(){
		

		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;
	    $keyID = decode($info['current_keyID']);

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('logs');

		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		$data['new_button'] = '';
		$data['new_button'] .= '
				<button type="button" class="refresh-dt '.$btn_class.'"><span class="fa fa-refresh"></span></button>';
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="print-dt '.$btn_class.'"><span class="fas fa-file-excel"></span></button>';
		}

		if(!$module_access->view){redirect('admin');}

		$data['title'] = 'Logs';
		$data['menu_title'] = 'Master data';
		$data['parent_title'] = 'System Config';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/logs_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function sysLogsGrid (){
      	$info = $this->custom_lib->_require_login();
          
		$select = '
				a.logID,
		        a.page,
		        a.logDetail,
		        CONCAT(userID,". ",userFullName) AS userFullName,
		        a.userID,
		        a.logTS';
		$table = 'userlogs a';
		$column_order = array('logID', 'page', 'logDetail', 'CONCAT(userID,". ",userFullName)', 'logTS');
		$column_search = array('logID', 'page', 'logDetail', 'CONCAT(userID,". ",userFullName)', 'logTS');
		$order = array('logID' =>  'desc');

		$recFound = $this->main->get_sys_logs($_POST, $table, $column_order, $column_search, $order, $select);

		$data = array();

		foreach($recFound['result']->result() as $r) {

		    $data[] = array(
		        $r->logID,
		        $r->page,
		        $r->logDetail,
		        $r->userFullName,
		        time_stamp_display($r->logTS)
		    );
		}

		$output = array(
		     "draw" => $_POST['draw'],
		     "recordsTotal" => $this->main->trails_countAll('userlogs'),
		     "recordsFiltered" => $this->main->trails_countFiltered($_POST, $table, $column_order, $column_search, $order, $select),
		     "data" => $data,
		     //"query" =>  $recFound['query']
		);
		echo json_encode($output);
		exit(); 
    }

	public function activity_logs(){
		$info = $this->custom_lib->_require_login();
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;

		
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;
	    $mobileID = decode($info['current_keyID']);

	    //echo substr('639959633018', -10);
	    

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('notifications');
		$data['new_button'] = '<div class="row col-lg-12">';
		
		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		$data['btn_class'] = $btn_class;
		
		$data['new_button'] .= '<button type="button" class="'.$btn_class.' refresh-dt"><span class="fa fa-refresh"></span></button>';
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="'.$btn_class.' dl-dt"><span class="fas fa-file-excel"></span></button>';
			
		}
		
		$data['new_button'] .= '</div>';
		
		if(!$module_access->view){redirect('admin');}
		
		

		$data['title'] = 'Activity Logs';
		$data['menu_title'] = '';
		$data['parent_title'] = 'Extras';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		$data['content'] = $this->load->view('admin/activity_logs_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

    public function activityGrid (){
      	$info = $this->custom_lib->_require_login();
          
		$select = '
				a.logID,
		        a.page,
		        a.logDetail,
		        CONCAT(userID,". ",userFullName) AS userFullName,
		        a.userID,
		        a.logTS';
		$table = 'userlogs a';
		$column_order = array('logDetail', 'logTS');
		$column_search = array('logDetail', 'logTS');
		$order = array('logID' =>  'desc');
		$filter = array('userID' => decode($info['userID']));

		$recFound = $this->main->get_sys_logs($_POST, $table, $column_order, $column_search, $order, $select, false, $filter);

		$data = array();

		foreach($recFound['result']->result() as $r) {

		    $data[] = array(
		        $r->logDetail,
		        time_stamp_display($r->logTS)
		    );
		}

		$output = array(
		     "draw" => $_POST['draw'],
		     "recordsTotal" => $this->main->trails_countAll('userlogs'),
		     "recordsFiltered" => $this->main->trails_countFiltered($_POST, $table, $column_order, $column_search, $order, $select),
		     "data" => $data,
		     //"query" =>  $recFound['query']
		);
		echo json_encode($output);
		exit(); 
    }

	// END OF LOGS

	public function my_profile (){

		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$btnColor = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('my_profile');
		if(!$module_access->view){redirect('admin');}
		
		
		if($module_access->edit){
			$data['save_button'] = '<button type="submit" class="btn btn-'.$btnColor.' btn-md btn-round">Save</button>';
		} else {
			$data['save_button'] = '<button type="submit" disabled class="btn btn-'.$btnColor.' btn-md btn-round">Save</button>';
		}

		
		
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;

		$data['title'] = 'Profile';
		$data['menu_title'] = '';
		$data['parent_title'] = 'Extras';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		
		$data['content'] = $this->load->view('admin/my_profile_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}



	// NOTIFICATION
	public function notifications($param1 = false, $param2 = false, $param3 = false, $param4 = false){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;

		$data['param1'] = $param1;
		$data['param2'] = $param2;
		$data['param3'] = $param3;
		$data['param4'] = $param4;
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;
	    $mobileID = decode($info['current_keyID']);

	    //echo substr('639959633018', -10);
	    

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('notifications');
		$data['new_button'] = '<div class="row col-lg-12">';
		
		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		$data['btn_class'] = $btn_class;
		
		$data['new_button'] .= '<button type="button" class="'.$btn_class.' refresh-dt"><span class="fa fa-refresh"></span></button>';
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="'.$btn_class.' dl-dt"><span class="fas fa-file-excel"></span></button>';
			
		}
		
		if($module_access->clear){
			$data['new_button'] .= '<button type="button" class="'.$btn_class.' clear-dt-history" data-toggle="tooltip" data-placement="bottom" title="Clear Notif"><span class="fa fa-trash-o"></span></button>';
		}
		$data['new_button'] .= '</div>';
		
		if(!$module_access->view){redirect('admin');}
		
		

		$data['title'] = 'Notificattions';
		$data['menu_title'] = '';
		$data['parent_title'] = 'Extras';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		$data['content'] = $this->load->view('admin/notification_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function notifGrid($refID = null, $notifTypeID = null, $notifID = null, $statusID = null){
		$info = $this->custom_lib->_require_login();
		$keyID = decode($info['current_keyID']);
		$bc_access = $this->custom_lib->_get_access( array('keyID' => $keyID, 'statusID' => 1), 'bcID' );
		$module_access = $this->custom_lib->module_access('notifications');
		if(decode($info['userTypeID']) > 1){
			$bc_filter = array('b.bcID' => $bc_access);
		} else {
			$bc_filter = false;
		}

		$refID = decode($refID);
		if($refID && $notifTypeID){

			$filter = array('a.refID' => $refID, 'a.notifTypeID' => $notifTypeID);
			$key_field = false;
			$key_arr = false;
		}elseif($notifTypeID && $notifID){

			$filter = array('a.notifID' => $notifID, 'a.notifTypeID' => $notifTypeID);
			$key_field = false;
			$key_arr = false;
		} else { //SHOW ALL ON CURRENT KEY
			//SLOC ACCESS
			//$filter = false;
			/* $key_access = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
			if(count($key_access)){
				$key_field = 'a.keyID';
				$key_arr = array();
				foreach ($key_access as $r) {
					$key_arr[] = $r->keyID;
				}
			} */
			$filter = array(
				'a.keyID' => decode($info['current_keyID'])
			);
			$key_arr = false;
			$key_field = false;
		}

		if(!$statusID){$statusID = 15;}

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();
		$join = array(
					'users c' =>	'a.createdBy = c.userID',
					'usernotif d' =>	'a.notifID = d.notifID and d.userID ='.decode($info['userID']).' and d.statusID != '.$statusID,
				);
		$order_by = 'a.tsCreated DESC';
		$recFound = $this->main->get_join_datatables('notification a', $join, false, $order_by, false, '*, a.createdBy', $filter, $key_field, $key_arr);
		$toggle = '';
		$primary_action = '';

		foreach ($recFound->result() as $r) {

			if($r->createdBy == 0){
            	$creator = $r->mobileFullName;
            } else {
            	$creator = $r->userFirstName.' '.$r->userLastName;
            }

			$data[] = array(	
				$r->notifID,
				'<span class="notif-item" data-name="'.$r->notifName.'" data-id="'.$r->notifID.'" data-typeid="'.$r->notifTypeID.'" data-ref-id="'.encode($r->refID).'" data-transtype="'.encode(1).'">'.$r->notif.'</span>',
				time_stamp_display($r->tsCreated),
				
			);
		}

		$output = array(
			 "draw" => $draw,
			 "recordsTotal" => $recFound->num_rows(),
			 "recordsFiltered" => $recFound->num_rows(),
			 "data" => $data
		);
		echo json_encode($output);
		exit();
	}

	// END OF NOTIFICATION


	// USER FEEDBACK
	public function user_feedback(){
		$info = $this->custom_lib->_require_login();
		$data['js_file'] = '';
		$data['profile'] = $this->custom_lib->_get_profile();
		
		$data['menuColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->menuColor;
	    $data['tableColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->tableColor;
	    $data['thColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->thColor;
	    $data['btnColor'] = get_user_theme(array('a.userID' => decode($info['userID'])), true)->btnColor;

		
	    
	    $data['notif_counter'] = $this->custom_lib->_get_notifications()->counter;
	    $mobileID = decode($info['current_keyID']);

	    //echo substr('639959633018', -10);
	    

		$data['available_access'] = $this->custom_lib->_get_available_access( array('userID' => decode($info['userID'])) );
		$module_access = $this->custom_lib->module_access('user_feedback');
		$data['new_button'] = '<div class="row col-lg-12">';
		
		$btn_class = 'btn btn-icon btn-sm btn-round btn-'.$data['btnColor'].' mr-2 mb-2';
		$data['btn_class'] = $btn_class;
		
		$data['new_button'] .= '<button type="button" class="'.$btn_class.' refresh-dt"><span class="fa fa-refresh"></span></button>';
		if($module_access->dlod){
			$data['new_button'] .= '<button type="button" class="'.$btn_class.' dl-dt"><span class="fas fa-file-excel"></span></button>';
			
		}
		
		if($module_access->clear){
			$data['new_button'] .= '<button type="button" class="'.$btn_class.' clear-dt-history" data-toggle="tooltip" data-placement="bottom" title="Clear Notif"><span class="fa fa-trash-o"></span></button>';
		}
		$data['new_button'] .= '</div>';
		
		if(!$module_access->view){redirect('admin');}
		
		

		$data['title'] = 'User Feedback';
		$data['menu_title'] = '';
		$data['parent_title'] = 'Extras';

		$data['userID'] = decode($info['userID']);
		$data['breadcrumbs'] = $this->load->view('admin/breadcrumbs', $data , TRUE);
		$data['content'] = $this->load->view('admin/user_feedback_content', $data , TRUE);
		$this->load->view('admin/templates', $data);
	}

	public function userFeedbackGrid(){
		$info = $this->custom_lib->_require_login();

		
          
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$data = array();

		$module_access = $this->custom_lib->module_access('user_feedback');

		$filter = array(
			'a.userID' => decode($info['userID'])
		);
		if($module_access->appr){
			$filter = false;
		}
		$join = array(
					'users c' =>	'a.userID = c.userID'
				);
		$order_by = 'a.createdTS DESC';
		$recFound = $this->main->get_join_datatables('userrating a', $join, false, $order_by, false, '*, a.createdTS', $filter);
		$toggle = '';
		$primary_action = '';

		foreach ($recFound->result() as $r) {

			if($r->rating == 'GOOD'){
            	$userFeedback = 'GOES WELL WITH '.$r->userFeedback;
				$icon = '<i class="fas fa-thumbs-up text-primary mr-2"></i><font class="text-success">'.$r->rating.'</font>';
            } else {
				$icon = '<i class="fas fa-thumbs-down text-danger mr-2"></i><font class="text-danger">'.$r->rating.'</font>';
            	$userFeedback = 'NEEDS IMPROVEMENT IN '.$r->userFeedback;
            }

			$data[] = array(	
				$icon,
				$userFeedback,
				$r->userComment,
				$r->userFirstName.' '.$r->userLastName,
				time_stamp_display($r->createdTS)
				
			);
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $recFound->num_rows(),
			"recordsFiltered" => $recFound->num_rows(),
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}

	// END OF USER FEEDBACK







	/* USER THEME CONTROLLER */

	public function put_user_theme_background(){
		$info = $this->custom_lib->_require_login();
		$userID = decode($info['userID']);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$backgroundColor 		= clean_data($this->input->post('backgroundColor'));
			if(!empty($backgroundColor)){
				$check_user_theme = $this->main->check_data('usertheme', array('userID' =>  $userID), TRUE, FALSE, FALSE);
				if($check_user_theme['result']){
					$update_data = array(
						'backgroundColor' => $backgroundColor
					);
					$filter = array(
						'userThemeID' => $check_user_theme['info']->userThemeID
					);
					$result = $this->main->update_data('usertheme', $update_data, $filter);
					$id = $check_user_theme['info']->userThemeID;
					$logs = 'Successfully updated userthemeID :'.$id;
				} else {
					$set = array(
						'backgroundColor' => $backgroundColor,
						'userID' => $userID,
						'sideBarColor' => 'dark2',
						'topBarColor' => 'dark',
						'logoHeaderColor' => 'dark2',
						'statusID' => 1
					);
					$result = $this->main->insert_data('usertheme', $set, TRUE);
					$result = $result['result'];
					$id = $result['id'];
					$logs = 'Successfully added userthemeID :'.$id;
				}

				if($result){
					$user_logs = array(
						'userID'	=>	decode($info['userID']),
						'userFullName' =>	$info['userFullName'],
						'logTS'	=>	date_now(),
						'page'	=>	'Admin/put_user_theme_background',
						'logDetail'	=>	'Successfully updated userthemeID:'.@$id
					);
					//$this->main->user_logs($user_logs);
					echo json_encode(array(
						'success'       =>    true,
						'successMsg'    =>    'Theme updated.'
					));
				}
			}
		}
	}

	public function put_user_theme_sidebar(){
		$info = $this->custom_lib->_require_login();
		$userID = decode($info['userID']);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$sideBarColor 		= clean_data($this->input->post('sideBarColor'));
			if(!empty($sideBarColor)){
				$check_user_theme = $this->main->check_data('usertheme', array('userID' =>  $userID), TRUE, FALSE, FALSE);
				if($check_user_theme['result']){
					$update_data = array(
						'sideBarColor' => $sideBarColor
					);
					$filter = array(
						'userThemeID' => $check_user_theme['info']->userThemeID
					);
					$result = $this->main->update_data('usertheme', $update_data, $filter);
					$id = $check_user_theme['info']->userThemeID;
					$logs = 'Successfully updated userthemeID :'.$id;
				} else {
					$set = array(
						'backgroundColor' => 'dark',
						'userID' => $userID,
						'sideBarColor' => $sideBarColor,
						'topBarColor' => 'dark',
						'logoHeaderColor' => 'dark2',
						'statusID' => 1
					);
					$result = $this->main->insert_data('usertheme', $set, TRUE);
					$result = $result['result'];
					$id = $result['id'];
					$logs = 'Successfully added userthemeID :'.$id;
				}

				if($result){
					$user_logs = array(
						'userID'	=>	decode($info['userID']),
						'userFullName' =>	$info['userFullName'],
						'logTS'	=>	date_now(),
						'page'	=>	'Admin/put_user_theme_background',
						'logDetail'	=>	$logs
					);
					//$this->main->user_logs($user_logs);
					echo json_encode(array(
						'success'       =>    true,
						'successMsg'    =>    'Theme updated.'
					));
				}
			}
		}
	}

	public function put_user_theme_topbar(){
		$info = $this->custom_lib->_require_login();
		$userID = decode($info['userID']);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$topBarColor 		= clean_data($this->input->post('topBarColor'));
			if(!empty($topBarColor)){
				$check_user_theme = $this->main->check_data('usertheme', array('userID' =>  $userID), TRUE, FALSE, FALSE);
				if($check_user_theme['result']){
					$update_data = array(
						'topBarColor' => $topBarColor
					);
					$filter = array(
						'userThemeID' => $check_user_theme['info']->userThemeID
					);
					$result = $this->main->update_data('usertheme', $update_data, $filter);
					$id = $check_user_theme['info']->userThemeID;
					$logs = 'Successfully updated userthemeID :'.$id;
				} else {
					$set = array(
						'backgroundColor' => 'dark',
						'userID' => $userID,
						'sideBarColor' => 'dark2',
						'topBarColor' => $topBarColor,
						'logoHeaderColor' => 'dark2',
						'statusID' => 1
					);
					$result = $this->main->insert_data('usertheme', $set, TRUE);
					$result = $result['result'];
					$id = $result['id'];
					$logs = 'Successfully added userthemeID :'.$id;
				}

				if($result){
					$user_logs = array(
						'userID'	=>	decode($info['userID']),
						'userFullName' =>	$info['userFullName'],
						'logTS'	=>	date_now(),
						'page'	=>	'Admin/put_user_theme_background',
						'logDetail'	=>	$logs
					);
					//$this->main->user_logs($user_logs);
					echo json_encode(array(
						'success'       =>    true,
						'successMsg'    =>    'Theme updated.'
					));
				}
			}
		}
	}

	public function put_user_theme_logo_header(){
		$info = $this->custom_lib->_require_login();
		$userID = decode($info['userID']);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$logoHeaderColor 		= clean_data($this->input->post('logoHeaderColor'));
			if(!empty($logoHeaderColor)){
				$check_user_theme = $this->main->check_data('usertheme', array('userID' =>  $userID), TRUE, FALSE, FALSE);
				if($check_user_theme['result']){
					$update_data = array(
						'logoHeaderColor' => $logoHeaderColor
					);
					$filter = array(
						'userThemeID' => $check_user_theme['info']->userThemeID
					);
					$result = $this->main->update_data('usertheme', $update_data, $filter);
					$id = $check_user_theme['info']->userThemeID;
					$logs = 'Successfully updated userthemeID :'.$id;
				} else {
					$set = array(
						'backgroundColor' => 'dark',
						'userID' => $userID,
						'sideBarColor' => 'dark2',
						'topBarColor' => 'dark',
						'logoHeaderColor' => $logoHeaderColor,
						'statusID' => 1
					);
					$result = $this->main->insert_data('usertheme', $set, TRUE);
					$result = $result['result'];
					$id = $result['id'];
					$logs = 'Successfully added userthemeID :'.$id;
				}

				if($result){
					$user_logs = array(
						'userID'	=>	decode($info['userID']),
						'userFullName' =>	$info['userFullName'],
						'logTS'	=>	date_now(),
						'page'	=>	'Admin/put_user_theme_background',
						'logDetail'	=>	$logs
					);
					//$this->main->user_logs($user_logs);
					echo json_encode(array(
						'success'       =>    true,
						'successMsg'    =>    'Theme updated.'
					));
				}
			}
		}
	}

	public function put_user_theme_btn(){
		$info = $this->custom_lib->_require_login();
		$userID = decode($info['userID']);

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$btnColor 		= clean_data($this->input->post('btnColor'));
			if(!empty($btnColor)){
				$check_user_theme = $this->main->check_data('usertheme', array('userID' =>  $userID), TRUE, FALSE, FALSE);
				if($check_user_theme['result']){
					if($btnColor == 'green'){
						$btnColor = 'success';
					} elseif ($btnColor == 'light-blue'){
						$btnColor = 'info';
					} elseif ($btnColor == 'blue'){
						$btnColor = 'primary';
					} elseif ($btnColor == 'orange'){
						$btnColor = 'warning';
					} elseif ($btnColor == 'red'){
						$btnColor = 'danger';
					} elseif ($btnColor == 'purple'){
						$btnColor = 'secondary';
					}
					$update_data = array(
						'btnColor' => $btnColor,
						'thColor'  => $btnColor,
						'tableColor' => $btnColor,
						'menuColor' => $btnColor
					);
					$filter = array(
						'userThemeID' => $check_user_theme['info']->userThemeID
					);
					$result = $this->main->update_data('usertheme', $update_data, $filter);
					
					$id = $check_user_theme['info']->userThemeID;
					$logs = 'Successfully updated userthemeID :'.$id;
				} else {
					$set = array(
						'backgroundColor' => 'dark',
						'userID' => $userID,
						'sideBarColor' => 'dark2',
						'topBarColor' => 'dark',
						'logoHeaderColor' => 'dark2',
						'btnColor' => $btnColor,
						'statusID' => 1
					);
					$result = $this->main->insert_data('usertheme', $set, TRUE);
					$result = $result['result'];
					$id = $result['id'];
					$logs = 'Successfully added userthemeID :'.$id;
				}

				if($result){
					$user_logs = array(
						'userID'	=>	decode($info['userID']),
						'userFullName' =>	$info['userFullName'],
						'logTS'	=>	date_now(),
						'page'	=>	'Admin/put_user_theme_background',
						'logDetail'	=>	$logs
					);
					//$this->main->user_logs($user_logs);
					echo json_encode(array(
						'success'       =>    true,
						'successMsg'    =>    'Theme updated.'
					));
				}
			}
		}
	}

	/* END OF USER THEME CONTROLLER */


	public function clear_employee(){
		$info = $this->custom_lib->_require_login();

		$transTypeID = $this->input->post('transTypeID');
		

		$result = '';
		
		$sql = 'SET FOREIGN_KEY_CHECKS=0;';
		$this->main->get_query($sql, false, false, true);

		$sql = '
		DELETE a, b, c, d
		from employee a
		INNER JOIN employeeapproval b on a.empID = b.empID
		LEFT JOIN notification c on a.empID = c.refID and notifTypeID IN (1, 2) AND c.keyID = '.decode($info['current_keyID']).'
		LEFT JOIN usernotif d on c.notifID = d.notifID
		and a.keyID = '.decode($info['current_keyID']);
		$result = $this->main->get_query($sql, false, false, true);


		if($result){
			$output = array(
				'success' => true,
				'successMsg' => 'Successfully cleared.'
			);
		} else {
			$output = array(
				'success' => false,
				'successMsg' => 'Opps, error in clearing.'
			);
		}		

		echo json_encode($output);
	}


}
