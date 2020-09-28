<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alura\Cursos\Controller\{ ListarCursos, FormularioInsercao, Persistencia };

switch ($_SERVER['PATH_INFO']) {
    case '/listar-cursos':
        $controlador = new ListarCursos();
        $controlador->processaRequisicao();
        break;
    case '/novo-curso':
        $controlador = new FormularioInsercao();
        $controlador->processaRequisicao();
        break;
    case '/salvar-curso':
        $controlador = new Persistencia();
        $controlador->processaRequisicao();
            break;
    default:
        echo "Erro 404";
}
