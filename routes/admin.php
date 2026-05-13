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

/** Rotas de Escolas */
$router->get("/escolas", "Admin\\SchoolController@index");
$router->get("/escolas/cadastrar", "Admin\\SchoolController@create");
$router->post("/escolas/cadastrar", "Admin\\SchoolController@store");
$router->get("/escolas/editar/{id}", "Admin\\SchoolController@edit");
$router->put("/escolas/editar/{id}", "Admin\\SchoolController@update");
$router->delete("/escolas/excluir/{id}", "Admin\\SchoolController@destroy");

/** Rotas de Usuários */
$router->get("/usuarios", "Admin\\UserController@index");
$router->get("/usuarios/cadastrar", "Admin\\UserController@create");
$router->post("/usuarios/cadastrar", "Admin\\UserController@store");
$router->get("/usuarios/editar/{id}", "Admin\\UserController@edit");
$router->put("/usuarios/editar/{id}", "Admin\\UserController@update");
$router->delete("/usuarios/excluir/{id}", "Admin\\UserController@destroy");
