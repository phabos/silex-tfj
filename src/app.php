<?php

	if($app['debug']){
		$app->register(new Silex\Provider\MonologServiceProvider(), $app['monolog_config']);
	}

	$app->register(new Silex\Provider\DoctrineServiceProvider());
	$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
	$app->register(new Silex\Provider\FormServiceProvider());
	$app->register(new Silex\Provider\ValidatorServiceProvider());

	$app->register(new Silex\Provider\SecurityServiceProvider());
	$app->register(new Silex\Provider\RememberMeServiceProvider());

	$app->register(new Silex\Provider\SessionServiceProvider());
	$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    	'translator.messages' => array(),
	));

	$app['asset_path'] = $app->share(function () {
    	return $app['site.root'] . '/web/webroot';
	});

	$app['galerie_upload_path'] = $app->share(function () {
    	return __DIR__.'/../web/webroot/galerie/';
	});

	$app['base_url'] = $app->share(function () {
    	return $app['site.root'] . '/web/';
	});

	$app->register(new Silex\Provider\SwiftmailerServiceProvider());
	$app['swiftmailer.options'] = array(
		'host' => 'Cus',
		'port' => 'xxx',
		'username' => 'xxx',
		'password' => 'xxx',
		'encryption' => null,
		'auth_mode' => 'login'
	);

	$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.options' => array(
			'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
			'strict_variables' => true,
		),
		'twig.path' => $app['twig.path']
	));

	$app->before(function (Symfony\Component\HttpFoundation\Request $request, Silex\Application $app) {
    	$app['twig']->addGlobal('current_page_name', $request->get("_route"));
	});

	/***************** REPO ********************/

	$app['repository.content'] = $app->share(function ($app) {
		return new TfJass\Repository\ContentRepository($app['db']);
	});

	$app['repository.concert'] = $app->share(function ($app) {
		return new TfJass\Repository\ConcertRepository($app['db']);
	});

	$app['repository.photo'] = $app->share(function ($app) {
		return new TfJass\Repository\PhotoRepository($app['db'], $app['galerie_upload_path']);
	});

	$app['repository.email'] = $app->share(function ($app) {
		return new TfJass\Repository\EmailRepository($app['db']);
	});
