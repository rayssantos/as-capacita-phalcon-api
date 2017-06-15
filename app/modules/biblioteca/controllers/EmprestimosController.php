<?php


namespace App\Biblioteca\Controllers;

use App\Controllers\RESTController;
use App\Biblioteca\Models\Emprestimos;

class EmprestimosController extends RESTController
{
    public function getEmprestimos()
    {
        try {
            $query = new \Phalcon\Mvc\Model\Query\Builder(); //name space da classe builder
            $query->addFrom('\App\Biblioteca\Models\Emprestimos', 'emprestimo')
            ->columns(
                //'livros.*
                [
                    'livro.idLivros',
                    'alunos.matriculaAluno',
                    'funcionario.idFuncionario',
                    'funcionario.nomeFuncionario',
                    'emprestimo.dataEmprestimo',
                    'emprestimo.Aluno_idAluno',
                    'emprestimo.idEmprestimo',
                    'emprestimo.Livro_idLivro',
                    'emprestimo.id_funcionario'
                ]
            )

            ->innerJoin('\App\Biblioteca\Models\Livros', 'emprestimo.Livro_idLivro = livro.idLivros', 'livro')
            ->innerJoin('\App\Biblioteca\Models\Funcionario', 'emprestimo.id_funcionario = funcionario.idFuncionario', 'funcionario')
            ->innerJoin('\App\Biblioteca\Models\Alunos', 'emprestimo.Aluno_idAluno = alunos.matriculaAluno', 'alunos');



            return $query
            ->getQuery()
            ->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function addEmprestimos() // crio o metodo para ADICIONAR a info
    {
        try { //o try catch é utilizado para reportar um erro no codigo
            $emprestimo = new Emprestimos; //instancio o objeto pela classe
            $emprestimo->Aluno_idAluno = $this->di->get('request')->getPost('Aluno_idAluno'); // chamo atributo que eu quero como o idEmprestimo no ex
            $emprestimo->dataEmprestimo = $this->di->get('request')->getPost('dataEmprestimo');
            $emprestimo->Livro_idLivro = $this->di->get('request')->getPost('Livro_idLivro');
            $emprestimo->id_funcionario = $this->di->get('request')->getPost('id_funcionario');
            $emprestimo->saveDB();//salvo os dados que eu add
                return $emprestimo; //dou um return para retornar os dados que eu add
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());// envia uma mensagem de erro ao usuario(try catch)
        }
    }
    public function editEmprestimos($id)
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
