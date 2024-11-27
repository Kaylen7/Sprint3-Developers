function updateCircle() {
  const select = document.getElementById('state');
  const selectedValue = select.value;
  const circle = document.getElementById('circle');

  switch (selectedValue) {
    case 'ongoing':
      circle.className = 'w-4 h-4 bg-orange-500 rounded-full mr-2';
      break;
    case 'done':
      circle.className = 'w-4 h-4 bg-green-500 rounded-full mr-2';
      break;
    case 'pending':
      circle.className = 'w-4 h-4 bg-gray-500 rounded-full mr-2';
      break;
  }
}


function showModal(title, message, buttonText, redirect) {
  const modal = document.getElementById('modal');
  const modalBody = document.getElementById('modalBody');
  const modalTitle = document.getElementById('modalTitle');
  const buttonsContainer = document.getElementById('buttonsContainer'); 
  const closeModalButton = document.getElementById('closeModal');

  const closeModal = (redirectUrl = null) => {
    modal.classList.add('hidden');
    if (redirectUrl) window.location.href = redirectUrl;
  };

  const setModalContent = () => {
    modalTitle.textContent = title;
    modalBody.textContent = message;
    buttonsContainer.innerHTML = '';
    if (Array.isArray(buttonText) && buttonText.length === 2) {
      
      const btn1 = document.createElement('button');
      btn1.textContent = buttonText[0];
      btn1.className =
        'px-4 py-2 bg-red-400 text-white rounded hover:bg-red-500 focus:outline-none'; 
      btn1.addEventListener('click', () => {
        deleteTasks(); 
        closeModal(); 
      });
      buttonsContainer.appendChild(btn1);
    
      const btn2 = document.createElement('button');
      btn2.textContent = buttonText[1];
      btn2.className =
        'px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none'; 
      btn2.addEventListener('click', () => {
        if (redirect) closeModal(redirect);
        else closeModal();
      });
      buttonsContainer.appendChild(btn2);
    } else {
      const btn = document.createElement('button');
      btn.textContent = buttonText;
      btn.className = 'px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none'; //
      btn.addEventListener('click', () => closeModal(redirect));
      buttonsContainer.appendChild(btn);
    }
  };

  const addEventListeners = () => {
    closeModalButton.addEventListener('click', (event) => {
      event.preventDefault();
      closeModal();
    });
    window.addEventListener('click', (event) => {
      if (event.target === modal) {
        closeModal();
      }
    });
  };

  const openModal = () => {
    modal.classList.remove('hidden');
  };

  setModalContent();
  addEventListeners();
  openModal();
}

function deleteVerification(){
  if(idsToDelete.length === 0){
    showModal('Atenció', 'No has seleccionat cap tasca', 'Acepta' );
  } else{
    showModal('Atenció', 'Segur que vols eliminar la/les tasques?', ['Elimina','Cancela'] );
  }
}

const idsToDelete = [];

function getIds(id) {
  if (window.location.pathname === '/delete') {
    const element = document.getElementById(id);
    if (!idsToDelete.includes(id)) {
      idsToDelete.push(id);
      element.classList.replace('bg-white', 'bg-black');
      element.classList.add('text-white');
    } else {
      const index = idsToDelete.indexOf(id);
      if (index !== -1) {
        idsToDelete.splice(index, 1);
      }
      element.classList.replace('bg-black', 'bg-white');
      element.classList.remove('text-white');
    }
  }
}

async function deleteTasks() {
  try {
      const response = await fetch('/delete', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({ ids: idsToDelete }),
      });

      const text = await response.text(); 
      let result;
      try {
          result = JSON.parse(text); 
          showModal('Llest!', 'Tasques eliminades correctament', 'Acepta' );
          setTimeout(() => {
            location.reload();
          }, 2000);
      } catch (e) {
          throw new Error(`Error: ${text}`);
      }
      if (result.status !== 'success') {
          showModal('Atenció', `Error al eliminar tareas:${result.message}`, 'Acepta' );
      }
      
  } catch (error) {
      showModal('Atenció', `Error en la solicitud:${error}`, 'Acepta' );
  }
}

