<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Controller\{ ListarCursos, FormularioInsercao, Persistencia };

$caminho = $_SERVER['PATH_INFO'];
$rotas =  require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
}

session_start();

$classeControladora = $rotas[$caminho];
$controlador = new $classeControladora();
$controlador->processaRequisicao();
