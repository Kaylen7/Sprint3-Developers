<?php

class ViewController extends ApplicationController{

    public function indexAction(){
        $tasks = $this->database->getAll();
        $this->view->tasks = $tasks;
    }

    public function taskAction(){
        $id = $this->_namedParameters['id'];
        $this->view->task = $this->database->getTask($id);
    }
}