<?php

/**
 * @Author: Ryan Basnet
 * @Date:   2016-11-22 00:13:04
 * @Last Modified by:   Ryan Basnet
 * @Last Modified time: 2016-11-22 12:49:28
 */

namespace App\Services;

use PDO;
use stdClass;

/**
 * @package App\Services
 * @author Ryan Basnet
 * @license SroutTech
 */
class Paginator{

	private $conn;
	private $limit;
	private $page;
	private $query;
	private $total;
	private $pages;


	public function __construct($conn){

		$this->conn = $conn;
	}

	public function setQuery($query){

		$this->query = $query;
		$statement = $this->conn->prepare($this->query);
		$statement->execute();
		$this->total = $statement->rowCount();
		
	}


	public function paginate($limit=5,$page=1){

		$this->limit = $limit;
		$this->page = $page;


	//Validate limit
	$this->limit = ($this->limit<=$this->total) ? $this->limit : $this->total;


	//Validate page
	$this->page = (int) $this->page;
	$this->page = (!empty($this->page) && $this->page >= 1 ) ? $this->page : 1;

	//reset page
	
	$this->pages = ($this->total >0)?ceil($this->total/$this->limit):0;
	
	//reset page num if invalid
	$this->page =($this->pages>=$this->page) ? $this->page : $this->pages;


	//offset calculation
	$start = ($this->page-1) * $this->limit;


	$this->query.=" LIMIT {$start}, ${limit} ";
	$statement = $this->conn->prepare($this->query);
	
	$statement->execute();
	$results = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$result = new stdClass();
	 $result->page   = $this->page;
	 $result->pages   = $this->pages;
    $result->limit  = $this->limit;
    $result->total  = $this->total;
    $result->data   = $results;

    return $result;
	}


	public function paginationLinks($link,$css_id){

		
		$pages = $this->pages;
		$page =$this->page;
		$prev=null;
		$next=null;
		
		$pageNums = array();
		$pageLinks = array();

		
		for ($i=1; $i <= $pages ; $i++) { 
			
			
			if($i==$page && $pages>=$page){

				//set prev link
				if($i!=1){
					
					$prevPage =$page-1;
					$prev = '<a href="'.$link.'?page='.$prevPage.'" class="pull-left" id="pb-l">Prev</a>';
					$pageLinks['prev'] = $prev;

				}

				//set next link
				if($i!=$pages){
					
					$nextPage=$page+1;
					$next ='<a href="'.$link.'?page='.$nextPage.'" class=" pull-right" id="pb-r">Next</a>';
					$pageLinks['next'] = $next;

				}

			}
			
		}

		
		return $pageLinks;
	}




}

























