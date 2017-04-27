<?php

namespace AppBundle\Form;

use AppBundle\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'rows' => '2',
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_message_form';
    }
}
