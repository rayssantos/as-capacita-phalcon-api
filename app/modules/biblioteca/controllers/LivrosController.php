<?php


namespace App\Biblioteca\Controllers;

use App\Controllers\RESTController;
use App\Biblioteca\Models\Livros;

class LivrosController extends RESTController
{
    public function getLivros() //funciona
    {
        //     try {
    //         $livro = (new Livros())->find(//traz de acordo com o filtro
    //          [
    //             'conditions' => "true" .$this->getConditions(),
    //             'columns' => $this->partialFields

    //          ]

    //         );
    //         return $livro->toArray(); //retorna o objeto que eu instanciei em forma de array
    //     } catch (\Exception $e) {
    //         throw new \Exception("erro");
    //     }
        try {
            $query = new \Phalcon\Mvc\Model\Query\Builder(); //name space da classe builder
            $query->addFrom('\App\Biblioteca\Models\Livros', 'livro')
            ->columns(
              //'livros.*
              [
                  'livro.titulo',
                  'livro.idLivros',
                  'autor.nome',


              ]
            )
           //->innerJoin('\App\Biblioteca\Models\funcio', 'livros.Autor_idAutor = autor.idAutor', 'autor')
           //->innerJoin('\App\Biblioteca\Models\Alunos', 'alunos.matriculaAluno = biblio.id_idAluno', 'alunos')
            ->innerJoin('\App\Biblioteca\Models\Autor', 'livro.Autor_idAutor = autor.idAutor', 'autor');
           //->innerJoin('\App\Biblioteca\Models\Alunos', 'alunos.matriculaAluno = biblio.id_idAluno', 'alunos');

            return $query
            ->getQuery()
            ->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getLivro($idLivros)
    {
        try {
            $livros = (new Livros())->findFirst(
                [
                    'conditions' => "idLivros = '$idLivros'",
                    //'columns' => $this->partialFields,
                ]
            );

            return $livros;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    public function addLivro()
    {
        try {
            $livrosModel = new Livros();
           // $livrosModel->idLivros= $this->di->get('request')->getPost('idLivros');
            $livrosModel->titulo = $this->di->get('request')->getPost('titulo');
            $livrosModel->Autor_idAutor=$this->di->get('request')->getPost('Autor_idAutor');

            $livrosModel->saveDB();

            return $livrosModel;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    public function editLivros($idLivros)
    {
        try {
            $livro = (new Livros())->findFirst($idLivros);
            if (false === $livro) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $put = $this->di->get('request')->getPut();
        //$livro->idEmprestimo = isset($put['idEmprestimo']) ? $put['idEmprestimo'] : $livro->idEmprestimo; //isset: verifica se a variavel ta setada ou a posição do array

           // if (isset($put['idLivros'])) {
               // $livro->idLivros = $put['idLivros']
            //}
            if (isset($put['Autor_idAutor'])) {
                $livro->Autor_idAutor = $put['Autor_idAutor'];
            }

            if (isset($put['titulo'])) {
                $livro->titulo =$put['titulo'];
            }

            $livro->saveDB();

            return $livro;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    public function deleteLivros($idLivros) //metodo para deletar atributo da tabela
    {
        try {
            $livro = (new Livros())->findFirst($idLivros); //instancia a classe objeto

            if (false === $livro) {  //verifica  se o tipo E o valor são iguais ao que você está querendo comparar
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $livro->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
