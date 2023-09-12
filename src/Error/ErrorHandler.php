<?php

namespace mmanuelonyo\PhpRouter\Error;
use Emmanuelonyo\PhpRouter\Http\{Request, Response};

class ErrorHandler{
    protected static Request $request;
    protected static Response $response;

    public static function Notfound(string|array $data){
        Response::status(404);
        if(is_array($data)){
            Response::json($data);
        }else{
            Response::json(["message"=> $data ]);            
        }

        exit();
    }

    public static function UnauthorizedError(string|array $data){
        Response::status(401);
        if(is_array($data)){
            Response::json($data);
        }else{
            Response::json(["message"=> $data ]);            
        }

        exit();
    }

    public static function badRequestError(string|array $data){
        Response::status(400);
        if(is_array($data)){
            Response::json($data);
        }else{
            Response::json(["message"=> $data ]);            
        }

        exit();
    }
    
    public static function serverError(string|array $data){
        Response::status(500);
        if(is_array($data)){
            Response::json($data);
        }else{
            Response::json(["message"=> $data ]);            
        }

        exit();
    }    



}
