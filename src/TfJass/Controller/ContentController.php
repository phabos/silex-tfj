<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use TfJass\Entity\Content;
	use TfJass\Type\ContentType;

	class ContentController
	{
	    public function indexAction(Request $request, Application $app)
	    {
	       	$content = $app['repository.content']->getContent('accueil');
    		return $app['twig']->render('index.html', array('content'=>$content));	
	    }

	    public function getBioContent(Application $app)
	    {
	       	$content = $app['repository.content']->getContent('biographie');
    		return $app['twig']->render('biographie.html', array('content'=>$content));	
	    }


	    /******** ADMIN STUFF **************/
	    public function adminHomeAction(Request $request, Application $app)
	    {
    		return $app['twig']->render('admin/adminHome.html', array('urls' => $app['repository.content']->getContentUrls()));
    	}

	    public function adminContentAction(Request $request, Application $app)
	    {
    		$page = $app['request']->get('name');
    		
    		if(!in_array($page, $app['repository.content']->getContentUrls()))
    		{
    			$app['session']->getFlashBag()->add('message', array('type'=>'warning','txt'=>'Cette page n\'existe pas !'));
    			return $app->redirect($app['url_generator']->generate('adminhome'));
    		}

    		$contentEntity = $app['repository.content']->getContent($page);
			$form = $app['form.factory']->create(new ContentType(array('url' => $page)), $contentEntity);
			
			$form->handleRequest($request);

			if ($request->getMethod() == 'POST' && $form->isValid()) {
				$app['repository.content']->addContent($form->getData());
				$app['session']->getFlashBag()->add('message', array('type'=>'success','txt'=>'contenu mis à jour !'));
				$app->redirect($app['request']->headers->get('referer'));
			}

    		return $app['twig']->render('admin/adminModifier.html', array('page' => $page, 'form' => $form->createView()));
    	}
	}