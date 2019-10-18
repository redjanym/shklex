<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Controller;

use App\Entity\Field;
use App\Entity\FieldTransaction;
use App\Entity\FieldValue;
use App\Entity\Model;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ParameterBag;
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
    public function indexAction(Request $request, $modelId, PaginatorInterface $paginator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $model = $entityManager->getRepository(Model::class)->find($modelId);
        $page = $request->query->getInt("page", 1);
        $limit = $request->query->getInt("limit", 10);

        // get transactions paginated
        $transactionsQuery = $entityManager->getRepository(FieldTransaction::class)->search($modelId);
        $transactions = $paginator->paginate(
            $transactionsQuery,
            $page,
            $limit
        );

        $transactionIds = array_map(function ($data){
            return $data['id'];
        }, $transactions->getItems());

        $fields = $entityManager->getRepository(Field::class)->findBy(array(
            "model" =>$model
        ));
        $rawFieldValues = $entityManager->getRepository(FieldValue::class)->findBy(array(
            "transaction" => $transactionIds
        ));

        $fieldValues = array();
        foreach ($transactionIds as $transactionId) {
            $fieldValues[$transactionId] = array();
        }

        /**
         * @var FieldValue $fieldValue
         */
        foreach ($rawFieldValues as $fieldValue) {
            $transaction = $fieldValue->getTransaction();
            $field = $fieldValue->getField();

            if(!isset($fieldValues[$transaction->getId()])){
                $fieldValues[$transaction->getId()] = array();
            }

            $fieldValues[$transaction->getId()][$field->getId()] = $fieldValue->getValue();
        }

        return $this->render("crud/index.html.twig", array(
            "model" => $model,
            "fields" => $fields,
            "values" => $fieldValues
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

        return $this->render("crud/create.html.twig", array(
            "model" => $model,
            "transaction_id" => null
        ));
    }

    /**
     * @Route("/save/{modelId}/{transactionId}")
     * @Method("POST")
     */
    public function saveAction(Request $request, $modelId, $transactionId = null)
    {
        // @todo ADD VALIDATIONS
        $entityManager = $this->getDoctrine()->getManager();
        $model = $entityManager->getRepository(Model::class)->find($modelId);
        $formData = new ParameterBag($request->request->get("crud_form"));

        if($transactionId){
            $transaction = $entityManager->getRepository(FieldTransaction::class)->find($transactionId);
            $this->deleteExistingFieldValuesPerTransaction($transactionId);
        } else {
            $transaction = new FieldTransaction();
            $transaction->setCreatedAt(new \DateTime());
            $entityManager->persist($transaction);
        }

        foreach ($formData as $fieldId => $fieldData) {
            $field = $entityManager->getRepository(Field::class)->find($fieldId);

            $value = new FieldValue();
            $value->setField($field);
            $value->setValue($fieldData);
            $value->setTransaction($transaction);

            $entityManager->persist($value);
        }

        $entityManager->flush();

        return $this->redirectToRoute("app_crud_index", array("modelId" => $modelId));
    }

    /**
     * @Route("/update/{modelId}/{transactionId}")
     * @Method("GET")
     */
    public function updateAction(Request $request, $modelId, $transactionId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $model = $entityManager->getRepository(Model::class)->find($modelId);

        return $this->render("crud/create.html.twig", array(
            "model" => $model,
            "transaction_id" => $transactionId
        ));
    }

    public function deleteExistingFieldValuesPerTransaction($transactionId)
    {
        $this->getDoctrine()->getConnection()->executeQuery(sprintf("DELETE FROM field_value WHERE transaction_id = %d", $transactionId));
    }
}