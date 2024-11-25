<?php

class EditController extends ApplicationController {
    public function updateAction(){
        if($this->getRequest()->isPost()){
            echo "Post requested";
        }

        $id = $this->_namedParameters['id'];
        $task = $this->database->getTask($id);
        $this->view->task = $task;
    }
}