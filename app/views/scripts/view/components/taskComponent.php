<?php

class TaskComponent{

    private string $component;
    private string $htmlPath;

    public function __construct(
        private array $task
        ){
          $this->htmlPath = dirname(__FILE__, 2) . "/components/html/";
          $this->setComponent();
          $this->render();
            
        }

        private function render(): void{
            echo $this->component;
        }

        private function setColor(string $state): string{
            return match($state){
                'pending' => 'bg-gray',
                'ongoing' => 'bg-orange',
                'done' => 'bg-green',
                default => ''
            };
        }

        private function setComponent(): void{
            $tags = "<span>" . count($this->task['tags']) > 0 ? implode("</span><span>", $this->task['tags']) : "" . "</span>";
            $color = $this->setColor($this->task['state']);
            
            $this->component = "
            <div class='$color p-6 rounded-lg flex flex-row flex-nowrap relative group/task pb-0' id='" 
            . $this->task['id'] . 
            "'><div>
            <h2 class='text-xl font-bold mb-2'>" 
            . $this->setStrLength(58, $this->task['title']) . 
            "</h2>
            <p class='mb-2 font-extralight'>" . $this->setStrLength(115, $this->task['description']) . "</p>
            <div class='font-medium text-sm flex flex-wrap gap-x-2 mb-2'>" . $tags . "</div>
            <div class='flex-col justify-between items-center'>"
            . $this->setTime() 
            . $this->setCreatedBy()
            . "</div></div>" .
            $this->setMenuViewEdit() . 
            "</div>";
}

    private function setStrLength(int $length, string $str): string{
        return (strlen($str) > $length ? substr($str, 0, $length) . "..." : $str);
    }

    private function setCreatedBy(): string{
        return "<div class='flex items-center mb-6'>
    <img src='/images/snail.svg' class='h-5 mr-2' />
    <span>" . $this->task['created_by'] . "</span>
  </div>";
    }

    private function setTime(): string{
        $start = date("d-m-Y H:i", $this->task['start_time']);
        $end = date("d-m-Y H:i", $this->task['end_time']);

        return "<div class='flex-col items-center mb-4 text-sm'>
        <p class='mr-2'><b>De:</b> " . $start . "</p>
        <p class='mr-2'><b>Fins:</b> " . $end . "</p>
      </div>";
    }

    private function setMenuViewEdit(): string{
      $component = "";
      $file = $this->htmlPath . "taskViewEditMenu.phtml";
      if(file_exists($file)){
        $component = file_get_contents($file);
        $component = str_replace('id-placeholder', $this->task['id'], $component);
      } else {
        $component = $file;
      }
        return $component;
    }
}
