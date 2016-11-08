<?php 

namespace App\Interfaces;



interface IModel{

	public function create($array);

	public function findAll();

	public function find($id);

	public function update($id,$array);

	public function  delete($id);



}


 ?>