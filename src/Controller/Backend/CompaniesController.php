<?php

namespace App\Controller\Backend;

use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompaniesController extends Controller
{
    /**
     * @Route("/companies", name="companies_list", options={"expose"=true})
     */
    public function index()
    {
        return $this->render('companies/index.html.twig', [
            'controller_name' => 'CompaniesController',
        ]);
    }

    /**
     * @Route("/companies/create", name="companies_create")
     */
    public function create()
    {
        return $this->render('companies/create.html.twig', ["data" => []]);
    }

    /**
     * @Route("/companies/edit/{slug}", name="companies_edit", options={"expose"=true})
     */
    public function edit(Request $request, $slug)
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($slug);
        return $this->render('companies/create.html.twig', ["data" => $company]);
    }
}
