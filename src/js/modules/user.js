export default function user() {
  const form = document.querySelectorAll('form.formUser');
  const key = sessionStorage.getItem('logedUser');

  if (form.length && key !== null) {
    const userDados = localStorage.getItem(key);
    if (userDados) {
      const user = JSON.parse(userDados);

      // Função para mascarar CPF
      const mascararCPF = (cpf) => {
        if (cpf.length < 12) return cpf; // Verifica se o CPF tem pelo menos 12 caracteres
        return cpf.slice(0, 3) + '*********' + cpf.slice(12);
      };

      form[0].querySelector('#nome').value = user.nome || '';
      form[0].querySelector('#cpf').value = mascararCPF(user.cpf) || '';
      form[0].querySelector('#emailUser').value = user.emailUser || '';
      form[0].querySelector('#dataNasc').value = user.dataNasc || '';
      form[0].querySelector('#sexo').value = user.sexo || '';
      form[0].querySelector('#telefone').value = user.telefone || '';
      form[0].querySelector('#senha').value = user.senha || '';
      form[0].querySelector('#cep').value = user.cep || '';
      form[0].querySelector('#cidade').value = user.cidade || '';
      form[0].querySelector('#bairro').value = user.bairro || '';
      form[0].querySelector('#rua').value = user.rua || '';
      form[0].querySelector('#endNum').value = user.endNum || '';

      // Exibir foto de perfil se existir
      if (user.fotoPerfil) {
        const imgElement = document.querySelectorAll('#fotoPerfil');
        imgElement.forEach((img)=>{
          img.src = user.fotoPerfil;
          img.alt = 'Foto de Perfil';
        })
      }

      // Adicionar evento de upload de foto
      const fotoInput = document.querySelector('#fotoPerfilInput');
      if (fotoInput) {
        const fotoPerfil = document.querySelectorAll('#fotoPerfil')
        fotoInput.addEventListener('change', (event) => {
          const file = event.target.files[0];
          const reader = new FileReader();
          reader.onloadend = () => {
            const base64String = reader.result;
            user.fotoPerfil = base64String;
            localStorage.setItem(key, JSON.stringify(user));
            if (fotoPerfil.length) {
              fotoPerfil.forEach((img)=>{
                img.src = base64String
              })
            }
          };
          reader.readAsDataURL(file);
        });
      }
    } else {
      console.log('Nenhum usuário logado encontrado no Local Storage.');
    }
  }
}