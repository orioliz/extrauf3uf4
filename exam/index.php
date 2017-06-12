<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'config.slim.php';



$app = new \Slim\App(['settings'=>$config]);


$container = $app->getContainer();


$container['db']=function($c)   {
    $db=$c['settings']['db'];
    $pdo=new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'],$db['user'],$db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    return $pdo;
};

//echo 'hola';
 
/**/
    
$app->get('/ids', function(Request $req, Response $res) {
    $stmt=$this->db->prepare("SELECT latitud, longitud FROM empleats");
    $stmt->execute();
    $result=$stmt->fetchAll();
    return $this->response->withJson($result);
});




$app->get('/id/{id}',function(Request $req, Response $res, $args)  {
    $id=(int)$args['id'];
    $stmt=$this->db->prepare("SELECT latitud, longitud FROM empleats WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $result=$stmt->fetchAll();
    return $this->response->withJson($result);
});
/**/

$app->run();    