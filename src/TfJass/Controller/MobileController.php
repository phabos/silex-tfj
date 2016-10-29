<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Validator\Constraints as Assert;

	class MobileController
	{
	    public function mobileHome(Application $app)
	    {
	       	return $app['twig']->render('mobile/index.html');
	    }

	    public function dataIndex(Application $app)
	    {
	       	$content = $app['repository.content']->getContent('accueil');
	       	$concert = $app['repository.concert']->getConcert();
	       	$json = array(
	       		'content'      => $content->getContent(),
	       		'concertId'    => $concert->getId(),
	       		'concertDate'  => $concert->getDatec(),
	       		'concertLieu'  => $concert->getLieu(),
	       		'concertPrix'  => $concert->getPrix(),
	       		'concertHeure' => $concert->getHeure(),
	       		'concertGmaps' => $concert->getGmaps()
	       	);
    		return $app->json($json, 200);
	    }

	    public function dataPhotos(Application $app, Request $request)
	    {
	       	$photos = $app['repository.photo']->getMobilePhotos();
	       	$baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

	       	foreach ($photos as $photo) {
	       		$json[] = array(
	       			'image' => $baseurl . '/web/webroot/galerie/' . $photo['name'], 
	       			'text' => $photo['titre']
	       		);
	       	}

    		return $app->json($json, 200);
	    }

	    public function dataConcerts(Application $app, Request $request)
	    {
	       	$concerts = $app['repository.concert']->getAllConcert();

	       	foreach ($concerts as $concert) {
	       		$json[] = array(
	       			'concertDate'  => $concert->getDatec(),
	       			'concertLieu'  => $concert->getLieu(),
	       			'concertPrix'  => $concert->getPrix(),
	       			'concertHeure' => $concert->getHeure(),
	       			'concertGmaps' => $concert->getGmaps()
	       		);
	       	}

    		return $app->json($json, 200);
	    }

	    public function dataBio(Application $app, Request $request)
	    {
	       	$content = $app['repository.content']->getContent('biographie');
	       	$json = array('content' => $content->getContent());
    		return $app->json($json, 200);
	    }

	    public function dataNews(Application $app, Request $request)
	    {
	    	$data = json_decode($request->getContent(), true);
	    	$constraint = new Assert\Collection(array(
				'email' => new Assert\Email()
			));

			$errors = $app['validator']->validateValue($data, $constraint);
			if (count($errors) > 0) {
				return $app->json(array('error'=> '1', 'msg' => 'Votre email est incorrect !'));
			}

			$response = $app['repository.email']->addEmail($data['email']);
			return $app->json($response);
	    }

	    public function dataContact(Application $app, Request $request)
	    {
	    	$data = json_decode($request->getContent(), true);

	    	$constraint = new Assert\Collection(array(
				'email' => new Assert\Email(),
				'message' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 10)))
			));
			$errors = $app['validator']->validateValue($data, $constraint);
			if (count($errors) > 0) {
				return $app->json(array('error' => '1', 'msg' => 'Votre email est incorrect ou votre message est trop court !'));
			}else{
				$message = \Swift_Message::newInstance()
				        ->setSubject('[tfjass.fr] Formulaire contact')
						->setFrom(array($data['email']))
						->setTo(array($app['site_email']))
						->setBody($data['message']);

				$app['mailer']->send($message);
				return $app->json(array('error' => '', 'msg' => 'Message envoyé !'));
			}
	    }
	}
