<?php

namespace App\Controller\Api;

use App\Entity\AuditStatus;
use App\Entity\Candidate;
use App\Entity\Company;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Audit;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/audits")
 */
class AuditsController extends FOSRestController
{
    /**
     * @Rest\Get(path="", name="api_audits_get", options={"expose"=true})
     */
    public function getAction(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT a FROM App\Entity\Audit a WHERE a.is_deleted=0 ORDER BY a.created_at DESC");
            $response['data'] = $query->execute();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post(path="", name="api_audits_post", options={"expose"=true})
     */
    public function post(Request $request)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $data = $request->request->get('audit');
            $em = $this->getDoctrine()->getManager();
            $audit = new Audit();

            /** @var Company $company */
            $company = $this->getDoctrine()
                ->getRepository(Company::class)
                ->find($data['company']);
            $audit->setCompany($company);

            /** @var Candidate $candidate */
            $candidate = $this->getDoctrine()
                ->getRepository(Candidate::class)
                ->find($data['candidate']);
            $audit->setCandidate($candidate);

            /** @var User $agent */
            $agent = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($data['agent']);
            $audit->setAgent($agent);

            $audit->setRequiredPosition($data['required_position']);
            $audit->setStartDate(\DateTime::createFromFormat("d/m/Y", $data['start_date']));
            $audit->setEndDate(\DateTime::createFromFormat("d/m/Y", $data['end_date']));

            /** @var AuditStatus $auditStatus */
            $auditStatus = $this->getDoctrine()
                ->getRepository(AuditStatus::class)
                ->find($data['status']);
            $audit->setStatus($auditStatus);

            $em->persist($audit);
            $em->flush();
            $response['data']['id'] = $audit->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }


    /**
     * @Rest\Put(path="/{slug}", name="api_audits_put", options={"expose"=true})
     */
    public function put(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $audit = $this->getDoctrine()
                ->getRepository(Audit::class)
                ->find($slug);
            $data = $request->request->get('audit');

            /** @var Company $company */
            $company = $this->getDoctrine()
                ->getRepository(Company::class)
                ->find($data['company']);
            $audit->setCompany($company);

            /** @var Candidate $candidate */
            $candidate = $this->getDoctrine()
                ->getRepository(Candidate::class)
                ->find($data['candidate']);
            $audit->setCandidate($candidate);

            /** @var User $agent */
            $agent = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($data['agent']);
            $audit->setAgent($agent);

            $audit->setRequiredPosition($data['required_position']);
            $audit->setStartDate(\DateTime::createFromFormat("d/m/Y", $data['start_date']));
            $audit->setEndDate(\DateTime::createFromFormat("d/m/Y", $data['end_date']));

            /** @var AuditStatus $auditStatus */
            $auditStatus = $this->getDoctrine()
                ->getRepository(AuditStatus::class)
                ->find($data['status']);
            $audit->setStatus($auditStatus);

            $em = $this->getDoctrine()->getManager();
            $em->persist($audit);
            $em->flush();
            $response['data']['id'] = $audit->getId();
        }

        $view = $this->view($response, $statusCode);
        return $this->handleView($view);
    }

    /**
     * @Rest\Delete(path="/{slug}", name="api_audits_delete", options={"expose"=true})
     */
    public function delete(Request $request, $slug)
    {
        $response = ['status' => 'success', 'data' => []];
        $statusCode = 200;

        if ($request->isXmlHttpRequest()) {
            $candidate = $this->getDoctrine()
                ->getRepository(Audit::class)
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

}
