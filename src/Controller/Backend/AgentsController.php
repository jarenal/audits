<?php

namespace App\Controller\Backend;

use App\Entity\Agent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AgentsController extends Controller
{
    /**
     * @Route("/agents", name="agents_list", options={"expose"=true})
     */
    public function index()
    {
        return $this->render('agents/index.html.twig', [
            'controller_name' => 'AgentsController',
        ]);
    }

    /**
     * @Route("/agents/create", name="agents_create")
     */
    public function create()
    {
        return $this->render('agents/create.html.twig', ["data" => []]);
    }

    /**
     * @Route("/agents/edit/{slug}", name="agents_edit", options={"expose"=true})
     */
    public function edit(Request $request, $slug)
    {
        $agent = $this->getDoctrine()
            ->getRepository(Agent::class)
            ->find($slug);
        return $this->render('agents/create.html.twig', ["data" => $agent]);
    }
}
