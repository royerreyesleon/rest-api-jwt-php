<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-jwt-php/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/user.php';
 
// get database connection
$database = new Database();
$db       = $database->getConnection();
 
// instantiate product object
$user = new User($db);
 
// submitted data will be here
// get posted data
/*
http://localhost/rest-api-jwt-php/rest-api-authentication-example/api/create_user.php
{
 "firstname" : "Mike",
 "lastname"  : "Dalisay",
 "email"     : "mike@codeofaninja.com",
 "password"  : "555"
}
*/
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$user->firstname = isset($data->firstname) ? $data->firstname : '';
$user->lastname  = isset($data->lastname)  ? $data->lastname  : '';
$user->email     = isset($data->email)     ? $data->email     : '';
$user->password  = isset($data->password)  ? $data->password  : '';
 
// use the create() method here}// create the user
if(
    !empty($user->firstname) &&
    !empty($user->email)     &&
    !empty($user->password)  &&
    $user->create()
){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "El usuario fue creado."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "No se pudo crear el usuario, atributos deben incluirse y tener valor asignado."));
}
?>