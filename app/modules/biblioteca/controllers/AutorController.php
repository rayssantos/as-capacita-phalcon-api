<?php
namespace App\Biblioteca\Controllers;

use App\Controllers\RESTController;
use App\Biblioteca\Models\Autor;

class AutorController extends RESTController
{
    public function getAutores()
    {
        try {
            $autor =  new Autor();//instancia objeto tipo autor
            $autores = $autor->find();//busca todos os autores cadastrados
            $autores = $autores->toArray();//converte o resultado da busca para array
            return $autores;//retorna os dados que eu peguei
        } catch (\Exception $e) {
            throw new \Exception("Erro ao consultar autores");
        }
    }

    public function addAutores() // crio o metodo para ADICIONAR a info
    {
        try { //o try catch é utilizado para reportar um erro no codigo
            $autor = new Autor(); //instancio o objeto pela classe
            $autor->nome = $this->di->get('request')->getPost('nome'); // chamo atributo que eu quero como o nome no ex
            $autor->dataNasc = $this->di->get('request')->getPost('dataNasc');
            $autor->generoAutor = $this->di->get('request')->getPost('generoAutor');
            $autor->saveDB();//salvo os dados que eu add
                return $autor; //dou um return para retornar os dados que eu add
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());// envia uma mensagem de erro ao usuario(try catch)
        }
    }

    public function editAutores($id)
    {
        try {
            $autor = (new Autor())->findFirst($id);
            if (false === $autor) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $put = $this->di->get('request')->getPut();
             //$autor->nome = isset($put['nome']) ? $put['nome'] : $autor->nome; //isset: verifica se a variavel ta setada ou a posição do array

            if (isset($put['nome'])) {
                $autor->nome = $put['nome'];
            }
            if (isset($put['dataNasc'])) {
                $autor->dataNasc = $put['dataNasc'];
            }

            if (isset($put['generoAutor'])) {
                $autor->generoAutor =$put['generoAutor'];
            }
            $autor->saveDB();

            return $autor;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteAutores($id) //metodo para deletar atributo da tabela
    {
        try {
            $autor = (new Autor())->findFirst($id); //instancia a classe objeto

            if (false === $autor) {  //verifica  se o tipo E o valor são iguais ao que você está querendo comparar
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $autor->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
