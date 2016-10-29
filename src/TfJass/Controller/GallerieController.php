<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use TfJass\Entity\Photo;
	use TfJass\Type\PhotoType;

	class GallerieController
	{

	    public function getPhotoContent(Application $app)
	    {
	       	$photos = $app['repository.photo']->getPhotos();
    		return $app['twig']->render('photos.html', array('photos'=>$photos));	
	    }

	    /********** ADMIN STUFF *************/
	    public function adminPhotosAction(Request $request, Application $app)
	    {
    		$photos = $app['repository.photo']->getPhotos();

    		$photoEntity = new Photo();
			$form = $app['form.factory']->create(new PhotoType(), $photoEntity);
			
			$form->handleRequest($request);

			if ($request->getMethod() == 'POST' && $form->isValid()) {
				$app['repository.photo']->uploadPhoto($form->getData());
				$app['session']->getFlashBag()->add('message', array('type'=>'success','txt'=>'Photo uploadée !'));
				return $app->redirect($app['url_generator']->generate('adminphotos'));
			}

    		return $app['twig']->render('admin/adminPhotos.html', array('photos' => $photos, 'form' => $form->createView()));
    	}

    	public function adminDeletePhotosAction(Application $app, Request $request)
    	{
    		$photo = $request->attributes->get('id');
    		$app['repository.photo']->deletePhoto($photo);
    		$app['session']->getFlashBag()->add('message', array('type'=>'success','txt'=>'Photo supprimée !'));
    		return $app->redirect($app['url_generator']->generate('adminphotos'));
    	}

	}