<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("User");
	}

	public function index()
	{
		$data['userInfo'] = $this->getUserInformation();

		$this->load->view('includes/header');
		$this->load->view('includes/menu');
		$this->load->view('settings/css');
		$this->load->view('settings/index', $data);
		$this->load->view('includes/footer');
		$this->load->view('includes/js');
		$this->load->view('settings/js');

	}

	public function getUserInformation(){
		$user = new User;
		$userInfo = $user->search(array("user_id"=>$this->userInfo->user_id));
		return $userInfo;
	}

	public function saveChangesPersonalInfo(){
		$user = new User;

		$data = $this->input->post();

		$dataToSave = array();
		foreach ($data as $key => $value) {
			if(trim($value," ") != ""){
				$dataToSave[$key] = $value;
			}
		}

		$result = $user->modify($this->userInfo->user_id, $dataToSave);
		redirect(base_url('settings'));
	}

	public function changePassword(){
		$user = new User;
		$data = $this->input->post();

		if($data['old_password'] == doDecrypt($this->userInfo->password)){

			if($data['new_password'] == $data['retype_password']){
				// DO UPDATE
				$result = $user->modify($this->userInfo->user_id, array("password"=>doEncrypt($data['new_password'])));
				redirect(base_url('settings'));
			}
			else{
				// NEW PASSWORD AND CONFIRM PASSWORD DID NOT MATCH
				set_session('sessChangePass', "New password and confirm password did not match.");
				redirect(base_url('settings'));
			}
		}
		else{
			// INVALID CURRENT PASSWORD
			set_session('sessChangePass', "Invalid current password.");
			redirect(base_url('settings'));
		}
	}

	public function changeUserImage(){

		$user = new User;

		$config['upload_path']          = './assets/img/profile_image/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('user_image'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode(["result"=>$error]);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $dbresult = $user->modify($this->userInfo->user_id, array("user_image"=>$data['upload_data']['file_name']));

            echo json_encode(array("result"=>$dbresult));
        }
	}

}
