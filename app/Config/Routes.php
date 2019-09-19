<?php namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index', ['as' => 'home', 'filter' => 'auth']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('/', ['namespace' => 'App\Controllers\Auth', 'filter' => 'guest'], function(RouteCollection $routes) {
    $routes->match(['get', 'post'], 'login', 'Authentication::index');

    $routes->get('register', 'Register::index');
    $routes->post('register', 'Register::register');
    $routes->get('register/resend', 'Register::resend');
    $routes->get('register/confirm/(:alphanum)', 'Register::confirm/$1');

    $routes->get('forgot-password', 'Password::index');
    $routes->post('forgot-password', 'Password::forgot');

    $routes->get('reset-password', 'PasswordRecovery::index');
    $routes->post('reset-password', 'PasswordRecovery::recover');
});
$routes->get('logout', 'App\Controllers\Auth\Authentication::logout', ['filter' => 'auth']);

$routes->group('master', ['namespace' => 'App\Controllers\Master', 'filter' => 'auth'], function(RouteCollection $routes) {
    $routes->resource('users');
    $routes->resource('roles');
});

//$routes->add('migrate', 'App\Controllers\Console\Migrate::index');
//$routes->add('migrate/(.+)', 'App\Controllers\Console\Migrate::$1');
$routes->get('asset/(.*)', 'App\Controllers\Asset::index');
$routes->group('migrate', ['namespace' => 'App\Controllers\Console'], function(RouteCollection $routes) {
	$routes->cli('/', 'Migrate');
	$routes->cli('rollback/(:num)', 'Migrate::rollback/$1');
	$routes->cli('init', 'Migrate::init');
	$routes->cli('destroy', 'Migrate::destroy');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
