<?php
include_once('taskComponent.php');
include_once('interfaces/ColorInterface.php');

class stateTask extends taskComponent {

    public function __construct(
        protected array $task,
        private ColorInterface $colorInterface
    ){
        parent::__construct($task);
    }

    public function handleColor(): string {
        $color = $this->colorInterface->setColor($this->task['state']);
        return $color;
      }

    
    public function handleBottomBox(): string {
        $component = "";
        $file = $this->htmlPath . "taskViewEditMenu.html";
        if(file_exists($file)){
          $component = file_get_contents($file);
          $component = str_replace('id-placeholder', $this->task['id'], $component);
        } else {
          $component = $file;
        }
          return $component;
    }
    
}