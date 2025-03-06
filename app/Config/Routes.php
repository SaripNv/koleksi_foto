<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route untuk halaman utama
$routes->get('/', 'HomeController::index');

// Group untuk admin panel
$routes->group('admin', function ($routes) {
    // Dashboard Admin
    $routes->get('/', 'AdminController::index'); // Tambahkan ini untuk akses dashboard utama

    // Routes untuk kategori
    $routes->get('categories', 'CategoriesController::index');
    $routes->get('categories/create', 'CategoriesController::create');
    $routes->post('categories/store', 'CategoriesController::store');
    $routes->get('categories/edit/(:num)', 'CategoriesController::edit/$1');
    $routes->post('categories/update/(:num)', 'CategoriesController::update/$1');
    $routes->post('categories/delete/(:num)', 'CategoriesController::delete/$1');

    // Routes untuk galeri
    $routes->get('galleries', 'GalleriesController::index');
    $routes->get('galleries/create', 'GalleriesController::create');
    $routes->post('galleries/store', 'GalleriesController::store');
    $routes->get('galleries/edit/(:num)', 'GalleriesController::edit/$1');
    $routes->post('galleries/update/(:num)', 'GalleriesController::update/$1');
    $routes->post('galleries/delete/(:num)', 'GalleriesController::delete/$1');


    // Filter galeri berdasarkan kategori & tanggal
    $routes->get('galleries/filter/category/(:num)', 'GalleriesController::filterByCategory/$1');
    $routes->get('galleries/filter/date/(:segment)', 'GalleriesController::filterByDate/$1');
});