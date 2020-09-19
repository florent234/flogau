<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ClientsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('genre', ChoiceType::class, ['label' => 'Genre : ','label_attr' => array('class' => 'labelClient'),  'choices'  => [
                'Madame' => true,
                'Monsieur' => false,
            ],])
            ->add('prenom', TextType::class, ['label' => 'Prenom : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('nom', TextType::class, ['label' => 'Nom : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('telephone', TextType::class, ['label' => 'Téléphone : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('email', EmailType::class, ['label' => 'Email : ', 'label_attr' => array('class' => 'labelClient')])
            ->add('rgpdCentreCo', CheckboxType::class, ['label' => 'J’accepte de recevoir les actualités et les offres du centre commercial Aushopping Villebon 2 :', 'required' => false])
            ->add('rgpdPanel', CheckboxType::class, ['label' => 'J’accepte de participer au panel de consommateurs Coclicco :', 'required' => false])
            ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clients::class
        ]);
    }
}
