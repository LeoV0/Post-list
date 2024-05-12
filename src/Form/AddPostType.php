<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'label'=>'A remplir obligatoirement',
                'attr'=>[
                    'placeholder' => 'Cette valeur est obligatoire'
                ],

                'constraints'=> [
                    new NotBlank([
                        'message'=>'Le titre est obligatoire',
                    ]),
                    new NotNull(),
                    new Length(['min'=>2,
                                'max'=>30,
                                'minMessage' =>'Le nombre de caractère minimum est de {{ limit }}',
                                'maxMessage' =>'Le nombre de caractère maximum est de {{ limit }}']),
                    ]
            ])
            ->add('contenu')
            ->add('submit', SubmitType::class,[
                'label' => 'Envoyer', 
            'attr'=> [
                'class'=>'btn btn-primary',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
