<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class DatabaseSeeder extends Seeder{
 public function run(){foreach([['RD-10 Admin','admin@rd10.local','Admin@123','admin'],['RD-10 User','user@rd10.local','User@123','user']] as $x){$exists=$this->db->table('users')->where('email',$x[1])->get()->getRowArray();if(!$exists)$this->db->table('users')->insert(['name'=>$x[0],'email'=>$x[1],'password_hash'=>password_hash($x[2],PASSWORD_DEFAULT),'role'=>$x[3],'is_active'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);}}
}