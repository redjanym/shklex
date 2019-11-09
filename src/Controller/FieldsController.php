<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Controller;

use App\Entity\Field;
use App\Entity\Model;
use App\Form\FieldType;
use App\Model\FieldInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fields")
 */
class FieldsController extends AbstractController
{
    /**
     * @Route("/create/{modelId}")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request, $modelId)
    {
        $model = $this->getDoctrine()->getRepository(Model::class)->find($modelId);
        $fields = $this->getDoctrine()->getRepository(Field::class)->findBy(array(
            "model" => $model
        ));

        $field = new Field();
        $form = $this->createForm(FieldType::class, $field, array(
            "action" => $this->generateUrl("app_fields_create", array("modelId" => $model->getId()))
        ));

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $field->setModel($model);

                $this->getDoctrine()->getManager()->persist($field);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute("app_fields_create", array("modelId" => $modelId));
            }
        }

        return $this->render("fields/create.html.twig", array(
            "model" => $model,
            "fields" => $fields,
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/update/{modelId}")
     * @Method({"POST"})
     */
    public function updateAction(Request $request, $modelId)
    {
        $model = $this->getDoctrine()->getRepository(Model::class)->find($modelId);
        $fields = $this->getDoctrine()->getRepository(Field::class)->findBy(array(
            "model" => $model
        ));

        if($request->getMethod() === "POST"){
            $updatedFields = $request->request->get("fields");

            foreach ($updatedFields as $fieldData) {
                $fieldData = new ParameterBag($fieldData);

                if($this->isFieldValid($fieldData)) {
                    $field = $this->getDoctrine()->getRepository(Field::class)->findOneBy(array(
                        "id" => $fieldData->getInt("id"),
                        "model" => $model
                    ));

                    if($fieldData->get("delete") === "on"){
                        $this->getDoctrine()->getManager()->remove($field);
                    } else {
                        $field = $this->updateField($field, $fieldData);
                        $this->getDoctrine()->getManager()->persist($field);
                    }

                    $this->getDoctrine()->getManager()->flush();
                }
            }
        }

        return $this->redirectToRoute("app_fields_create", array("modelId" => $modelId));
    }

    private function isFieldValid(ParameterBag $fieldData)
    {
        return $fieldData->getAlnum("title") && in_array(intval($fieldData->getInt("type")), array(FieldInterface::TYPE_STRING, FieldInterface::TYPE_TEXT, FieldInterface::TYPE_NUMBER, FieldInterface::TYPE_CHOICE));
    }

    private function updateField(Field $field, ParameterBag $fieldData)
    {
        $field
            ->setTitle($fieldData->get("title"))
            ->setListTitle($fieldData->get("list_title"))
            ->setShowTitle($fieldData->get("show_title"))
            ->setType($fieldData->getInt("type"))
            ->setChoices(trim($fieldData->get("choices")))
            ->setMultiple($fieldData->get("multiple") == "on")
            ->setRequired($fieldData->get("required") == "on")
            ->setAvailableInList($fieldData->get("available_in_list") == "on")
            ->setAvailableInShow($fieldData->get("available_in_show") == "on")
            ->setAvailableInCreate($fieldData->get("available_in_create") == "on")
        ;

        return $field;
    }
}