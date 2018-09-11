<?php

namespace App\Controller\Api;

use App\Entity\Company;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/companies")
 */
class UsersController extends FOSRestController
{
    /**
     * @Rest\Get(path="/{company_id}/users", name="api_users_get", options={"expose"=true})
     */
    public function getAction(Request $request, $company_id)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT u FROM App\Entity\User u WHERE u.is_deleted=0 AND u.roles IN ('ROLE_EMPLOYEE') AND u.company=:company ORDER BY u.created_at DESC");
            $query->setParameter('company', $company_id);
            $response['data'] = $query->execute();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post(path="/{company_id}/users", name="api_users_post", options={"expose"=true})
     */
    public function post(Request $request, $company_id)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        try {
            if ($request->isXmlHttpRequest()) {
                $data = $request->request->get('user');
                $em = $this->getDoctrine()->getManager();
                $user = new User();
                $user->setName($data['name']);
                $user->setPhone($data['phone']);
                $user->setEmail($data['email']);
                $user->setUsername($data['email']);
                $user->setIsActive((bool)$data['is_active']);
                $user->setRoles(['ROLE_EMPLOYEE']);
                $user->setPassword('1234');

                $company = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->find($company_id);

                if (!$company) {
                    throw new \Exception('Company not found', 404);
                }

                $user->setCompany($company);

                $em->persist($user);
                $em->flush();
                $response['data']['id'] = $user->getId();
            }
        } catch (\Exception $ex) {
            $response['status'] = 'error';
            switch ($ex->getCode()) {
                case 404:
                    $response['message'] = $ex->getMessage();
                    $statusCode = 404;
                    break;
                default:
                    $response['message'] = "Internal server error";
                    $statusCode = 500;
                    break;
            }
        }


        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }


    /**
     * @Rest\Put(path="/{company_id}/users/{slug}", name="api_users_put", options={"expose"=true})
     */
    public function put(Request $request, $company_id, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        try {
            if ($request->isXmlHttpRequest()) {
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($slug);
                $data = $request->request->get('user');
                $user->setName($data['name']);
                $user->setPhone($data['phone']);
                $user->setEmail($data['email']);
                $user->setUsername($data['email']);
                $user->setIsActive((bool)$data['is_active']);
                $em = $this->getDoctrine()->getManager();

                $company = $this->getDoctrine()
                    ->getRepository(Company::class)
                    ->find($company_id);

                if (!$company) {
                    throw new \Exception('Company not found', 404);
                }

                $user->setCompany($company);

                $em->persist($user);
                $em->flush();
                $response['data']['id'] = $user->getId();
            }
        } catch (\Exception $ex) {
            $response['status'] = 'error';
            switch ($ex->getCode()) {
                case 404:
                    $response['message'] = $ex->getMessage();
                    $statusCode = 404;
                    break;
                default:
                    $response['message'] = "Internal server error";
                    $statusCode = 500;
                    break;
            }
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Delete(path="/{company_id}/users/{slug}", name="api_users_delete", options={"expose"=true})
     */
    public function delete(Request $request, $company_id, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        try {
            if ($request->isXmlHttpRequest()) {
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy(['id' => $slug, 'company' => $company_id]);

                if (!$user) {
                    throw new \Exception('User not found', 404);
                }

                $user->setIsDeleted(1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $response['data']['id'] = $user->getId();
            }
        } catch (\Exception $ex) {
            $response['status'] = 'error';
            switch ($ex->getCode()) {
                case 404:
                    $response['message'] = $ex->getMessage();
                    $statusCode = 404;
                    break;
                default:
                    $response['message'] = "Internal server error";
                    $statusCode = 500;
                    break;
            }
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Patch(path="/{company_id}/users/{slug}", name="api_users_patch", options={"expose"=true})
     */
    public function patch(Request $request, $company_id, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        try {
            if ($request->isXmlHttpRequest()) {
                $data['op'] = $request->request->get('op', null);
                $data['field'] = $request->request->get('field', null);
                $data['value'] = $request->request->get('value', null);

                if ($data['op'] === 'toggle' && $data['field'] === 'active' && !$data['value']) {
                    $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findOneBy(['id' => $slug, 'company' => $company_id]);

                    if (!$user) {
                        throw new \Exception('User not found', 404);
                    }

                    $user->setIsActive($user->getIsActive() ? 0 : 1);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $response['data']['id'] = $user->getId();
                }

            }
        } catch (\Exception $ex) {
            $response['status'] = 'error';
            switch ($ex->getCode()) {
                case 404:
                    $response['message'] = $ex->getMessage();
                    $statusCode = 404;
                    break;
                default:
                    $response['message'] = "Internal server error";
                    $statusCode = 500;
                    break;
            }
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }
}
