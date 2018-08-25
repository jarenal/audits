<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Candidate;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/candidates")
 */
class CandidatesController extends FOSRestController
{
    /**
     * @Rest\Get(path="", name="api_candidates_get", options={"expose"=true})
     */
    public function getAction(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT c FROM App\Entity\Candidate c WHERE c.is_deleted=0 ORDER BY c.created_at DESC");
            $response['data'] = $query->execute();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post(path="", name="api_candidates_post", options={"expose"=true})
     */
    public function post(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $data = $request->request->get('candidate');
            $em = $this->getDoctrine()->getManager();
            $candidate = new Candidate();
            $candidate->setName($data['name']);
            $candidate->setPhone($data['phone']);
            $candidate->setEmail($data['email']);
            $candidate->setIsActive((bool)$data['is_active']);
            $em->persist($candidate);
            $em->flush();
            $response['data']['id'] = $candidate->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }


    /**
     * @Rest\Put(path="/{slug}", name="api_candidates_put", options={"expose"=true})
     */
    public function put(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $candidate = $this->getDoctrine()
                ->getRepository(Candidate::class)
                ->find($slug);
            $data = $request->request->get('candidate');
            $candidate->setName($data['name']);
            $candidate->setPhone($data['phone']);
            $candidate->setEmail($data['email']);
            $candidate->setIsActive((bool)$data['is_active']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidate);
            $em->flush();
            $response['data']['id'] = $candidate->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Delete(path="/{slug}", name="api_candidates_delete", options={"expose"=true})
     */
    public function delete(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $candidate = $this->getDoctrine()
                ->getRepository(Candidate::class)
                ->find($slug);
            $candidate->setIsDeleted(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidate);
            $em->flush();
            $response['data']['id'] = $candidate->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Patch(path="/{slug}", name="api_candidates_patch", options={"expose"=true})
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
                $candidate = $this->getDoctrine()
                    ->getRepository(Candidate::class)
                    ->find($slug);
                $candidate->setIsActive($candidate->getIsActive() ? 0 : 1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($candidate);
                $em->flush();
                $response['data']['id'] = $candidate->getId();
            }

        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }
}
