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
        return $color;
      }

    
    public function handleBottomBox(): string {
        return "";
    }
    
}