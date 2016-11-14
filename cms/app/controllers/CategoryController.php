<?php 

namespace App\Controllers;
use PDO;
use App\Validation\Validator;
use Respect\Validation\Validator as v;


class CategoryController extends Controller{



	public function getIndex($request,$response){

		$category = $this->container->category->findAll($id=null);

		return $this->container->view->render($response,'admin/partials/category/category.twig',['category'=>$category]);


	}


	public function addCategory($request,$response){

		$rules = [

				'category'=>v::notEmpty()->alpha()
				
		];
		

		$validation = $this->container->validator->validate($request,$rules);

		if($validation->failed()){
			
			$category = $this->container->category->findAll($id=null);
			return $this->container->view->render($response,'admin/partials/category/category.twig',['category'=>$category,'errors'=>$validation->getError()]);
		}
		$data =array();
		$data['title'] = ucfirst($request->getParam('category'));
		$this->container->category->create($data);
		$this->container->flash->addMessage('success','Category is added.');
		return $response->withRedirect($this->container->router->pathFor('admin.category'));

		


	}

	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function editCategory($request,$response,$args){

		$category_id = $args['id'];
		$editCategory = $this->container->category->find($category_id);
		$category = $this->container->category->findAll($id=null);
		return $this->container->view->render($response,'admin/partials/category/category.twig',['category'=>$category,'editMode'=>TRUE,'editCategory'=>$editCategory]);


	}

	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function updateCategory($request,$response,$args){
				$category_id = $args['id'];
				$editCategory = $this->container->category->find($category_id);
				$category = $this->container->category->findAll($id=null);

			$rules = [

				'category'=>v::notEmpty()->alpha()
				
		];
		

		$validation = $this->container->validator->validate($request,$rules);

		if($validation->failed()){
			
			return $this->container->view->render($response,'admin/partials/category/category.twig',['category'=>$category,'editMode'=>TRUE,'editCategory'=>$editCategory,'errors'=>$validation->getError()]);
		}


	
		$data= array();
		$data['title'] = $request->getParam('category');
		$this->container->category->update($category_id,$data);
		$this->container->flash->addMessage('success',"Category updated successfully !");
		return $response->withRedirect($this->container->router->pathFor('admin.category'));

	}

	/**
	 * [getUserForm description]
	 * [HTTP request object] $request 
	 * @param  [HTTP response object] $response 
	 * @return [type]           [description]
	 */
	public function destroyCategory($request,$response,$args){

		$user_id = $args['id'];
		$this->container->category->delete($user_id);
		$this->container->flash->addMessage('success',"Category deleted successfully !");
		return $response->withRedirect($this->container->router->pathFor('admin.category'));


	}





}

















 ?>