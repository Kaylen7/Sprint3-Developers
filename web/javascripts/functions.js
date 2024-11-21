function updateCircle() {
  const select = document.getElementById('state');
  const selectedValue = select.value;
  const circle = document.getElementById('circle');

  switch (selectedValue) {
      case 'ongoing':
          circle.className = 'w-2 h-2 bg-orange-500 rounded-full mr-2';
          break;
      case 'completed':
          circle.className = 'w-2 h-2 bg-green-500 rounded-full mr-2';
          break;
      case 'pending':
          circle.className = 'w-2 h-2 bg-gray-500 rounded-full mr-2';
          break;
  }
}

// Message is the message to display in the modal, title is the title of the modal, buttonText is the text of the button, redirect is a boolean to redirect to home or not

function showModal(message, title, buttonText, redirect) {
  const modal = document.getElementById('modal');
  const modalBody = document.getElementById('modalBody');
  const modalTitle = document.getElementById('modalTitle');
  const closeModalButton = document.getElementById('closeModal');
  const closeBtn = document.getElementById('closeBtn');

  const setModalContent = () => {
    modalTitle.textContent = title;
    modalBody.textContent = message;
    closeBtn.textContent = buttonText;
  };

  const closeModal = () => {
    modal.classList.add('hidden');
    if(redirect) window.location.href='/';
    
  }

  const addEventListeners = () => {
    closeModalButton.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);
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



