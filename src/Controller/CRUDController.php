<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Controller;

use App\Entity\Model;
use App\Form\ModelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/crud")
 */
class CRUDController extends AbstractController
{
    /**
     * @Route("/{modelId}")
     */
    public function indexAction(Request $request, $modelId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $model = $entityManager->getRepository(Model::class)->find($modelId);

        return $this->render("crud/index.html.twig", array(
            "model" => $model
        ));
    }

    /**
     * @Route("/create/{modelId}")
     * @Method("GET")
     */
    public function createAction(Request $request, $modelId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $model = $entityManager->getRepository(Model::class)->find($modelId);

        return $this->render("model/create.html.twig", array(
            "model" => $model
        ));
    }

    /**
     * @Route("/save/{modelId}")
     * @Method("POST")
     */
    public function saveAction(Request $request, $modelId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $model = $entityManager->getRepository(Model::class)->find($modelId);
    }
}