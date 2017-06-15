<?php


namespace App\Biblioteca\Controllers;

use App\Controllers\RESTController;
use App\Biblioteca\Models\Biblioteca;

class BibliotecaController extends RESTController
{
    public function getBibliotecas()
    {
        try {
            $query = new \Phalcon\Mvc\Model\Query\Builder(); //name space da classe builder
            $query->addFrom('\App\Biblioteca\Models\Biblioteca', 'biblio')
            ->columns(
                //'livros.*
                [
                    //'livros.titulo',
                    //'livros.Autor_idAutor',
                    //'livros.idLivros',
                    //'autor.idAutor',
                    //'autor.nome',
                    'alunos.idNome',
                    'alunos.Livros_Livrosid',
                    'alunos.matriculaAluno',
                    'biblio.idBiblio',
                    'biblio.cnpjBiblio',
                    'biblio.enderecoBiblio',
                    'biblio.id_idAluno'
                    //'func.idFuncionario'
                    //'func.nomeFuncionario'

                ]
            )
            //->innerJoin('\App\Biblioteca\Models\funcio', 'livros.Autor_idAutor = autor.idAutor', 'autor')
            //->innerJoin('\App\Biblioteca\Models\Alunos', 'alunos.matriculaAluno = biblio.id_idAluno', 'alunos')
            ->leftJoin('\App\Biblioteca\Models\Alunos', 'alunos.matriculaAluno = biblio.id_idAluno', 'alunos')
            //->innerJoin('\App\Biblioteca\Models\Alunos', 'alunos.matriculaAluno = biblio.id_idAluno', 'alunos');
            ->where('true');

            return $query
            ->getQuery()
            ->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function addBiblioteca()
    {
        // crio o metodo para ADICIONAR a info

        try { //o try catch é utilizado para reportar um erro no codigo
            $Biblioteca = new Biblioteca; //instancio o objeto pela classe
            $Biblioteca->cnpjBiblio = $this->di->get('request')->getPost('cnpjBiblio'); // chamo atributo que eu quero como o idEmprestimo no ex
            $Biblioteca->enderecoBiblio = $this->di->get('request')->getPost('enderecoBiblio');
            $Biblioteca->id_idAluno = $this->di->get('request')->getPost('id_idAluno');
            $Biblioteca->saveDB();//salvo os dados que eu add
            return $Biblioteca; //dou um return para retornar os dados que eu add
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());// envia uma mensagem de erro ao usuario(try catch)
        }
    }
    public function editBiblioteca($id)
    {
        try {
            $emprestimo = (new Emprestimos())->findFirst($id);
            if (false === $emprestimo) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $put = $this->di->get('request')->getPut();
        //$emprestimo->idEmprestimo = isset($put['idEmprestimo']) ? $put['idEmprestimo'] : $emprestimo->idEmprestimo; //isset: verifica se a variavel ta setada ou a posição do array

            if (isset($put['idEmprestimo'])) {
                $emprestimo->idEmprestimo = $put['idEmprestimo'];
            }
            if (isset($put['Aluno_idAluno'])) {
                $emprestimo->Aluno_idAluno = $put['Aluno_idAluno'];
            }

            if (isset($put['dataEmprestimo'])) {
                $emprestimo->dataEmprestimo =$put['dataEmprestimo'];
            }

            if (isset($put['Livros_Livrosid'])) {
                $emprestimo->id_funcionario=$put['id_funcionario'];
            }
            $emprestimo->saveDB();

            return $emprestimo;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
    public function deleteEmprestimos($id) //metodo para deletar atributo da tabela
    {
        try {
            $emprestimo = (new Emprestimos())->findFirst($id); //instancia a classe objeto

            if (false === $emprestimo) {  //verifica  se o tipo E o valor são iguais ao que você está querendo comparar
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $emprestimo->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
