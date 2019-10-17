<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Form;

use App\Entity\Field;
use App\Model\FieldInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                "required" => true
            ))
            ->add('listTitle', TextType::class, array(
                "required" => false
            ))
            ->add('showTitle', TextType::class, array(
                "required" => false
            ))
            ->add('type', ChoiceType::class, array(
                "required" => true,
                "choices" => array(
                    "String" => FieldInterface::TYPE_STRING,
                    "Text" => FieldInterface::TYPE_TEXT,
                    "Number" => FieldInterface::TYPE_NUMBER
                ),
                "by_reference" => true
            ))
            ->add('required', CheckboxType::class, array(
                "required" => false
            ))
            ->add('availableInList', CheckboxType::class, array(
                "required" => false
            ))
            ->add('availableInShow', CheckboxType::class, array(
                "required" => false
            ))
            ->add('availableInCreate', CheckboxType::class, array(
                "required" => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Field::class
        ]);
    }
}