<?php

class TaskComponent{

    private string $component;

    public function __construct(
        private array $task
        ){
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
            $this->component = "<div class='$color p-6 rounded-lg flex flex-row shadow mb-0 gap-y-0 pb-0 group/task' id='" . $this->task['id'] . "'><div>
<h2 class='text-xl font-bold mb-2'>" . $this->setStrLength(58, $this->task['title']) . "</h2>
<p class='mb-2 font-extralight'>" . $this->setStrLength(115, $this->task['description']) . "</p>
<div class='font-medium text-sm flex flex-wrap gap-x-2 mb-2'>" . $tags . "</div>
<div class='flex-col justify-between items-center'>"
  . $this->setTime() 
  . $this->setCreatedBy()
. "</div></div>" .
$this->sideBar() . 
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

    private function sideBar(): string{
        return "<div class='opacity-0 w-0 h-auto group-hover/task:opacity-100 group-hover/task:w-auto flex flex-col justify-end gap-y-0 mb-0'>
          <div class='flex flex-col items-center group/ver'>
<button class='bg-transparent rounded-full text-white p-2 group-hover/ver:bg-black focus:outline-none'>
      <svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6h16M4 12h16M4 18h16'></path>
          </svg>
    </button>
  <span class='mt-1 opacity-0 group-hover/ver:opacity-100 group-hover/ver:mb-4 transition-opacity'>Ver</span>
</div>
<div class='flex gap-0 m-0 p-0 flex-col items-center group/editar'>
<button class='bg-black rounded-full text-white p-2 group-hover/editar:bg-gray-800 focus:outline-none'>
      <svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 6h16M4 12h16M4 18h16'></path>
          </svg>
    </button>
  <span class='mt-1 opacity-0 group-hover/editar:opacity-100 transition-opacity group-hover/editar:mb-4'>Editar</span>
</div>
          </div>";
    }
}