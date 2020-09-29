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

class Persistencia implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // pegar dados do form
        $post = $request->getParsedBody();
        $descricao = filter_var($post['descricao'], FILTER_SANITIZE_STRING);
        
        // montar modelo curso
        $curso = new Curso();
        $curso->setDescricao($descricao);
        
        $queryString = $request->getQueryParams();
        $id = filter_var($queryString['id'], FILTER_VALIDATE_INT);

        $tipo = 'success';
        if (!is_null($id) && $id !== false) {
            // Atualizar
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMessagem($tipo, 'Cursos atualizado com sucesso');
        } else {
            // criar
            // inserir no banco
            $this->entityManager->persist($curso);
            $this->defineMessagem($tipo, 'Cursos inserido com sucesso');
        }
        $this->entityManager->flush();

        return new Response(302, ['Location' => '/listar-cursos']);
    }
}