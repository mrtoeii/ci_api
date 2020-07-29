<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'./libraries/API_Controller.php';

class User_api extends API_Controller {

	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
	}

	public function simple_api(){
		
		// API Configuration
		$this->_apiConfig([
			'methods' => ['POST'],  // Request Method Only POST
		]);
	}

	/**
	 * API Limit
	 * @link : api/v1/limit
	 */
	public function api_limit(){
		/**
		 * API Limit
		 * ----------------------------------
		 * @param: {int} API limit Number
		 * @param: {string} API limit Type (IP)
		 * @param: {int} API limit Time [minute]
		 */

		$this->_APIConfig([
			'methods' => ['POST'], 
			// number limit, type limit, time limit (last minute)
			'limit' => [12, 'ip', 5] 
		]);
	}

	/**
	 * API Key without Database
	 */
	public function api_key(){
		/**
		 * Use API Key without Database
		 * ---------------------------------------------------------
		 * @param: {string} Types
		 * @param: {string} API Key
		 * @link : api/v1/api_key
		 */

		$this->_APIConfig([
			'methods' => ['POST'],

			// Use API Key with Database
			'key' => ['header'],

			// Add Custom data in api Response
			'data'=>[
				'is_login'=>false
			]
		]);

		// Data
		// $data = array(
		// 	'status'=>'OK',
		// 	'data'=>[
		// 		'user_id'=>12
		// 	]
		// );

		$data = 0;
		/**
		 * Return API Response
		 * ---------------------------------------------------------
		 * @param: API Data
		 * @param: Request Status Code
		 */
		if(!empty($data)){
			$this->api_return($data,'200');
		}else{
			$this->api_return([
				'status'=>false,
				'error'=>'Invalid Data',
				
			],'404'
			);
		}
		
	}

	/**
	 * Login User with API
	 */
	public function login(){
		// API Configuration
		header("Access-Control-Allow-Origin: *");

		// API Configuration
		$this->_apiConfig([
			'methods' => ['POST'],
		]);

		// you user authentication code will go here, you can compare the user with the database or whatever
		$payload = [
			'id' => "Your User's ID",
			'other' => "Some other data"
		];

		// Load Authorization Library or Load in autoload config file
		$this->load->library('authorization_token');

		// generte a token
		$token = $this->authorization_token->generateToken($payload);

		// return data
		$this->api_return(
			[
				'status' => true,
				"result" => [
					'token' => $token,
				],
				
			],
		200);
	}

	/**
	 * view User Data
	 *
	 * @link [api/user/view]
	 * @method POST
	 * @return Response|void
	 */
	public function view()
	{
		header("Access-Control-Allow-Origin: *");

		// API Configuration [Return Array: User Token Data]
		$user_data = $this->_apiConfig([
			'methods' => ['POST'],
			'requireAuthorization' => true,
		]);

		// return data
		$this->api_return(
			[
				'status' => true,
				"result" => [
					'user_data' => $user_data['token_data']
				],
			],
		200);
	}
	/**
	 * 
	 * Refer : 	https://github.com/ctechhindi/CodeIgniter-API-Controller
				https://www.youtube.com/playlist?list=PLmrTMUhqzS3itcXhLWTm-NLdAArstfZ6Z

	 * 
	 */
	



	public function selectCustomer(){
		header('Content-type: application/json');
		$json = json_decode(file_get_contents('php://input'));
		$data = [
			'A','B','C','D'
		];
		echo json_encode($data);
	}
	public function selectVM(){
		// $data = array(
		// 	array(
		// 		"datetime"=>'01.06.2020 14:00:00 - 14:15:00',
		// 		"Toatal"=>12.6667
		// 	),
		// 	array(
		// 		"datetime"=>'01.06.2020 14:15:00 - 14:30:00',
		// 		"Toatal"=>15.8
		// 	),
		// 	array(
		// 		"datetime"=>'01.06.2020 14:30:00 - 15:00:00',
		// 		"Toatal"=>16.3333
		// 	),
		// 	array(
		// 		"datetime"=>'01.06.2020 14:45:00 - 15:15:00',
		// 		"Toatal"=>25.3333
		// 	)

		// );
		$data = [
			'1','2','3','4'
		];
		echo json_encode($data);
	}
	public function selectVM2(){
		$data_2 = array(
			array(
				"datetime"=>'01.06.2020 14:00:00 - 14:15:00',
				"Toatal"=>12.6667
			),
			array(
				"datetime"=>'01.06.2020 14:15:00 - 14:30:00',
				"Toatal"=>15.8
			),
			array(
				"datetime"=>'01.06.2020 14:30:00 - 15:00:00',
				"Toatal"=>16.3333
			),
			array(
				"datetime"=>'01.06.2020 14:45:00 - 15:15:00',
				"Toatal"=>25.3333
			)

		);

		$data_1 = array(
			'name'=>'CPU Load',
			'sensor_id'=>2092,
			'avg'=>10.62709638888889,
			'max'=>69.1333,
			'min'=>0,
			'raw_data'=>$data_2
		);

		$data =  array(
			'cpu_data'=>$data_1
		);
		echo json_encode($data);
	}
}
