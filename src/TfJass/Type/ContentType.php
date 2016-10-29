<?php

namespace TfJass\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContentType extends AbstractType
{
    protected $options;

    public function __construct($options = array()) {
    	$this->options = $options;
	}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('titre', 'text')
            ->add('url', 'hidden', array('data' => (!empty($this->options['url']) ? $this->options['url'] : '')))
            ->add('content', 'textarea');
    }

    public function getName()
    {
        return 'content';
    }
}