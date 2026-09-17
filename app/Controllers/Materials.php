<?php namespace App\Controllers;
class Materials extends BaseController{
 public function index(){if($r=$this->mustLogin())return $r;$m=new \App\Models\MaterialModel();$q=trim((string)$this->request->getGet('q'));if($q)$m->groupStart()->like('code',$q)->orLike('description',$q)->orLike('vendor_name',$q)->groupEnd();return $this->render('materials/index',['pageTitle'=>'Materials','rows'=>$m->orderBy('id','ASC')->findAll()]);}
 public function create(){if($r=$this->mustAdmin())return $r;(new \App\Models\MaterialModel())->insert($this->request->getPost());return redirect()->back()->with('success','Material saved.');}}
