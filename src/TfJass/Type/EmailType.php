<?php

namespace TfJass\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'constraints' => new Assert\Email(),
            ));
    }

    public function getName()
    {
        return 'email';
    }
}
