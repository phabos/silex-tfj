<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\Form\Extension\Core\Type\FormType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;
	use TfJass\Type\ContactType;

	class ContactController
	{

	    public function formAction(Request $request, Application $app)
	    {
				$data = array(
		      'email' => 'Email',
		      'message' => 'Message',
		    );

		    $form = $app['form.factory']->createBuilder(FormType::class, $data)
		        ->add('email', TextType::class)
		        ->add('message', TextareaType::class)
		        ->getForm();

				$form->handleRequest($request);

				if ($request->getMethod() == 'POST' && $form->isValid()) {
					$data = $form->getData();

					$constraint = new Assert\Collection(array(
					    'email' => new Assert\Email(),
					    'message' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10)))
					));
					$errors = $app['validator']->validateValue($data, $constraint);
					if (count($errors) > 0) {
						return $app->json(array('error' => '1', 'msg'=>'Votre email est incorrect ou votre message est trop court !'));
					}else{
						/*$message = \Swift_Message::newInstance()
							        ->setSubject('[tfjass.fr] Formulaire contact')
							        ->setFrom(array($app['site_email'] => $email))
							        ->setTo(array($app['admin_email']))
							        ->setBody($msg)
									->setContentType('text/html');

						$app['mailer']->send($message);

						$app['swiftmailer.spooltransport']
							->getSpool()
							->flushQueue($app['swiftmailer.transport'])
						;*/
					}
			  }

		    return $app['twig']->render('contactform.html', array('form' => $form->createView()));
	    }

	}
