<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        return $this->render("dashboard/index.html.twig");
    }
}