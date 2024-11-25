<?php
function renderStateComponent($state)
{
    $circleColorClass = '';
    $status = '';

    switch ($state) {
        case 'ongoing':
            $circleColorClass = 'bg-[#FFC76C]';
            $status = 'En curs';
            break;
        case 'done':
            $circleColorClass = 'bg-[#6FC685]';
            $status = 'Acabada';
            break;
        case 'pending':
            $circleColorClass = 'bg-[#D9D9D9]';
            $status = 'Pendent';
            break;
    }
    
    echo <<<HTML
    <span class="flex">
        <div id="circle-container" class="flex justify-between items-center pointer-events-none">
            <span id="circle" class="w-4 h-4 $circleColorClass rounded-full mr-2"></span>
        </div>
        $status
    </span>
    HTML;
}
?>
