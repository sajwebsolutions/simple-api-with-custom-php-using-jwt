<?php

    ini_set('display_errors', 1);

    //JWT Token
    include '../vendor/autoload.php';
    use Firebase\JWT\JWT;

    //Headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Content-type: application/json; charset=UTF-8");

    //files
    include "../DB/Database.php";
    include "../classes/Users.php";

    //Objects
    $db     =       new Database();
    $connection =   $db->connect();
    $user   =       new Users($connection);

    //Access
    if( $_SERVER["REQUEST_METHOD"] === "POST" ){

        //Read Data
        $data       =       json_decode(file_get_contents("php://input"));

        if( !empty( $data->name ) and !empty( $data->email ) and !empty( $data->password ))
        {
            $user->name     =       $data->name;
            $user->email    =       $data->email;
            $user->password =       password_hash($data->password, PASSWORD_DEFAULT);

            if( $user->createUser() )
            {
                /*
                 JWT Token Creation. This is test project, so creating this in Register method

                    1. Header
                    2. Payload
                    3. Signature

                */

                //Prepare the 'payload' and 'key'
                $issuer         =       "localhost";
                $isse_at        =       time();
                $nbf            =       $isse_at + 10;
                $exp            =       $isse_at + 30;
                $aud            =       "users";
                $data           =       [
                                            "id"    =>  "1",
                                            "name"  =>  $data->name,
                                            "email" =>  $data->email
                                        ];

                $payload        =       [
                                            "iss"   =>  $issuer,
                                            "iat"   =>  $isse_at,
                                            "nbf"   =>  $nbf,
                                            "exp"   =>  $exp,
                                            "aud"   =>  $aud,
                                            "data"  =>  $data
                                        ];

                $key         =       "owt125";

                //Token Creation Method
                $jwt    =       JWT::encode($payload, $key,"HS256");

                http_response_code(200);
                echo json_encode([
                   "status" =>  200,
                   "jwt"    =>  $jwt,
                   "message"    => "User Created Successfully"
                ]);
            }
            else
            {
                http_response_code(500);
                echo json_encode([
                    "status" =>  500,
                    "message"    => "Failed to save user"
                ]);
            }
        }
        else
        {
            http_response_code(500);
            echo json_encode([
                "status"    =>  0,
                "message"   =>  "Data Missing"
            ]);
        }


    }else{
        http_response_code(503);
        echo json_encode([
            "status"    =>  0,
            "message"   =>  "Access Denied"
        ]);
    }
?>