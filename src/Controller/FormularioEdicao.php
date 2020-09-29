<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Helper\FlashMessageTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;

class FormularioEdicao implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait, FlashMessageTrait;

    private $repositorioDeCursos;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryString = $request->getQueryParams();
        $id = filter_var($queryString['id'], FILTER_VALIDATE_INT);

        if (is_null($id) || $id === false) {
            $this->defineMessagem('danger', 'ID do curso invalido');
            return new Response(302, ['Location' => '/listar-cursos']);
        }

        $curso = $this->repositorioDeCursos->find($id);

        $html = $this->renderizaHtml('cursos/formulario.php', [
            'curso' => $curso,
            'titulo' => 'Alterar curso ' . $curso->getDescricao(),
        ]);

        return new Response(200, [], $html);
    }
}