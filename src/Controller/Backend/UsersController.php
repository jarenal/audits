<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    /**
     * @Route("/companies/{company_id}/users", name="users_list", options={"expose"=true})
     */
    public function index($company_id)
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($company_id);

        if (!$company) {
            throw $this->createNotFoundException('The company does not exist');

        }

        return $this->render('users/index.html.twig', ['company' => $company]);

    }

    /**
     * @Route("/companies/{company_id}/users/create", name="users_create")
     */
    public function create($company_id)
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($company_id);

        if (!$company) {
            throw $this->createNotFoundException('The company does not exist');
        }

        return $this->render('users/create.html.twig', ["data" => [], "company" => $company]);
    }

    /**
     * @Route("/companies/{company_id}/users/edit/{slug}", name="users_edit", options={"expose"=true})
     */
    public function edit(Request $request, $company_id, $slug)
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($company_id);

        if (!$company) {
            throw $this->createNotFoundException('The company does not exist');
        }

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($slug);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return $this->render('users/create.html.twig', ["data" => $user, "company" => $company]);
    }
}
