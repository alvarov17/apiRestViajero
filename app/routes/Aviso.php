<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/aviso/obtenertodos', function (Request $request, Response $response) {
    $sql = "select
      av.avi_id,
      av.avi_fecha,
      av.avi_estado,
      av.avi_lat,
      av.avi_lng,
      av.avi_titulo,
      anf.anf_nombre,
      anf.anf_apellido,
      anf.anf_correo,
      anf.anf_numeroCel
    from aviso av inner join anfitrion anf on av.anfitrion_anf_id = anf.anf_id;";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $json = array("error" => false,
                "avisos" => $data);
            return $response->withStatus(200)->write(json_encode($json));
        } else {
            $json = array("error" => true,
                "mensaje" => "aun no existen avisos");
            return $response->withStatus(400)->write(json_encode($json));
        }

    } catch (PDOException $e) {
        return $response->write($e);
    }
});

$app->get('/aviso/publicados/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "select * from aviso where anfitrion_anf_id = :id";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetchObject();

        if ($data) {
            $json = array("error" => false,
                "aviso" => $data);
            return $response->withStatus(200)->write(json_encode($json));
        } else {
            $json = array("error" => true,
                "aviso" => "aun no hay avisos publicados");
            return $response->withStatus(400)->write(json_encode($json));
        }
    } catch (PDOException $e) {
        return $response->write($e);
    }
});