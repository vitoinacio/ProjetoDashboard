export default function user() {
  const form = document.querySelectorAll('form.formUser');

  if (form.length) {
    const userDados = localStorage.getItem(localStorage.key(0));
    if (userDados) {
      const user = JSON.parse(userDados);
      form[0].querySelector('#name').value = user.nome || '';
      form[0].querySelector('#cpf').value = user.cpf || '';
      form[0].querySelector('#emailUser').value = user.email || '';
      form[0].querySelector('#nascimento').value = user.dataNasc || '';
      form[0].querySelector('#sexo').value = user.sexo || '';
      form[0].querySelector('#telefone').value = user.telefone || '';
      form[0].querySelector('#senha').value = user.senha || '';
      form[0].querySelector('#cep').value = user.cep || '';
      form[0].querySelector('#cidade').value = user.cidade || '';
      form[0].querySelector('#bairro').value = user.bairro || '';
      form[0].querySelector('#rua').value = user.rua || '';
      form[0].querySelector('#numero').value = user.endNum || '';
    } else {
      console.log('Nenhum usuário logado encontrado no Local Storage.');
    }
  }
}