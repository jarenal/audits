<?php
/**
 * Created by PhpStorm.
 * User: jarenal
 * Date: 05/05/18
 * Time: 02:10
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     * @return Response
     */
    public function number()
    {
        $number = mt_rand(0, 100);

        return $this->render('lucky/number.html.twig', ['number' => $number]);
    }
}