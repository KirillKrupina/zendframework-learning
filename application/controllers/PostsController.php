<?php

class PostsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $postsModel = new Application_Model_DbTable_Posts();

        // Select ALL data from DB
        //$data = $postsModel->fetchAll()->toArray();

        // Select data by ID
        //$data = $postsModel->find(3)->toArray();

        // $data = $postsModel->fetchAll('id = 3 OR id = 7')->toArray();
        // $data = $postsModel->fetchAll(null, 'text DESC')->toArray();
        // $data = $postsModel->fetchAll(null, null, 5, 2)->toArray();

        //$this->view->posts = $postsModel->getSqlSafe();
        //$this->view->posts = $postsModel->countPosts();

        $newPost = array(
            'text' => 'New Lorem Ipsum'
        );

        $lastId = $postsModel->insertNewPost($newPost);
        $this->view->lastId = $lastId;

        $this->view->posts = $postsModel->joinTables();
    }


}

