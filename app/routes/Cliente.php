<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/cliente/login', function (Request $request, Response $response) {
    $email = $request->getParam('email');
    $password = $request->getParam('password');

    $sql = "select * from cliente where cli_correo = :email and 
            cli_password = :password";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $data = $stmt->fetchObject();
        if ($data) {
            $json = array("error" => false,
                "mensaje" => $data);
            return $response->write(json_encode($json));
        } else {

            $json = array("error" => true,
                "mensaje" => "usuario y/o password incorrectos");
            return $response->withStatus(400)->write(json_encode($json));
        }
    } catch (PDOException $e) {
        $response->write($e);
    }
});