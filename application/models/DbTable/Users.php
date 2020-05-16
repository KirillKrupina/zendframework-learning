<?php

class Application_Model_DbTable_Users
    extends
    //Zend_Db_Table_Abstract
    Zend_Db_Table
{
    /**
     * @var Zend_Db_Table_Select
     */
    protected $select = null;
    protected $params = array();
    protected $_name = 'users';


    /**
     * @return Zend_Db_Table_Select
     */
    public function getSelect(){
        if (is_null($this->select)){
            $this->select = $this->select();
        }
        return $this->select;
    }

    public function fetchAll()
    {
        $select = $this->getSelect();
        $select->bind($this->params);
        $rows = parent::fetchAll($select);
        $rows = $rows->toArray();
        return $rows;
    }
//    public function getAllUsers($select) {
//        return $this->fetchAll()->toArray();
//    }

    public function whereUserId($id){
        $select = $this->getSelect()->where('id = :id_param');
        $this->params['id_param'] = $id;
        return $this;
    }

    public function whereFullnameLike($fullname){
        $fullname =  '%' . $fullname . '%';
        $this->getSelect()->where('fullname like :fullnameLikeParam');
        $this->params['fullnameLikeParam'] = $fullname;
        return $this;
    }

    public function whereBirthdayLike($birthday) {
        // changing format from 'm/d/Y' to 'Y-m-d'
        $birthday = date('Y-m-d', strtotime($birthday));

        $this->getSelect()->where('birthday like :birthdayLikeParam');
        $this->params['birthdayLikeParam'] = $birthday;
        return $this;
    }

    public function whereUserNumber($number) {
        $this->getSelect()->where('number = :number_param');
        $this->params['number_param'] = $number;
        return $this;
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

