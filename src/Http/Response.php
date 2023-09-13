<?php

/* 
* @Author: Emmanuel Onyo
* @Github: http://github.com/emmanuelonyo
* @Description: It's a class that helps you set headers and send json data.
*/

namespace Emmanuelonyo\PhpRouter\Http ; 


class Response{
    protected $title;
    
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

    public function render(string $view, array $data = ["title" => "Dashboard"])
    {
        // $view = str_replace('.', '/', $view);
        extract($data);
        
        if(isset($title)){
            $this->title = $title;
        }

        require_once  $view;
    }
}