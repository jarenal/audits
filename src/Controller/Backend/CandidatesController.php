<?php

namespace App\Controller\Backend;

use App\Entity\Candidate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CandidatesController extends Controller
{
    /**
     * @Route("/candidates", name="candidates_list", options={"expose"=true})
     */
    public function index()
    {
        return $this->render('candidates/index.html.twig', [
            'controller_name' => 'CandidatesController',
        ]);
    }

    /**
     * @Route("/candidates/create", name="candidates_create")
     */
    public function create()
    {
        return $this->render('candidates/create.html.twig', ["data" => []]);
    }

    /**
     * @Route("/candidates/edit/{slug}", name="candidates_edit", options={"expose"=true})
     */
    public function edit(Request $request, $slug)
    {
        $candidate = $this->getDoctrine()
            ->getRepository(Candidate::class)
            ->find($slug);
        return $this->render('candidates/create.html.twig', ["data" => $candidate]);
    }
}
