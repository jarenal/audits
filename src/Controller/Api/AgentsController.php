<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/agents")
 */
class AgentsController extends FOSRestController
{
    /**
     * @Rest\Get(path="", name="api_agents_get", options={"expose"=true})
     */
    public function getAction(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT u FROM App\Entity\User u WHERE u.is_deleted=0 AND u.roles IN ('ROLE_AGENT') ORDER BY u.created_at DESC");
            $response['data'] = $query->execute();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post(path="", name="api_agents_post", options={"expose"=true})
     */
    public function post(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $data = $request->request->get('agent');
            $em = $this->getDoctrine()->getManager();
            $agent = new User();
            $agent->setName($data['name']);
            $agent->setPhone($data['phone']);
            $agent->setEmail($data['email']);
            $agent->setUsername($data['email']);
            $agent->setIsActive((bool)$data['is_active']);
            $agent->setRoles(['ROLE_AGENT']);
            $agent->setPassword('1234');
            $em->persist($agent);
            $em->flush();
            $response['data']['id'] = $agent->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }


    /**
     * @Rest\Put(path="/{slug}", name="api_agents_put", options={"expose"=true})
     */
    public function put(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $agent = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($slug);
            $data = $request->request->get('agent');
            $agent->setName($data['name']);
            $agent->setPhone($data['phone']);
            $agent->setEmail($data['email']);
            $agent->setUsername($data['email']);
            $agent->setIsActive((bool)$data['is_active']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($agent);
            $em->flush();
            $response['data']['id'] = $agent->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Delete(path="/{slug}", name="api_agents_delete", options={"expose"=true})
     */
    public function delete(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $agent = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($slug);
            $agent->setIsDeleted(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($agent);
            $em->flush();
            $response['data']['id'] = $agent->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Patch(path="/{slug}", name="api_agents_patch", options={"expose"=true})
     */
    public function patch(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $data['op'] = $request->request->get('op', null);
            $data['field'] = $request->request->get('field', null);
            $data['value'] = $request->request->get('value', null);

            if ($data['op'] === 'toggle' && $data['field'] === 'active' && !$data['value']) {
                $agent = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($slug);
                $agent->setIsActive($agent->getIsActive() ? 0 : 1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($agent);
                $em->flush();
                $response['data']['id'] = $agent->getId();
            }

        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }
}
