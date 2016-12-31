<?php
namespace Service;
require '../services/DatabaseService.php';

use Aws\DynamoDb\Marshaler;

date_default_timezone_set('Asia/Calcutta');

class UserService {

	private $dbService 		= null;
	private $userTableName 	= 'Users';
	public  $responseText	= array();

	public function __construct() {
		$this->dbService = new \Service\DatabaseService();
		$this->dynamodb  = \Service\DatabaseService::getConnection();
	}

	public function getUserList()
	{
		$response = $this->dbService->scanTable($this->userTableName);

		if (empty($response))
		{
			$this->responseText["error"] 	= true;
			$this->responseText["message"] = "Oops! An error occurred while get user list";
			return false;
		}

		$outputArray = array();
		foreach ($response['Items'] as $key => $value) {
			$outputArray[$key]['userID'] = $value['userID']['N'];
			$outputArray[$key]['age'] = $value['age']['S'];
			$outputArray[$key]['name'] = $value['name']['S'];
			$outputArray[$key]['emailID'] = $value['emailID']['S'];
		}

		$this->responseText["error"] 	= false;
		$this->responseText["values"] 	= $outputArray;
		return false;
	}

	public function createUser($itemsArray)
	{
		require_once 'PassHash.php';

		$marshaler = new Marshaler();

		if (self::isUserExists($itemsArray['emailID'], $this->userTableName))
		{
			$this->responseText["error"] 	= true;
			$this->responseText["message"] = "Sorry, this email already existed";
			return false;
		}

		$password_hash = PassHash::hash($itemsArray['password']);

		$itemsArray['password'] = $password_hash;

		//Add new userID
		$itemsArray['userID'] = strtotime ("now");

		$getJSONFormat = json_encode($itemsArray);


		$response = $this->dynamodb->putItem([
			'TableName' => $this->userTableName,
			'Item' => $marshaler->marshalJson($getJSONFormat),
			'ReturnConsumedCapacity' => 'TOTAL'
		]);

		if (empty($response))
		{
			$this->responseText["error"] 	= true;
			$this->responseText["message"] = "Oops! An error occurred while registereing";
			return false;
		}
		else
		{
			$this->responseText["error"] 	= false;
			$this->responseText["message"] = "You are successfully registered";
			return false;
		}
	}

	/**
	 * Checking for duplicate user by email address
	 * @param String $email email to check in db
	 * @return boolean
	 */
	private function isUserExists($email, $tableName)
	{
		$response = $this->dynamodb->query([
			'TableName' => $this->userTableName,
			'IndexName' => 'emailID',
			'KeyConditionExpression' => 'emailID = :email_id',
			'ExpressionAttributeValues' =>  [
				':email_id' => ['S' => "{$email}"]
			]
		]);

		if (!empty($response['Items']))
		{
			return true;
		}

		return false;

	}

	/**
	 * Checking user login
	 * @param String $email User login email id
	 * @param String $password User login password
	 * @return boolean User login status success/fail
	 */
	public function checkLogin($email, $password)
	{
		require_once 'PassHash.php';

		$this->responseText["error"] 	= true;
		$this->responseText["message"] 	= "Oops! There is some error with email or Password";

		$response = $this->dynamodb->query([
			'TableName' => $this->userTableName,
			'IndexName' => 'emailID',
			'KeyConditionExpression' => 'emailID = :email_id',
			'ExpressionAttributeValues' =>  [
				':email_id' => ['S' => "{$email}"]
			]
		]);

		if (empty($response['Items']))
		{
			$this->responseText["error"] 	= true;
			$this->responseText["message"] = "This email id is not exists";
			return false;
		}

		$hashPassword = $response['Items'][0]['password']['S'];

		if(PassHash::check_password($hashPassword, $password))
		{
			$this->responseText["error"] 	= false;
			$this->responseText["message"] = "Logged in successfully";
			return false;
		}
	}

	/**
	 * Checking user exists
	 * @param String $email User login email id
	 * @return boolean User login status success/fail
	 */
	public function checkUserExists($email)
	{
		$this->responseText["error"] 	= true;
		$this->responseText["message"] 	= "Oops! This email id is already exists";

		$response = $this->dynamodb->query([
			'TableName' => $this->userTableName,
			'IndexName' => 'emailID',
			'KeyConditionExpression' => 'emailID = :email_id',
			'ExpressionAttributeValues' =>  [
				':email_id' => ['S' => "{$email}"]
			]
		]);

		if (empty($response['Items']))
		{
			$this->responseText["error"] 	= false;
			$this->responseText["message"] = "This email id is not exists";
			return false;
		}
	}
}
