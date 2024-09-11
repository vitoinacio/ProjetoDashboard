export default function sidebar() {
  const sidebar = document.querySelectorAll(".sidebar a");
  let path = window.location.pathname.split("/").pop();
  const activeClass = "active";
  const userEvents = ["click"];

  function activeTab() {
    sidebar.forEach((item) => {
      const href = item.href.split("/").pop().replace("#", "");
      path == href
        ? item.classList.add(activeClass)
        : item.classList.remove(activeClass);
    });
  }

  function addTabNavEvent() {
    sidebar.forEach((itemMenu) => {
      itemMenu.addEventListener(userEvents, () => activeTab());
    });
  }

  function init() {
    if (sidebar.length) {
      //ativar primeiro item
      activeTab();
      addTabNavEvent();
    }
  }
  init();
}
