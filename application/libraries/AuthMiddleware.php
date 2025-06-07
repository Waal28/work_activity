<?php
class AuthMiddleware {
  protected $CI;

  public function __construct() {
    $this->CI =& get_instance();
  }

  public function check($is_access_allowed) {
    $role = $this->CI->session->userdata('role');

    // jika belum login, redirect ke login page
    if (!$role) {
      redirect('auth');
    }

    // jika role tidak termasuk yang diperbolehkan, tampilkan error atau redirect ke dashboard
    if (!$is_access_allowed) {
      // show_error('Unauthorized access', 403, 'Forbidden');
      redirect('dashboard');
    }
  }
}
