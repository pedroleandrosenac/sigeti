<?php

$router->group(null);
$router->group("/admin");

$router->get("/dashboard", "Admin\DashboardController@index");

/** Rotas de Categorias */
$router->get("/categorias", "Admin\\CategoryController@index");
$router->get("/categorias/cadastrar", "Admin\\CategoryController@create");
$router->post("/categorias/cadastrar", "Admin\\CategoryController@store");
$router->get("/categorias/editar/{id}", "Admin\\CategoryController@edit");
$router->put("/categorias/editar/{id}", "Admin\\CategoryController@update");
$router->delete("/categorias/excluir/{id}", "Admin\\CategoryController@destroy");


$router->get("/usuarios", "Admin\\UserController@index");
$router->get("/usuarios/cadastrar", "Admin\\UserController@create");
$router->post("/usuarios/cadastrar", "Admin\\UserController@store");
$router->get("/usuarios/editar/{id}", "Admin\\UserController@edit");
$router->put("/usuarios/editar/{id}", "Admin\\UserController@update");
$router->delete("/usuarios/excluir/{id}", "Admin\\UserController@destroy");