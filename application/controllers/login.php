<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Auth");
    }

    public function index()
    {
        $auth = new Auth;
        $data['token'] = $auth->generateToken();

        $this->load->view('login', $data);

        if (get_session('CURRICULUM_logged')) { 
            $login_session = get_session('CURRICULUM_logged');
            redirect('gen_info', 'refresh');
        }
    }

    public function verifyLogin()
    {
        $auth = new Auth;

        $username = $this->security->xss_clean(escape_str($this->input->post('username')));
        $password = $this->security->xss_clean(escape_str($this->input->post('password')));
        $token = $this->security->xss_clean(escape_str($this->input->post('token')));

        // VALIDATE TOKEN
        if ($auth->validateToken($token)) {
            //check user
            if ($auth->checkUser($username, $password) == false) {
                $sess_login = array(
                    "result" => false
                );
                set_session('CURRICULUM_login_result', $sess_login);
                redirect('login', 'refresh');
            }
        } else {
            show_404();
        }
    }

    public function logout()
    {
        $auth = new Auth;
        $auth->logout();
    }
}
