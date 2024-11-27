export default function handleTheme(){
    const boxInfo = document.querySelectorAll('.info-cash-box')
    if(boxInfo.length){
      if (sessionStorage.getItem('theme') === 'dark') {
        boxInfo[0].style.background = 'linear-gradient(45deg, rgb(1 1 30), rgb(6 6 126))'
        boxInfo[1].style.background = 'linear-gradient(45deg, rgb(39 29 0), #9b6604)'
        boxInfo[2].style.background = 'linear-gradient(45deg, rgb(0 41 0), rgb(0 153 0))'
      } else {
        boxInfo[0].style.background = 'linear-gradient(45deg, rgb(3, 3, 158), blue)'
        boxInfo[1].style.background = 'linear-gradient(45deg, rgb(199, 146, 2), orange)'
        boxInfo[2].style.background = 'linear-gradient(45deg,rgb(2, 156, 2),rgb(3, 221, 3))'
      }
    }
  }