<?php

class Application_Model_DbTable_Posts extends Zend_Db_Table_Abstract
{

    protected $_name = 'posts';

    public function getSqlSafe() {
        $query = $this->select()
                        ->from($this->_name, array('text'))
                      //->where('id = ?', 1)
                      //->orWhere('id = ?', 2)
                        ->order('text DESC')
                        ->limit(3, 3);

        return $this->fetchAll($query)->toArray();
    }

    public function countPosts() {
        $query = $this->select()
                      ->from($this->_name, 'COUNT(id) AS number');

        return $this->fetchRow($query)->number;
    }

    public function joinTables() {
        $query = $this->select()
                        ->setIntegrityCheck(false)
                        ->from(array('p'=> 'posts'), array('p.id','p.text'))
                        ->joinLeft(array('c' => 'comments'),'p.id = c.post_id', array('c.id AS comment_id', 'c.comments', 'c.post_id'));

        return $this->fetchAll($query)->toArray();
    }

    public function insertNewPost(array $data) {
        $this->insert($data);

        return $this->getDefaultAdapter()->lastInsertId();
    }

    public function updatePostById(array $data, $id){

        // Нужно сохранить запрос от SQL инъекций. Для это нужно вызвать метод "quoteIntro", чтоб отфильтровать и обработать отдельную переменную
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id); // возвращает уже обработанную строку...
        // $where .= " AND ";
        // $where .= $this->getDefaultAdapter()->quoteInto('active = ?', 1);

        $this->update($data, $where);
    }

    public function deletePostById($id) {
        $where = $this->getDefaultAdapter()->quoteInto('id = ?', $id);
        $this->delete($where);
    }

    public function myQuery() {
        $this->getDefaultAdapter()->query("ALTER TABLE posts ADD date TIMESTAMP");
    }


}

