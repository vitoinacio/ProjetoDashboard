export default function login_btn() {
  const buttons = document.querySelectorAll('#loginBtn');
  if (buttons.length) {
    buttons.forEach((button) => {
      button.addEventListener('click', function () {
        document.getElementById('loginModal').style.display = 'flex';
      });
    });

    document.getElementById('closeBtn').addEventListener('click', function () {
      document.getElementById('loginModal').style.display = 'none';
    });

    window.addEventListener('click', function (event) {
      if (event.target == document.getElementById('loginModal')) {
        document.getElementById('loginModal').style.display = 'none';
      }
    });
  }
}
