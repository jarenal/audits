<?php

namespace App\Controller\Backend;

use App\Entity\Audit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuditsController extends Controller
{
    /**
     * @Route("/audits", name="audits_list", options={"expose"=true})
     */
    public function index()
    {
        return $this->render('audits/index.html.twig', []);
    }

    /**
     * @Route("/audits/create", name="audits_create")
     */
    public function create()
    {
        return $this->render('audits/create.html.twig', ["data" => []]);
    }

    /**
     * @Route("/audits/edit/{slug}", name="audits_edit", options={"expose"=true})
     */
    public function edit(Request $request, $slug)
    {
        $audit = $this->getDoctrine()
            ->getRepository(Audit::class)
            ->find($slug);
        return $this->render('audits/create.html.twig', ["data" => $audit]);
    }
}
