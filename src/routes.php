<?php

  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\HttpFoundation\Request;
  use Silex\Application;
  use TfJass\Vendor\MobileDetect;

	$app->get('/', 'TfJass\Controller\ContentController::indexAction')
	    ->bind('homepage');
	$app->get('/biographie', 'TfJass\Controller\ContentController::getBioContent')
	    ->bind('biographie');
	$app->match('/admin/modifier/{name}', 'TfJass\Controller\ContentController::adminContentAction')
	    ->bind('adminmodifier');
	$app->match('/admin/', 'TfJass\Controller\ContentController::adminHomeAction')
	    ->bind('adminhome');
	$app->get('/nextconcert', 'TfJass\Controller\ConcertController::getNextConcert')
	    ->bind('nextconcert');
	$app->get('/concerts', 'TfJass\Controller\ConcertController::getConcertContent')
	    ->bind('concerts');
	$app->match('/admin/concerts', 'TfJass\Controller\ConcertController::adminConcertsAction')
	    ->bind('adminconcerts');
	$app->match('/admin/concerts/edit/{id}', 'TfJass\Controller\ConcertController::adminConcertsEditAction')
	    ->bind('adminconcertedit');
	$app->get('/admin/delete-concerts/{id}', 'TfJass\Controller\ConcertController::adminDeleteConcertsAction')
	    ->convert('id', function ($id) use ($app) { if((int) $id){ return $app['repository.concert']->find($id); }})
	    ->bind('adminconcertdelete');
	$app->get('/photos', 'TfJass\Controller\GallerieController::getPhotoContent')
	    ->bind('photos');
	$app->match('/admin/photos', 'TfJass\Controller\GallerieController::adminPhotosAction')
	    ->bind('adminphotos');
	$app->get('/admin/delete-photos/{id}', 'TfJass\Controller\GallerieController::adminDeletePhotosAction')
	  	->convert('id', function ($id) use ($app) { if((int) $id){ return $app['repository.photo']->find($id); }})
		  ->bind('admindeletephotos');
	$app->match('/newsletter', 'TfJass\Controller\NewsletterController::formAction')
	    ->bind('newsletter');
	$app->match('/login', 'TfJass\Controller\AdminUserController::loginAction')
	    ->bind('adminlogin');
	$app->get('/admin/newsletter', 'TfJass\Controller\NewsletterController::adminNewsletterAction')
	    ->bind('adminnewsletter');
	$app->get('/admin/emails', 'TfJass\Controller\NewsletterController::adminEmailsAction')
	    ->bind('adminemails');
	$app->match('/contact', 'TfJass\Controller\ContactController::formAction')
	    ->bind('contact');

	/**
	 * Mobile route
	 */
	$app->get('/mobile/home', 'TfJass\Controller\MobileController::mobileHome')
			->bind('mobileHome');
	$app->get('/mobile/data-index', 'TfJass\Controller\MobileController::dataIndex')
			->bind('dataIndex');
	$app->get('/mobile/data-photos', 'TfJass\Controller\MobileController::dataPhotos')
			->bind('dataPhotos');
	$app->get('/mobile/data-concerts', 'TfJass\Controller\MobileController::dataConcerts')
			->bind('dataConcerts');
	$app->get('/mobile/data-bio', 'TfJass\Controller\MobileController::dataBio')
			->bind('dataBio');
	$app->match('/mobile/data-news', 'TfJass\Controller\MobileController::dataNews')
			->bind('dataNews');
	$app->match('/mobile/data-contact', 'TfJass\Controller\MobileController::dataContact')
			->bind('dataContact');

	$app->error(function (\Exception $e, $code) use ($app) {
		if ($app['debug']) {
			return;
		}

		// 404.html, or 40x.html, or 4xx.html, or error.html
		$templates = array(
			'errors/'.$code.'.html',
			'errors/'.substr($code, 0, 2).'x.html',
			'errors/'.substr($code, 0, 1).'xx.html',
			'errors/default.html',
		);
		return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code, 'message' => $e->getMessage())), $code);
	});

	$app->before(function (Request $request, Application $app)
	{
    	$detect = new MobileDetect;
    	preg_match("/(mobile)/", $request->getRequestUri(), $out);

    	if ($detect->isMobile() && count($out) == 0) {
			return $app->redirect($app['url_generator']->generate('mobileHome'));
		}
	});
