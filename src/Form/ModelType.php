<?php
/**
 * @author Redjan Ymeraj <ymerajredjan@gmail.com>
 */

namespace App\Form;

use App\Entity\Model;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                "required" => true
            ))
            ->add('visibleInSidebar', CheckboxType::class, array(
                "required" => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Model::class
        ]);
    }
}