<?php

namespace TfJass\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', 'choice', array(
			    'choices' => $this->getDateForm(),
			    'expanded' => false
			))
			->add('titre', 'text')
			->add('file', 'file');
    }

    public function getName()
    {
        return 'photo';
    }

    private function getDateForm()
    {
    	$date = array();
    	$debut = date('Y');
    	for ($i = $debut; $i > 2000; $i--) 
    	{
    		$date[$i] = $i;
		}
		return $date;
    }
}
