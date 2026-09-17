<?php
namespace App\Controllers;
use CodeIgniter\Controller;
abstract class BaseController extends Controller
{
 protected $helpers=['url','form','auth'];
 protected function mustLogin(){if(!session()->get('logged_in'))return redirect()->to(base_url('login'));return null;}
 protected function mustAdmin(){if($r=$this->mustLogin())return $r;if(!is_admin())return redirect()->to(base_url('dashboard'))->with('error','Admin access required.');return null;}
 protected function render($view,$data=[]){$data['user']=current_user();return view('layouts/header',$data).view('layouts/sidebar',$data).view($view,$data).view('layouts/footer',$data);}
}