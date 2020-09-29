<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
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

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

$classeControladora = $rotas[$caminho];
$container = require __DIR__ . '/../config/dependencies.php';
$controlador = $container->get($classeControladora);
$resposta = $controlador->handle($request);

foreach ($resposta->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $resposta->getBody();
