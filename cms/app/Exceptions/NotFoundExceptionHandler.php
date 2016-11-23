<?php 

namespace App\Exceptions;


class NotFoundExceptionHandler extends ExceptionHandler{


public function __invoke($request,$response,$args){

	echo "I am here;";
	exit;


}
}

 ?>