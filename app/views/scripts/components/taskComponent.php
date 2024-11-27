<?php
abstract class TaskComponent{

    private string $component;
    protected string $htmlPath;

    private string $color;

    public function __construct(
        protected array $task,
        ){
          $this->htmlPath = dirname(__FILE__, 2) . "/components/html/";
          $this->setComponent();
          $this->render();
            
        }

        private function render(): void{
            echo $this->component;
        }

        private function setComponent(): void{
            
            $this->component = "<div tabindex='0' data-state='" . $this->task['state'] ."' id='". $this->task['id'] . "' class='p-6 rounded-lg flex flex-row flex-nowrap relative group/task pb-0 focus:outline-none focus:border-purple focus:ring-2 focus:purple " . $this->handleColor() ."' onclick='getIds(\"" . $this->task['id'] . "\")'>"
            . "<div class='min-w-48'>"
            . $this->setTitle()
            . $this->setDescription()
            . $this->setTags() .
            $this->setTimeCreatedByBox() .
            "</div>" .
            $this->handleBottomBox() . 
            "</div>";
}

private function setTags(): string {
  $tags = "<span>" . count($this->task['tags']) > 0 ? implode("</span><span>", $this->task['tags']) : "" . "</span>";
  $htmlTags = "<div class='font-medium text-sm flex flex-wrap gap-x-2 mb-2'>" . $tags . "</div>";
  return $htmlTags;
}

private function setDescription(): string {
  $htmlDescription = "<p class='mb-2 font-extralight'>" . $this->setStrLength(115, $this->task['description']) . "</p>";
  return $htmlDescription;
}

private function setTitle(): string {
  $htmlTitle = "<h2 class='text-xl font-bold mb-2'>" . $this->setStrLength(58, $this->task['title']) . "</h2>";
  return $htmlTitle;
}

private function setTimeCreatedByBox(): string {
  $htmlBox = "<div class='flex-col justify-between items-center'>"
            . $this->setTime() 
            . $this->setCreatedBy()
            . "</div>";
  return $htmlBox;
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
  
  abstract function handleColor(): string;
  abstract function handleBottomBox(): string;

}
