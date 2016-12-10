<?php

namespace Service;

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

require_once '../vendor/aws' . '/aws-autoloader.php';
require_once '../config/Config.php';

use Aws;

class DatabaseService {

	private static $connection = null;

	private static function initConnection()
	{

		$credentials = new \Aws\Credentials\Credentials(ACCESS_KEY, SECRET_ACCESS_KEY);

		$sdk = new Aws\Sdk([
			'region'   => REGION,
			'version'  => VERSION,
			'credentials' => $credentials,
			//'endpoint'   => 'http://localhost',
		]);

		$dynamodb = $sdk->createDynamoDb();

		self::$connection = $dynamodb;
	}

	public static function getConnection()
	{
		if (self::$connection == null) {
			self::initConnection();
		}
		return self::$connection;
	}

	public function scanTable($tableName)
	{

		$dynamodb = self::getConnection();
		$response = $dynamodb->scan([
			'TableName' => $tableName
		]);

		return $response;
	}

	public function getLatestPrimaryKey($tableName)
	{
		$dynamodb = self::getConnection();

		$response = $dynamodb->query([
		    'TableName' => $tableName,
		    'KeyConditionExpression' => 'userID = :v_id',
		    'ExpressionAttributeValues' =>  [
		        ':v_id' => ['N' => '1']
		    ]
		]);

		print_r($response['Items']);

		return false;
	}

}