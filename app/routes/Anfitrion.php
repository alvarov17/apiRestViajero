<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/anfitrion/login', function (Request $request, Response $response) {
    $email = $request->getParam('email');
    $password = $request->getParam('password');

    $sql = "select * from anfitrion where anf_correo = :email and anf_password = :password";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        if ($data) {

            $json = array("error" => false,
                "anfitrion" => $data);

            return $response->withStatus(200)
                ->write(json_encode($json));
        } else {

            $json = array("error" => true,
                "mensaje" => "email y/o password incorrectos");

            return $response->withStatus(400)
                ->write(json_encode($json));
        }
    } catch (PDOException $e) {
        $response->write($e);
    }
});