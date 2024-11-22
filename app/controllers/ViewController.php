<?php

class ViewController extends ApplicationController{

    public function indexAction(){
        $tasks = $this->database->getAll();
        $this->view->tasks = $tasks;
    }

    public function taskAction()
    {
      $id = $this->_namedParameters['id'] ?? null;
      if ($id === null) {
        $this->renderView('error', ['message' => "El parámetro 'id' es obligatorio."]);
        return;
    }
    
        $task = $this->database->getTask($id);
  
        if (empty($task)) {
          $this->renderView('error', ['message' => "La tarea no existe."]);
          return;
      }      
      $this->renderView('task', ['task' => $task]);
    }
    
    protected function renderView(string $view, array $data = []) {
      extract($data);

      $viewPath = realpath(__DIR__ . "/../views/scripts/view/$view.phtml");
      if ($viewPath && file_exists($viewPath)) {
          include $viewPath;
      }
    }
}