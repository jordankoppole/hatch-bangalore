<?php
namespace Service;
require '../services/DatabaseService.php';

use Aws\DynamoDb\Marshaler;

class UserService {

	private $dbService = null;
	private $userTableName = 'Users';

	public function __construct() {
		$this->dbService = new \Service\DatabaseService();
		$this->dynamodb  = \Service\DatabaseService::getConnection();
	}

	public function getUserList()
	{
		$response = $this->dbService->scanTable($this->userTableName);
		//print_r($response);
		$outputArray = array();
		foreach ($response['Items'] as $key => $value) {
			$outputArray[$key]['userID'] = $value['userID']['N'];
			$outputArray[$key]['password'] = $value['password']['S'];
			$outputArray[$key]['firstName'] = $value['firstName']['S'];
			$outputArray[$key]['lastName'] = $value['lastName']['S'];
		}

		return $outputArray;
	}

	public function createUser($itemsArray)
	{
		require_once 'PassHash.php';

		$marshaler = new Marshaler();

		if (self::isUserExists($itemsArray['emailID'], $this->userTableName))
		{
			return USER_ALREADY_EXISTED;
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
			return true;
		}

		return false;
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
			return FALSE;
		}

		$hashPassword = $response['Items'][0]['password']['S'];

		if(PassHash::check_password($hashPassword, $password))
		{
			return TRUE;;
		}
		else
		{
			return FALSE;
		}
	}
}
