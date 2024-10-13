export default function fontSize() {
  const fontSize = document.querySelector('#fontSizeConfig');
  const increment = document.querySelector('#increment');
  const decrement = document.querySelector('#decrement');

  const p = document.querySelectorAll('p');
  const a = document.querySelectorAll('a');
  const h3 = document.querySelectorAll('h3');
  const h4 = document.querySelectorAll('h4');
  const label = document.querySelectorAll('label');

  let tam = 18;

  if (sessionStorage.getItem('fontSize') !== null) {
    tam = parseInt(sessionStorage.getItem('fontSize'), 10);
    p.forEach((p) => {
      p.style.fontSize = `${tam}px`;
    });
    a.forEach((a) => {
      a.style.fontSize = `${tam}px`;
    });
    h3.forEach((h3) => {
      h3.style.fontSize = `${tam}px`;
    });
    h4.forEach((h4) => {
      h4.style.fontSize = `${tam}px`;
    });
    label.forEach((label) => {
      label.style.fontSize = `${tam}px`;
    });

    if (fontSize) {
      fontSize.value = tam;
    }
  }

  const updateFontSize = () => {
    p.forEach((p) => {
      p.style.fontSize = `${tam}px`;
    });
    a.forEach((a) => {
      a.style.fontSize = `${tam}px`;
    });
    h3.forEach((h3) => {
      h3.style.fontSize = `${tam}px`;
    });
    h4.forEach((h4) => {
      h4.style.fontSize = `${tam}px`;
    });
    label.forEach((label) => {
      label.style.fontSize = `${tam}px`;
    });
  };

  if (increment && decrement) {
    const fontSizeButton = (event) => {
      if (event.target.id === 'increment') {
        tam = Math.min(tam + 1, 30);
      } else if (event.target.id === 'decrement') {
        tam = Math.max(tam - 1, 18);
      }
      sessionStorage.setItem('fontSize', tam);
      updateFontSize();
    };
    increment.addEventListener('click', fontSizeButton);
    decrement.addEventListener('click', fontSizeButton);
  }

  if (fontSize) {
    const changeFont = () => {
      tam = parseInt(fontSize.value, 10);
      tam = Math.max(18, Math.min(tam, 30));
      sessionStorage.setItem('fontSize', tam);
      updateFontSize();
    };

    fontSize.addEventListener('input', changeFont);
  }
}