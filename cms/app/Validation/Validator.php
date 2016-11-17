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


	public function validateImage($request,$file,$imageRules){

		// retrieve parameters for validation
		
		$uploadFileType = $imageRules['fileType'];
		$uploadSize = $imageRules['fileSize'];

		// attributes from uploaded file
		$f = $file['image'];
		$fileExt = strtolower(end(explode(".",$f)));
		$fileSize = $file['size'];
		
	// echo($fileSize);
	// echo($uploadSize);
	// echo($fileSize==$uploadSize);
	// exit;

		if(empty($f)){

			$this->error['post-image'][]="Please upload image.";
			
		}

		if($fileSize>$uploadSize){

			
			$this->error['post-image'][]="Image size must not exceed 6MB.";
			

		}


		if(!in_array(strtolower(pathinfo($f,PATHINFO_EXTENSION)),$uploadFileType)){

			$this->error['post-image'][]="Please upload valid image (gif,jpeg,jpg,png). ";
			
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


