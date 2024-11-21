const btns = document.getElementsByTagName('button');
const taskGrid = document.getElementById('task-grid');
const tasks = taskGrid.querySelectorAll('div[data-state]');
const search = document.getElementById('search');

for(let i = 0; i < btns.length; i++){
    btns[i].addEventListener('click', () => {
    if(btns[i].id === 'all'){
        const allTasksHTML = [...tasks].map(task => task.outerHTML).join('');
        taskGrid.innerHTML = allTasksHTML;
    } else {
        const filtered = [...tasks].filter(task => task.getAttribute('data-state') === btns[i].id);
        const filteredHTML = filtered.map(task => task.outerHTML).join('');
        taskGrid.innerHTML = filteredHTML;
    }
    })
}

search.addEventListener('keypress', (e) => {
    if(e.key === 'Enter' && e.target.value != ''){
        const searched = [...tasks].filter(task => {
            const match = e.target.value.toLowerCase();
            return (
                task.querySelectorAll('h2')[0].innerHTML.toLowerCase().match(`${match}(.+)?`) ||
                task.querySelectorAll('p')[0].innerHTML.toLowerCase().match(`${match}(.+)?`)
            )
        });
        console.log(searched);
        const searchedHTML = searched.map(task => task.outerHTML).join('');
        taskGrid.innerHTML = searchedHTML;
    } else {
        const allTasksHTML = [...tasks].map(task => task.outerHTML).join('');
        taskGrid.innerHTML = allTasksHTML;
    }
})