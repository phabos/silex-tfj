<?php

	namespace TfJass\Controller;

	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;

	class AdminUserController
	{

		public function loginAction(Request $request, Application $app){
			return $app['twig']->render('login.html', array(
		        'error'         => $app['security.last_error']($request),
		        'last_username' => $app['session']->get('_security.last_username'),
	    	));
    	}

    	/*private function generatePassword(Application $app){
    		$token = $app['security']->getToken();
    		if (null !== $token) {
    			$user = $token->getUser();
			}
    		$encoder = $app['security.encoder_factory']->getEncoder($user);
			$password = $encoder->encodePassword('tfjass159753', $user->getSalt());

			return $password;
    	}*/
	}