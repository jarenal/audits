<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class StarController extends FOSRestController
{

    /**
     * @Rest\Post(path="/token", name="api_post_token")
     */
    public function post(Request $request)
    {
        try {
            if ($request->get("client_id") !== "R2D2" || $request->get("client_secret") !== "Alderan") {
                throw new Exception("Bad credentials", 100);
            }

            if ($request->getContentType() !== "form") {
                throw new Exception("Wrong content-type", 102);
            }

            if ($request->request->get("grant_type") !== "client_credentials") {
                throw new Exception("Wrong body", 103);
            }

            $response = ["access_token" => "e31a726c4b90462ccb7619e1b51f3d0068bf8006",
                "expires_in" => 99999999999,
                "token_type" => "Bearer",
                "scope" => "TheForce"];

            $statusCode = 200;

        } catch (\Exception $ex) {
            $response = ["message" => $ex->getMessage(), "code" => $ex->getCode()];
            $statusCode = 401;
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Delete(path="/reactor/exhaust/{id}", name="api_delete_reactor")
     */
    public function delete(Request $request)
    {
        try {
            $contentType = $request->getContentType();
            if ($request->getContentType() !== "json") {
                throw new Exception("Wrong content-type", 102);
            }

            $headers = $request->headers->all();
            $token = explode(" ", $headers["authorization"][0])[1];

            if ($token !== "e31a726c4b90462ccb7619e1b51f3d0068bf8006") {
                throw new \Exception("Wrong authorization", 104);
            }

            $response = [];
            $statusCode = 200;
        } catch (\Exception $ex) {
            $response = ["message" => $ex->getMessage(), "code" => $ex->getCode()];
            $statusCode = 401;
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get(path="/prisoner/{name}", name="api_get_prisoner")
     */
    public function getAction(Request $request, $name)
    {
        try {
            $contentType = $request->getContentType();
            if ($request->getContentType() !== "json") {
                throw new Exception("Wrong content-type", 102);
            }

            $headers = $request->headers->all();
            $token = explode(" ", $headers["authorization"][0])[1];

            if ($token !== "e31a726c4b90462ccb7619e1b51f3d0068bf8006") {
                throw new \Exception("Wrong authorization", 104);
            }

            $response = ["cell" => "01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111",
                "block" => "01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 00101101 00110010 00110011 00101100"];
            $statusCode = 200;
        } catch (\Exception $ex) {
            $response = ["message" => $ex->getMessage(), "code" => $ex->getCode()];
            $statusCode = 401;
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }
}