<?php
//echo phpinfo();
//exit;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

// $awsCreds = new \BestNotes\Amazon\AWS\Credentials();
// $creds = $awsCreds->get();

$credentials = new \Aws\Credentials\Credentials('AKIAJMD47BPQUM45AX4Q', 'xsO08uVUNlK/wt1bFeU8KdTEql2yAHjvsjIE+KhH');

// $s3 = \Aws\S3\S3Client::factory(array(
	// 'version'     => 'latest',
	// 'region'      => 'us-east-1',
	// "signature"   => "v4",
	// 'credentials' => $credentials
// ));


//use Aws\DynamoDb\DynamoDbClient;

// Use the default credential provider
//$provider = CredentialProvider::defaultProvider();
//var_dump($provider);
//date_default_timezone_set('UTC');
// use Aws\DynamoDb\DynamoDbClient;

// $client = DynamoDbClient::factory(array(
    // 'key' => 'AKIAJMD47BPQUM45AX4Q',
    // 'secret'  => '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',
	// 'version' => '2012-08-10',
	// 'region'   => 'us-west-2',
	// 'base_url'   => 'http://localhost/SLIMAPI/src/public/',
// ));

// $client = new DynamoDbClient([
    // 'version'     => 'latest',
	// 'region'      => 'us-west-2',
	// "signature"   => "v4",
	// 'credentials' => $credentials
// ]);



use Aws\DynamoDb\Exception\DynamoDbException;

$sdk = new Aws\Sdk([
    'region'   => 'us-west-2',
    'version'  => 'latest',
	'credentials' => $credentials,
	//'endpoint'   => 'http://localhost',
]);

$dynamodb = $sdk->createDynamoDb();





$tableName = 'Testign';

###################################################################
//Adding data to the table


// echo "# Adding data to table $tableName...\n";

// $response = $dynamodb->putItem([
    // 'TableName' => $tableName,
    // 'Item' => [
        // 'Id' => ['N' => '120'],
        // 'Title' => ['S' => 'Book 120 Title'],
        // 'ISBN' => ['S' => '120-1111111111'],
        // 'Authors' => ['SS' => ['Author12', 'Author22']],
        // 'Price' => ['N' => '20'],
        // 'Category' => ['S' => 'Book'],
        // 'Dimensions' => ['S' => '8.5x11.0x.75'],
        // 'InPublication' => ['BOOL' => false],
    // ],
    // 'ReturnConsumedCapacity' => 'TOTAL'
// ]);

// echo "Consumed capacity: " . $response ["ConsumedCapacity"] ["CapacityUnits"] . "\n";

// $response = $dynamodb->putItem([
    // 'TableName' => $tableName,
    // 'Item' => [
        // 'Id' => ['N' => '121'],
        // 'Title' => ['S' => 'Book 121 Title'],
        // 'ISBN' => ['S' => '121-1111111111'],
        // 'Authors' => ['SS' => ['Author21', 'Author22']],
        // 'Price' => ['N' => '20'],
        // 'Category' => ['S' => 'Book'],
        // 'Dimensions' => ['S' => '8.5x11.0x.75'],
        // 'InPublication' => ['BOOL' => true],
    // ],
    // 'ReturnConsumedCapacity' => 'TOTAL'
// ]);
// $tableName = 'ExampleTable12';
// $response = $dynamodb->putItem([
    // 'TableName' => $tableName,
    // 'Item' => [
        // 'Id' => ['N' => '120'],
	// ],
    // 'ReturnConsumedCapacity' => 'TOTAL'
// ]);


// $response = $dynamodb->getItem ([
    // 'TableName' => $tableName,
    // 'ConsistentRead' => true,
    // 'Key' => [
        // 'TestID' => [
            // 'S' => '123' 
        // ] 
    // ],
    // 'ProjectionExpression' => 'TestID' 
// ] );

$response = $dynamodb->scan([
    'TableName' => $tableName
]);

// foreach ($response['Items'] as $key => $value) {
    // echo 'Id: ' . $value['Id']['S'] . "\n";
    // echo 'ReplyDateTime: ' . $value['ReplyDateTime']['S'] . "\n";
    // echo 'Message: ' . $value['Message']['S'] . "\n";
    // echo 'PostedBy: ' . $value['PostedBy']['S'] . "\n";
    // echo "\n";
// }

print_r ( $response );

// echo "Consumed capacity: " . $response ["ConsumedCapacity"] ["CapacityUnits"] . "\n";

###################################################################
//Getting an item from the table

// echo "\n\n";
// echo "# Getting an item from table $tableName...\n";

// $response = $dynamodb->getItem ([
    // 'TableName' => $tableName,
    // 'ConsistentRead' => true,
    // 'Key' => [
        // 'Id' => [
            // 'N' => '120' 
        // ] 
    // ],
    // 'ProjectionExpression' => 'Id, ISBN, Title, Authors' 
// ] );
// print_r ( $response ['Item'] );


// $tableName = 'ExampleTable12';

// echo "# Creating table $tableName...\n";

// $result = $dynamodb->createTable([
    // 'TableName' => $tableName,
    // 'AttributeDefinitions' => [
        // [ 'AttributeName' => 'Id', 'AttributeType' => 'N' ]
    // ],
    // 'KeySchema' => [
        // [ 'AttributeName' => 'Id', 'KeyType' => 'HASH' ]
    // ],
    // 'ProvisionedThroughput' => [
        // 'ReadCapacityUnits'    => 5, 
        // 'WriteCapacityUnits' => 6
    // ]
// ]);

// print_r($result->getPath('TableDescription'));

// $dynamodb->waitUntil('TableExists', [
    // 'TableName' => $tableName,
    // '@waiter' => [
        // 'delay'       => 5,
        // 'maxAttempts' => 20
    // ]
// ]);

//asdasdsadasd
$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run();