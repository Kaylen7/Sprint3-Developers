<?php

class ViewController extends ApplicationController{

    public function indexAction(){
        $tasks = $this->database->getAll();
        $this->view->tasks = $tasks;
    }

    public function taskAction()
    {
      $id = $this->_namedParameters['id'] ?? null;
      $task = $this->database->getTask($id);  

      extract([
        'task' => $task,
        'sidebarIncluded' => true, //My sidebar was duplicated, with this line I am avoiding it
    ]);

    include __DIR__ . "/../views/scripts/view/task.phtml";
    }

}