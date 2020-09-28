<?php 

use Alura\Cursos\Controller\{ 
    ListarCursos,
    FormularioInsercao,
    Persistencia,
    Exclusao
};

 return [
    '/listar-cursos' => ListarCursos::class,
    '/novo-curso' => FormularioInsercao::class,
    '/salvar-curso' => Persistencia::class,
    '/excluir-curso' => Exclusao::class,
];
