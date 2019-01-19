<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\OCCWeb\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
	   ['name' => 'occ#index', 'url' => '/', 'verb' => 'GET'],
	   ['name' => 'occ#cmd', 'url' => '/cmd', 'verb' => 'POST'],
     ['name' => 'occ#list', 'url' => '/cmd', 'verb' => 'GET'],
    ]
];
