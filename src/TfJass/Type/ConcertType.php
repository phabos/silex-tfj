<?php

namespace TfJass\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('datec', 'date', array('format' => 'dd-MM-yyyy'))
            ->add('lieu', 'text')
            ->add('prix', 'text')
            ->add('heure', 'time', array('with_seconds' => false))
            ->add('gmaps', 'text', array('required' => false));
    }

    public function getName()
    {
        return 'concert';
    }
}