<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Auth extends MY_Model{
		private static $token;
		public function __construct(){
			parent::__construct();
			$this->load->model("User");
		}
		public function checkUser($username="",$password=""){
			
			$user = new User;
			// CHECK FROM DATABASE
			$searchData = array(
						 "username"=>$username,
						 "user_status"=>"active"
						 );

			$search = $user->search($searchData);
			if(!empty($search)){
				//GET USER DATA
				foreach ($search as $key => $value) {
					if($password == doDecrypt($value->password)){
						$sess_array = array(
							         'id' => $value->user_id,
							         'name' => $value->fullName('f l')
							       	);
						// SET SESSION
						$this->setUserSession($sess_array);
						// REDIRECT 
						$this->redirectUser();
					}
					else{
						return false;
					}
				}
			}
			else{
				return false;
			}
		}

		private function setUserSession($sess_array){
       		set_session('CURRICULUM_logged', $sess_array);
		}

		private function redirectUser(){
			if (get_session('CURRICULUM_logged')) {
				redirect('gen_info' , 'refresh');
	      	}
		}
		
		public function whoseLogged(){
			if (get_session('CURRICULUM_logged')) {
				$user = new User;
				$login_session = get_session('CURRICULUM_logged');
				return $user->get_user(array("user_id"=>$login_session['id']));
			}
			return false;	
		}

		public function logout(){
			delete_session("CURRICULUM_logged");
			delete_session("session_token");
			destroy_session();
		   	redirect("login", "refresh");
		}

		// TOKEN AUTHENTICATION
		public function generateToken(){
		    set_session("session_token", $this->security->get_csrf_hash());
		   	return $this->security->get_csrf_hash();
		}

		public function validateToken($token=""){
			// Is this a post request?
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
			    // Is the token field set and valid?
			    $posted_token = $token;
		
			    if (empty($posted_token) || ($posted_token != get_session("session_token")))
			    {
			      	return false;
			    }
			    else{
			    	return true;
			    }
			}
			else{
			  	return false;
			}
		}
	}
?>