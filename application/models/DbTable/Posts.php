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
                        ->from(array('p'=> 'posts'), array('p.text'))
                        ->join(array('c' => 'comments'),'p.id = c.post_id', array('c.id AS comment_id', 'c.comments', 'c.post_id'));

        return $this->fetchAll($query)->toArray();
    }

}

