<?php

	$env = getenv('WEBSITE_ENV');
	$isProd = ( $env == 'prod' ? true : false );

	require_once __DIR__.'/../vendor/autoload.php';

	//if( ! $isProd )
		//Symfony\Component\Debug\Debug::enable();

	$app = new Silex\Application();
	if( $isProd )
		require __DIR__.'/../config/prod.php';
	else
		require __DIR__.'/../config/dev.php';
	require __DIR__.'/../src/app.php';
	require __DIR__.'/../src/routes.php';
	$app->run();
