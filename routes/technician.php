<?php

$router->group("/tecnico");
$router->get("/dashboard", "Technician\\DashboardController@index");


/** Rotas de Chamados */
$router->get("/chamados", "Technician\\TicketController@index");
$router->get("/chamados/cadastrar", "Technician\\TicketController@create");
$router->post("/chamados/cadastrar", "Technician\\TicketController@store");
$router->get("/chamados/editar/{id}", "Technician\\TicketController@edit");
$router->put("/chamados/editar/{id}", "Technician\\TicketController@update");
$router->delete("/chamados/excluir/{id}", "Technician\\TicketController@destroy");

/** Rotas de Comentários */
$router->get("/chamados/{id}/comentarios", "Technician\\TicketCommentController@index");
$router->post("/chamados/{id}/comentarios", "Technician\\TicketCommentController@store");
$router->put("/chamados/{id}/comentarios/editar/{id}", "Technician\\TicketCommentController@update");
$router->delete("/chamados/{ticket}/comentarios/excluir/{id}", "Technician\\TicketCommentController@destroy");

/** Rotas de Perfil */
$router->get("/perfil", "Technician\\ProfileController@index");
$router->post("/perfil", "Technician\\ProfileController@update");

$router->get("/seguranca", "Technician\\ProfileController@security");
$router->post("/seguranca", "Technician\\ProfileController@updatePassword");
