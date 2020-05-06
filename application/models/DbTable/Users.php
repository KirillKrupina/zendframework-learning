<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    public function getAllUsers() {
        return $this->fetchAll()->toArray();
    }

    public function addUser(array $data) {
        $this->insert($data);
        return $this->getDefaultAdapter()->lastInsertId();
    }

    public function updateUserById(array $data, $id){
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);
    }

    public function deleteUserWithMaxId() {
        $query = $this->select()->from($this->_name, 'MAX(id) AS last');

        // fetchRow - извлечение одной строки.
        $id = $this->fetchRow($query)->last;
        $this->delete('id = ' . $id);
    }


}

