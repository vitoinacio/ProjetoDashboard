window.addEventListener('scroll', function(){
  const header = document.querySelector('.header-nav');
  const distance = header.getClientRects()[0].height;
  header.classList.toggle('active', window.scrollY > distance);
})