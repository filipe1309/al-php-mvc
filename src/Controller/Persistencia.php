<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Helper\FlashMessageTrait;

class Persistencia implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function processaRequisicao(): void
    {
        // pegar dados do form
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

        // montar modelo curso
        $curso = new Curso();
        $curso->setDescricao($descricao);


        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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

        header('Location: /listar-cursos', true, 302);
    }
}