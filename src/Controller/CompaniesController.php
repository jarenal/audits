<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompaniesController extends Controller
{
    /**
     * @Route("/companies", name="companies")
     */
    public function index()
    {
        return $this->render('companies/index.html.twig', [
            'controller_name' => 'CompaniesController',
        ]);
    }
}
