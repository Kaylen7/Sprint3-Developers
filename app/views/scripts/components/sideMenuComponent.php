<?php

class sideMenuComponent {

    const HTMLPATH = (__DIR__ . '/html');
    
    public function __construct(
        private string $use
    ){
        echo '<div autofocus role="menu" class="bg-white text-black p-6 flex flex-col justify-between border-r-2 mt-10">';
        include_once(match($use){
            'back' => self::HTMLPATH . '/sideMenuGoBack.html',
            default => self::HTMLPATH . '/sideMenuActionsFilters.html'
        });
        echo '</div>';
    }
}