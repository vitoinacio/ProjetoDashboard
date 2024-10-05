export default function logout(){

  const btnLogout = document.querySelectorAll('#btnlogout');
  if (btnLogout.length) {

    const off = () =>{
      if (sessionStorage.getItem('logado') === 'true') {
        sessionStorage.setItem('logado', false)
        window.location = '.././../index.html'
      }
    }

    window.addEventListener('load', ()=>{
        if (sessionStorage.getItem('logado') === 'false' || sessionStorage.getItem('logado') === null) {
          window.location = '.././../index.html'
      }
    })

    btnLogout.forEach((item)=>{
      item.addEventListener('click', off)
    })
  }
}