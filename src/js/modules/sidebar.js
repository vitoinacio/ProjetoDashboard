export default function sidebar(){

  const sidebar = document.querySelectorAll('.sidebar a');
  const activeClass = "active";
  const userEvents = ["click"]; 

  function activeTab(index) {
    sidebar.forEach((item) => {
      item.classList.remove(activeClass);
    });
    sidebar[index].classList.add(activeClass);
  }

  function addTabNavEvent() {
    sidebar.forEach((itemMenu, index) => {
      itemMenu.addEventListener(userEvents, () => activeTab(index));
    });
  }

  function init() {
    if (sidebar.length) {
      //ativar primeiro item
      activeTab(0);
      addTabNavEvent();
    }
  }
  init();

}