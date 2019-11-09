<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Twig;


use App\Entity\Field;
use App\Entity\FieldValue;
use App\Entity\Model;
use App\Model\FieldInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CRUDExtension extends AbstractExtension
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var Router
     */
    protected $router;

    public function __construct(EntityManager $manager, Router $router)
    {
        $this->manager = $manager;
        $this->router = $router;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction("start_crud_form", array($this, "startCRUDForm"), array(
                "is_safe" => array("html" => true)
            )),
            new TwigFunction("end_crud_form", array($this, "endCRUDForm"), array(
                "is_safe" => array("html" => true)
            )),
            new TwigFunction("render_crud_form", array($this, "renderCRUDForm"), array(
                "is_safe" => array("html" => true)
            ))
        );
    }

    public function startCRUDForm(Model $model, $transactionId = null)
    {
        return sprintf("<form method='post' action='%s' class='form-horizontal'>", $this->router->generate("app_crud_save", array("modelId" => $model->getId(), "transactionId" => $transactionId)));
    }

    public function endCRUDForm()
    {
        return "</form>";
    }

    public function renderCRUDForm(Model $model, $transactionId = null)
    {
        $fields = $this->manager->getRepository(Field::class)->findBy(array(
            "model" => $model,
            "availableInCreate" => true
        ));

        $form = "";

        /**
         * @var Field $field
         */
        foreach ($fields as $field) {
            $valueEntity = $this->manager->getRepository(FieldValue::class)->findOneBy(array(
                "field" => $field,
                "transaction" => $transactionId
            ));

            $value = null;
            if($valueEntity){
                $value = $valueEntity->getValue();
            }

            $required = $field->getRequired() ? "required" : "";

            $form .= <<<PHP
            <div class="form-group">
                <label for="{$field->getId()}" class="col-sm-2 control-label">{$field->getTitle()}</label>

                <div class="col-sm-10">
PHP;
            if($field->getType() == FieldInterface::TYPE_STRING){
                $form .= <<<PHP
                <input type="text" name="crud_form[{$field->getId()}]" id="crud_form[{$field->getId()}]" {$required} class="form-control" value="{$value}">
PHP;
            } else if($field->getType() == FieldInterface::TYPE_TEXT){
                $form .= <<<PHP
                <textarea name="crud_form[{$field->getId()}]" id="crud_form[{$field->getId()}]" {$required} class="form-control">{$value}</textarea>
PHP;
            } else if($field->getType() == FieldInterface::TYPE_NUMBER){
                $form .= <<<PHP
                <input type="number" name="crud_form[{$field->getId()}]" id="crud_form[{$field->getId()}]" {$required} class="form-control" value="{$value}">
PHP;
            } else if($field->getType() == FieldInterface::TYPE_CHOICE){
                $form .= <<<PHP
                <select name="crud_form[{$field->getId()}]" id="crud_form[{$field->getId()}]" {$required} class="form-control">
                <option value="">Select a value</option>
PHP;
                foreach ($field->getChoicesAsArray() as $choice) {
                    $selected = $value == $choice ? "selected" : "";

                    $form .= <<<PHP
                <option value="{$choice}" {$selected}>{$choice}</option>
PHP;
                }
                $form .= <<<PHP
                </select>
PHP;
            } else if($field->getType() == FieldInterface::TYPE_DATETIME){
                $form .= <<<PHP
                <input type="date" name="crud_form[{$field->getId()}]" id="crud_form[{$field->getId()}]" {$required} class="form-control" value="{$value}">
PHP;
            }

            $form .= "</div></div>";
        }

        return $form;
    }
}