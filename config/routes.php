<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(
	'/'=> 'view#index',
	'/view'=> 'view#index',
	'/view/:id'=> 'view#task',
	'/create'=> 'create#create',
	'/delete'=> 'delete#delete',
	'/edit/:id'=> 'edit#update',
);
