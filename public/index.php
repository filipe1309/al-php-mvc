<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Controller\{ ListarCursos, FormularioInsercao, Persistencia };

$caminho = $_SERVER['PATH_INFO'];
$rotas =  require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    http_response_code(404);
    exit();
}

// Use before any output to the browser (because this info will be sent with the request/response)
session_start();

$ehRotaDeLogin = stripos($caminho, 'login');
if (!isset($_SESSION['logado']) && $ehRotaDeLogin === false) {
    header('Location: /login');
    exit();
}

$classeControladora = $rotas[$caminho];
$controlador = new $classeControladora();
$controlador->processaRequisicao();
