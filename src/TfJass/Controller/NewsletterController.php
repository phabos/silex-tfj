<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;
	use Symfony\Component\HttpFoundation\Response;
	use TfJass\Entity\Email;
	use TfJass\Type\EmailType;

	class NewsletterController
	{

	    public function formAction(Request $request, Application $app)
	    {

	    	$emailEntity = new Email();
			$form = $app['form.factory']->create(new EmailType(), $emailEntity);

			$form->handleRequest($request);

			if ($request->getMethod() == 'POST') {
				if($form->isValid()){
					$response = $app['repository.email']->addEmail($form->getData()->getEmail());
					return $app->json($response);
			    }else{
			    	return $app->json(array('error'=>'1', 'msg' => 'Votre email est incorrect !'));
			    }
		    }

	    	return $app['twig']->render('newsform.html', array('form' => $form->createView()));
	    }

	    /************ Admin STUFF *************/

	    public function adminEmailsAction(Application $app)
    	{
    		$emails = $app['repository.email']->getAllEmail();
    		header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=emails-export_".date('d-m-Y').".csv");
			header("Pragma: no-cache");
			header("Expires: 0");

		    ob_start();
			$output = fopen("php://output", "w");

			foreach ($emails as $row){
				fputcsv($output, array($row->getEmail()), ';');
			}

			fclose($output);
			exit();
    	}

    	public function adminNewsletterAction(Application $app)
	    {
    		return $app['twig']->render('admin/adminNewsletter.html');
    	}

	}
