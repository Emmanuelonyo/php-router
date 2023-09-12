<?php

/* 
* @Author: Emmanuel Onyo
* @Github: http://github.com/emmanuelonyo
* @Description: It's a class that will help you get the request body, params and files from the request. 
*/

namespace Emmanuelonyo\PhpRouter\Http;

class Request {

    public static function body(){
        $body = file_get_contents("php://input");
        return json_decode($body);
    }

    public static function params(){
        $params = $_REQUEST;
        return $params;
    }

    public static function query(){
        $params = $_GET;
        return $params;
    }

    public static function file(){
        $params = $_FILES;
        return $params;
    }



}