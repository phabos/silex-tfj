<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use TfJass\Entity\Concert;
	use TfJass\Type\ConcertType;


	class ConcertController
	{

	    public function getNextConcert(Application $app)
	    {
	    	$concert = $app['repository.concert']->getConcert();
	    	return $app['twig']->render('nextconcert.html', array('concert'=>$concert));
	    }

	    public function getConcertContent(Application $app)
	    {
	       	$concerts = $app['repository.concert']->getAllConcert($app['sql_limit']);
    		return $app['twig']->render('concerts.html', array('concerts'=>$concerts));	
	    }

	    /********* ADMIN STUFF ***********/
	    public function adminConcertsAction(Request $request, Application $app)
	    {
    		$concerts = $app['repository.concert']->getAllConcert();

			$concertEntity = new Concert();
			$form = $app['form.factory']->create(new ConcertType(), $concertEntity);
			
			$form->handleRequest($request);

			if ($request->getMethod() == 'POST' && $form->isValid()) {
				$app['repository.concert']->addConcert($form->getData());
				$app['session']->getFlashBag()->add('message', array('type'=>'success','txt'=>'Concert created !'));
				return $app->redirect($app['url_generator']->generate('adminconcerts'));
			}

    		return $app['twig']->render('admin/adminConcerts.html', array('concerts' => $concerts, 'form' => $form->createView()));
    	}

    	public function adminConcertsEditAction(Request $request, Application $app)
	    {
    		$concert_id = $request->attributes->get('id');
    		$concert = $app['repository.concert']->getConcertById($concert_id);

			$form = $app['form.factory']->create(new ConcertType(), $concert);
			
			$form->handleRequest($request);

			if ($request->getMethod() == 'POST' && $form->isValid()) {
				$app['repository.concert']->modifyConcert($form->getData());
				$app['session']->getFlashBag()->add('message', array('type'=>'success','txt'=>'Concert modified !'));
				return $app->redirect($app['url_generator']->generate('adminconcerts'));
			}

    		return $app['twig']->render('admin/adminConcertsEdit.html', array('concert' => $concert,'form' => $form->createView()));
    	}

    	public function adminDeleteConcertsAction(Application $app, Request $request)
    	{
    		$concert = $request->attributes->get('id');
    		$app['repository.concert']->deleteConcert($concert);
    		$app['session']->getFlashBag()->add('message', array('type'=>'success','txt'=>'Concert supprimée !'));
    		return $app->redirect($app['url_generator']->generate('adminconcerts'));
    	}

	}