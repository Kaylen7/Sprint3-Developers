<?php 

include_once('taskComponent.php');
include_once('interfaces/ColorInterface.php');

class deleteModeTask extends taskComponent {

    public function __construct(
        protected array $task,
        private ColorInterface $colorInterface
    ){
        parent::__construct($task);
    }

    public function handleColor(): string {
        $color = $this->colorInterface->setColor('inactive');
        $htmlColor = "<div class='$color p-6 rounded-lg flex flex-row flex-nowrap relative group/task pb-0' id='" 
                  . $this->task['id'] . 
                  "'>";
        return $htmlColor;
      }

    
    public function handleBottomBox(): string {
        return "";
    }
    
}