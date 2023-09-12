<?php

/* 
* @Author: Emmanuel Onyo
* @Github: http://github.com/emmanuelonyo
* @Description: It's a class that helps you set headers and send json data.
*/

namespace Emmanuelonyo\PhpRouter\Http ; 


class Response{
    
    public static function setHeaders(array $headers):Void {
        foreach($headers as $header){
            header($header);
        }
    }
    
    public static function status(int $code):void {
        header("HTTP/1.1 ".$code."");
        http_response_code($code);
    }

    public static function json(array $data = []):void{
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit();
    }
}