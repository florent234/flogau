<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSortie', TextType::class, ['label' => 'Nom de la sortie:', 'required'=>true])
            ->add('dateHeure', DateTimeType::class, ['label' => 'Date:', 'required'=>true])
            ->add('dateLimiteInscription', DateTimeType::class, ['label' => 'Date limite d\'inscription:', 'required'=>true])
            ->add('nbplaces', IntegerType::class, ['label' => 'Nombres de places :', 'attr' => ['min'=>1], 'required'=>true])
            ->add('duree', IntegerType::class,
                ['label' => 'Durée :', 'attr' => ['class' => 'number', 'placeholder'=>90, 'step' => 30, 'min'=>0, 'max'=>420], 'required'=>true])
            ->add('description', TextareaType::class, ['label' => 'Déscription:', 'required'=>true])
            ->add('rue', TextType::class, ['label' => 'Rue:', 'required'=>true])
            ->add('codePostal', TextType::class, ['label' => 'Code Postal:', 'required'=>true])
            ->add('campus', EntityType::class, ['class' => 'App\Entity\Campus', 'choice_label'=> 'nomCampus','label' => 'Campus :', 'required'=>true])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class
        ]);
    }
}
