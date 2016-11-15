<?php 

namespace App\Aws;
use Aws\S3\S3Client;

class AmazonService{


	public function __construct(){


	}

	public function getAWS(){

		$s3 = S3Client::factory([
        'key'    => getenv('AWS_ACCESS_KEY_ID'),
        'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
        'region'=>"ap-southeast-2",
        'version'=>'latest'
    ]);

		return $s3;
}

}

