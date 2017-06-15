<?php
namespace App\Biblioteca\Controllers;

use App\Controllers\RESTController;
use App\Biblioteca\Models\Funcionario;

class FuncionarioController extends RESTController
{
    public function getFuncionarios()
    {
        try {
            $funcionario =  new Funcionario();//instancia objeto tipo funcionario
            $funcionarios = $funcionario->find();//busca todos os funcionarios cadastrados
            $funcionarios = $funcionarios->toArray();//converte o resultado da busca para array
                return $funcionarios;//retorna os dados que eu peguei
        } catch (\Exception $e) {
            throw new \Exception("Erro ao consultar funcionarios");
        }
    }

    public function addFuncionarios() // crio o metodo para ADICIONAR a info
    {
        try { //o try catch é utilizado para reportar um erro no codigo
            $funcionario = new Funcionario(); //instancio o objeto pela classe
            $funcionario->nomeFuncionario = $this->di->get('request')->getPost('nomeFuncionario'); // chamo atributo que eu quero como o nomeFuncionario no ex
            $funcionario->cargo = $this->di->get('request')->getPost('cargo');
            $funcionario->saveDB();//salvo os dados que eu add
                return $funcionario; //dou um return para retornar os dados que eu add
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());// envia uma mensagem de erro ao usuario(try catch)
        }
    }

    public function editFuncionarios($id)
    {
        try {
            $funcionario = (new Funcionario())->findFirst($id);
            if (false === $funcionario) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $put = $this->di->get('request')->getPut();
             //$funcionario->nomeFuncionario = isset($put['nomeFuncionario']) ? $put['nomeFuncionario'] : $funcionario->nomeFuncionario; //isset: verifica se a variavel ta setada ou a posição do array

            if (isset($put['nomeFuncionario'])) {
                $funcionario->nomeFuncionario = $put['nomeFuncionario'];
            }

            if (isset($put['cargo'])) {
                $funcionario->cargo =$put['cargo'];
            }
            $funcionario->saveDB();

            return $funcionario;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteFuncionarios($id) //metodo para deletar atributo da tabela
    {
        try {
            $funcionario = (new Funcionario())->findFirst($id); //instancia a classe objeto

            if (false === $funcionario) {  //verifica  se o tipo E o valor são iguais ao que você está querendo comparar
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $funcionario->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
