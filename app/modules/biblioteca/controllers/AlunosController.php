<?php
//get, add, edit, delete

namespace App\Biblioteca\Controllers;

use App\Controllers\RESTController;
use App\Biblioteca\Models\Alunos;

class AlunosController extends RESTController
{
    public function getALunos() //funciona
    {
        try {
            $aluno = (new Alunos())->find(//traz de acordo com o filtro
                [
                    'conditions' => "true" .$this->getConditions(),
                    'columns' => $this->partialFields

                ]

            );
            return $aluno->toArray(); //retorna o objeto que eu instanciei em forma de array
        } catch (\Exception $e) {
            throw new \Exception("erro");
        }
    }
    public function getALuno($matriculaAluno)
    {
        try {
            $alunos = (new Alunos())->findFirst(
                [
                    'conditions' => "matriculaAluno = '$matriculaAluno'",
                    //'columns' => $this->partialFields,
                ]
            );

            return $alunos;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    public function editAlunos($matriculaAluno)// ele esta retornando mas não estou conseguindo editar
    {
        try {
            $alunos = (new alunos())->findFirst($matriculaAluno);
            if (false === $alunos) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $put = $this->di->get('request')->getPut();
             //$autor->nome = isset($put['nome']) ? $put['nome'] : $autor->nome; //isset: verifica se a variavel ta setada ou a posição do array

            if (isset($put['idNome'])) {
                $alunos->idNome = $put['idNome'];
            }

            $alunos->saveDB();

            return $alunos;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function addAlunos() //funciona
    {
        try {
            $alunos = new Alunos();
            $alunos->idNome = $this->di->get('request')->getPost('idNome');
            $alunos->Livros_Livrosid = $this->di->get('request')->getPost('Livros_Livrosid');      //$aluno->sPhone = $this->di->get('request')->getPost('sPhone');

            $alunos->saveDB();

            return $alunos;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }


    public function deleteAlunos($matriculaAluno)// funcionando
    {
        try {
            $alunos = (new Alunos())->findFirst($matriculaAluno);

            if (false === $alunos) {
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $alunos->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
