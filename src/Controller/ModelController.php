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
 * @Route("/model")
 */
class ModelController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $models = $entityManager->getRepository(Model::class)->findAll();

        return $this->render("model/index.html.twig", array(
            "models" => $models
        ));
    }

    /**
     * @Route("/create/{id}")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request, $id = null)
    {
        if($id){
            $model = $this->getDoctrine()->getRepository(Model::class)->find($id);
        } else {
            $model = new Model();
        }

        $form = $this->createForm(ModelType::class, $model, array(
            "action" => $this->generateUrl("app_model_create", array("id" => $model->getId()))
        ));

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->persist($model);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute("app_model_create", array("id" => $model->getId()));
            }
        }

        return $this->render("model/create.html.twig", array(
            "form" => $form->createView(),
            "model" => $model
        ));
    }
    /**
     * @Route("/delete/{id}")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $model = $this->getDoctrine()->getRepository(Model::class)->find($id);

        if($request->getMethod() == "POST"){
            $this->getDoctrine()->getManager()->remove($model);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("app_model_index");
        }

        return $this->render("model/delete.html.twig", array(
            "model" => $model
        ));
    }
}