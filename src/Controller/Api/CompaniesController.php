<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/companies")
 */
class CompaniesController extends FOSRestController
{
    /**
     * @Rest\Get(path="", name="api_companies_get", options={"expose"=true})
     */
    public function getAction(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $search = $request->query->get("search", "");
            $dropdown = $request->query->get("dropdown", false);
            if ($dropdown) {
                $query = $em->createQuery("SELECT c FROM App\Entity\Company c WHERE c.is_deleted=0 AND c.is_active=1 AND c.name LIKE :name ORDER BY c.created_at DESC");
                $query->setParameter("name", "%$search%");
            } else {
                $query = $em->createQuery("SELECT c FROM App\Entity\Company c WHERE c.is_deleted=0 ORDER BY c.created_at DESC");
            }

            $response['data'] = $query->execute();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post(path="", name="api_companies_post", options={"expose"=true})
     */
    public function post(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $data = $request->request->get('company');
            $em = $this->getDoctrine()->getManager();
            $company = new Company();
            $company->setName($data['name']);
            $company->setPhone($data['phone']);
            $company->setEmail($data['email']);
            $company->setRfc($data['rfc']);
            $company->setAddress($data['address']);
            $company->setContact($data['contact']);
            $company->setIsActive((bool)$data['is_active']);
            $em->persist($company);
            $em->flush();
            $response['data']['id'] = $company->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }


    /**
     * @Rest\Put(path="/{slug}", name="api_companies_put", options={"expose"=true})
     */
    public function put(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $company = $this->getDoctrine()
                ->getRepository(Company::class)
                ->find($slug);
            $data = $request->request->get('company');
            $company->setName($data['name']);
            $company->setPhone($data['phone']);
            $company->setEmail($data['email']);
            $company->setRfc($data['rfc']);
            $company->setAddress($data['address']);
            $company->setContact($data['contact']);
            $company->setIsActive((bool)$data['is_active']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            $response['data']['id'] = $company->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Delete(path="/{slug}", name="api_companies_delete", options={"expose"=true})
     */
    public function delete(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $company = $this->getDoctrine()
                ->getRepository(Company::class)
                ->find($slug);
            $company->setIsDeleted(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            $response['data']['id'] = $company->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Patch(path="/{slug}", name="api_companies_patch", options={"expose"=true})
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
                $company = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->find($slug);
                $company->setIsActive($company->getIsActive() ? 0 : 1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($company);
                $em->flush();
                $response['data']['id'] = $company->getId();
            }

        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }
}
