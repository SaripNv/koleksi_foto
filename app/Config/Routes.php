<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('/', 'HomeController::index');

// Auth Routes
$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/register', 'AuthController::register');
    $routes->post('/register', 'AuthController::registerProcess');
    $routes->get('/login', 'AuthController::login');
    $routes->post('/login', 'AuthController::loginProcess');
    $routes->get('/logout', 'AuthController::logout');
});

// Dashboard Routes (Protected by auth)
$routes->group('dashboard', ['filter' => 'auth', 'namespace' => 'App\Controllers'], function ($routes) {
    
    // Common Routes (All roles)
    $routes->get('/', 'DashboardController::index');
    
    // Profile Management (All roles)
    $routes->group('profile', function($routes) {
        $routes->get('/', 'ProfileController::index', ['as' => 'profile']);
        $routes->get('edit', 'ProfileController::edit', ['as' => 'profile.edit']);
        $routes->post('update', 'ProfileController::update', ['as' => 'profile.update']);
        $routes->post('upload-photo', 'ProfileController::uploadPhoto', ['as' => 'profile.upload-photo']);
        $routes->post('change-password', 'ProfileController::changePassword', ['as' => 'profile.change-password']);
    });
    
    // Admin Only Routes (Protected by adminAuth)
    $routes->group('', ['filter' => 'adminAuth'], function($routes) {
        // Categories
        $routes->group('categories', function($routes) {
            $routes->get('/', 'CategoriesController::index');
            $routes->get('create', 'CategoriesController::create');
            $routes->post('store', 'CategoriesController::store');
            $routes->get('edit/(:num)', 'CategoriesController::edit/$1');
            $routes->match(['post', 'put'], 'update/(:num)', 'CategoriesController::update/$1');
            $routes->match(['post', 'delete'], 'delete/(:num)', 'CategoriesController::delete/$1');
        });
        
        // Galleries
        $routes->group('galleries', function($routes) {
            $routes->get('/', 'GalleriesController::index');
            $routes->get('create', 'GalleriesController::create');
            $routes->post('store', 'GalleriesController::store');
            $routes->get('edit/(:num)', 'GalleriesController::edit/$1');
            $routes->match(['post', 'put'], 'update/(:num)', 'GalleriesController::update/$1');
            $routes->match(['post', 'delete'], 'delete/(:num)', 'GalleriesController::delete/$1');
            $routes->get('filter/category/(:num)', 'GalleriesController::filterByCategory/$1');
            $routes->get('filter/date/(:segment)', 'GalleriesController::filterByDate/$1');
        });

         // User Management
        $routes->group('users', function($routes) {
            $routes->get('/', 'UsersController::index', ['as' => 'users.index']);
            $routes->get('create', 'UsersController::create', ['as' => 'users.create']);
            $routes->post('store', 'UsersController::store', ['as' => 'users.store']);
            $routes->get('(:num)/edit', 'UsersController::edit/$1', ['as' => 'users.edit']);
            $routes->post('(:num)/update', 'UsersController::update/$1', ['as' => 'users.update']);
            $routes->post('(:num)/toggle-status', 'UsersController::toggleStatus/$1', ['as' => 'users.toggle-status']);
            $routes->post('(:num)/delete', 'UsersController::delete/$1', ['as' => 'users.delete']);
        });
    });
});