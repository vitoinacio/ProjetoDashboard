# SmartWallet

Este projeto é uma atividade acadêmica desenvolvida durante o curso de Análise e Desenvolvimento de Sistemas, com a colaboração de meus colegas de grupo. A aplicação web permite que os usuários adicionem, atualizem e excluam débitos. A aplicação também destaca débitos próximos do vencimento e permite marcar débitos como pagos.

## Funcionalidades

- Adicionar novos débitos
- Atualizar o status de pagamento dos débitos
- Excluir débitos
- Destacar débitos próximos do vencimento (menos de 10 dias)
- Persistência de dados no banco de dados

## Tecnologias Utilizadas

- PHP
- JavaScript
- HTML
- CSS
- MySQL

## Instalação

1. Clone o repositório para o seu ambiente local:
   ```bash git clone https://github.com/seu-usuario/seu-repositorio.git ```

2.  Navegue até o diretório do projeto:
  cd seu-repositorio

3. Configure o banco de dados MySQL:

  - Crie um banco de dados chamado gerenciamento_debitos.
  - Importe o arquivo database.sql (se houver) para criar as tabelas
  necessárias.

4. Configure a conexão com o banco de dados:

  - Edite o arquivo conexao.php com as credenciais do seu banco de dados.

5. Inicie um servidor local (por exemplo, usando o XAMPP ou WAMP) e coloque os arquivos do projeto no diretório htdocs.

6. Acesse a aplicação no navegador:
  http://localhost/seu-repositorio

  # Uso

    1. Faça login na aplicação usando suas credenciais.

    2. Navegue até a página de planejamento para gerenciar seus débitos.

    3. Adicione novos débitos preenchendo o formulário e clicando em "Adicionar".

    4. Marque débitos como pagos clicando no botão "Pago".

    5. Exclua débitos clicando no botão "Excluir".

  # Contribuição
    Se você quiser contribuir para este projeto, siga estas etapas:

    1. Faça um fork do repositório.
    2. Crie uma nova branch:

    ```git checkout -b minha-nova-funcionalidade```

    3. Faça suas alterações e commit:

    ```git commit -m 'Adiciona nova funcionalidade'```

    4. Envie para o repositório remoto:

    ```git push origin minha-nova-funcionalidade```

    5. Abra um Pull Request.

  # Licença
    Este projeto é um projeto academico e está licenciado sob a Licença MIT. Veja o arquivo LICENSE para mais detalhes.

  # Contato
    Se você tiver alguma dúvida ou sugestão, sinta-se à vontade para entrar em contato:

  - Email: [victor.hugo.ina10@gmail.com](mailto:victor.hugo.ina10@gmail.com)
  - GitHub: [vitoinacio](https://github.com/vitoinacio/)
