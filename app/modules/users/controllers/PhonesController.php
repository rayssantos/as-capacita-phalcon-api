<?php
namespace App\Users\Controllers;

use App\Controllers\RESTController;
use App\Users\Models\Phones;

/**
 * Gerencia as requisições para o módulo admin.
 *
 * @package App\Phones\Controllers
 * @author Otávio Augusto Borges Pinto <otavio@agenciasys.com.br>
 * @copyright Softers Sistemas de Gestão © 2016
 */
class PhonesController extends RESTController
{
    /**
     * Retorna uma lista de Usuários.
     *
     * @access public
     * @return Array Lista de Usuários.
     */
    public function getPhones()
    {
        try {
            $phones = (new Phones())->find(
                [
                    'conditions' => 'true ' . $this->getConditions(),
                    'columns' => $this->partialFields,
                    'limit' => $this->limit
                ]
            );

            return $phones;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Retorna um Usuário.
     *
     * @access public
     * @return Array Usuário.
     */
    public function getPhone($iPhoneId)
    {
        try {
            $phones = (new Phones())->findFirst(
                [
                    'conditions' => "iPhoneId = '$iPhoneId'",
                    'columns' => $this->partialFields,
                ]
            );

            return $phones;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Adiciona um Usuário.
     *
     * @access public
     * @return Array Usuário.
     */
    public function addPhone()
    {
        try {
            $phone = new Phones();
            $phone->iUserId = $this->di->get('request')->getPost('iUserId');
            $phone->sPhone = $this->di->get('request')->getPost('sPhone');

            $phone->saveDB();

            return $phone;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Editar o campo de um Usuário.
     *
     * @access public
     * @return Array.
     */
    public function editPhone($iPhoneId)
    {
        try {
            $put = $this->di->get('request')->getPut();

            $phone = (new Phones())->findFirst($iPhoneId);

            if (false === $phone) {
                throw new \Exception("This record doesn't exist", 200);
            }

            $phone->iUserId = isset($put['iUserId']) ? $put['iUserId'] : $phone->iUserId;
            $phone->sPhone = isset($put['sPhone']) ? $put['sPhone'] : $phone->sPhone;

            $phone->saveDB();

            return $phone;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove um Usuário.
     *
     * @access public
     * @return boolean.
     */
    public function deletePhone($iPhoneId)
    {
        try {
            $phone = (new Phones())->findFirst($iPhoneId);

            if (false === $phone) {
                throw new \Exception("This record doesn't exist", 200);
            }

            return ['success' => $phone->delete()];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
