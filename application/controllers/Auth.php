<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('User_model');
		$this->load->library('session');
		$this->load->helper('access'); // tanpa _helper


		$this->roles = $this->config->item('roles');
	}
	public function index()
	{
		if (in_array($this->session->userdata('role'), $this->roles)) {
        redirect('dashboard');
    }
		$this->load->view('auth/login');
	}

	public function login() {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->User_model->get_user($username, $password);
		$menu_access = generate_menu_access($user->nm_unit_level);

		$user_array = (array) $user;
		unset($user_array['password']); // opsional
    if ($user) {
        $this->session->set_userdata([
					'logged_in' => true,
					'role' => $user->nm_unit_level,
					'menu_access' => $menu_access,
					'current_user' => $user_array
        ]);

        // redirect jika role sesuai
        if (in_array($user->nm_unit_level, $this->roles)) {
					redirect('dashboard');
        } else {
					$this->session->set_flashdata('error', 'Role tidak sesuai');
					redirect('auth');
        }
    } else {
			$this->session->set_flashdata('error', 'Username atau password salah');
			redirect('auth');
    }
	}
	public function logout()
	{
		// hapus semua data session
		$this->session->sess_destroy();

		// redirect ke halaman login
		redirect('auth');
	}
}
