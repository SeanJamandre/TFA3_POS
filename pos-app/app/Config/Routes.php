<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->setAutoRoute(false);
$routes->get('/', static fn() => redirect()->to(site_url('customers')));
foreach (['customers', 'users'] as $kind) {
    $routes->get($kind, 'Accounts::index/'.$kind);
    $routes->get($kind.'/new', 'Accounts::form/'.$kind);
    $routes->post($kind, 'Accounts::save/'.$kind, ['filter' => 'csrf']);
    $routes->get($kind.'/(:num)/edit', 'Accounts::form/'.$kind.'/$1');
    $routes->post($kind.'/(:num)', 'Accounts::save/'.$kind.'/$1', ['filter' => 'csrf']);
}
