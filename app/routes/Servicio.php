<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/servicio/obtener/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "select *
        from servicio
        where aviso_avi_id = :id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($data) {
            $json = array("error" => false,
                "servicios" => $data);
            return $response->withStatus(200)
                ->write(json_encode($json));
        } else {
            $json = array("error" => true,
                "mensaje" => "este aviso no tiene servicios");
            return $response->withStatus(400)
                ->write(json_encode($json));

        }
    } catch (PDOException $e) {
        return $response->write($e);
    }
});

$app->post('/servicio/publicar', function (Request $request, Response $response){
    
});