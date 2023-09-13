<?php

use Emmanuelonyo\PhpRouter\Http\Request;
use Emmanuelonyo\PhpRouter\Http\Response;

$app->get('/example', function($params, Request $req, Response $res){
    $res->render(__DIR__ ."/../views/home.php");
});

$app->get('/example/:id', function($params, Request $req, Response $res){
    $res->render(__DIR__ ."/../views/home.php", ["params" => $params]);
});

