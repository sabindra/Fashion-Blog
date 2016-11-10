<?php

namespace App\Validation;
use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;


class Validator{

	protected $error;


	public function __construct(){
	}

	public function validate($request,$rules){

		foreach ($rules as $field => $rule) {

			try{

				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			}catch(NestedValidationException $e){


				
				$this->error[$field] = $e->getMessages();
		}
}


		return $this;
	}


	public function failed(){
		return !empty($this->error);
	}

	public function getError(){

		return $this->error;
	}
}


