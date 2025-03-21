# CallbackReturn

Esse é um sistema de avaliações para uma feira de ciências. Os visitantes/telespectadores que estiverem conferindo as exposições poderão julgar o quanto gostaram de certo projeto, e essa nota será usada para serem criadas métricas a partir daí.

## Como funciona?

Você entra no site e seleciona a sala em que está o projeto desejado, e em seguida seleciona o projeto desejado para obter detalhes e avaliar. Para avaliar é necessário ter um cadastro breve, informando idade e sexo (essas informações serão usadas para definir se o projeto é, ou não é, popular para aquele grupo de pessoas)

## Como executo na minha máquina?

### Requisitos:

- PHP 8 (ou superior) instalado. Você pode instalar no site (https://www.php.net)
- Servidor capaz de rodar o PHP. Recomendamos o apache ou o próprio servidor embutido no PHP
- Banco de dados MYSQL

_Você atende todos os requisitos de uma vez instalando o XAMPP. Nele tem tudo o que precisamos: PHP, Servidor apache e o MYSQL_
_Você pode baixar o XAMPP pelo site (https://www.apachefriends.org/pt_br/index.html)_

### Instalando o projeto

- Se você está utilizando o XAMPP, você deve incluir o projeto na pasta _htdocs_ dentro da pasta _xampp_, se não escolhe qualquer pasta que quiser. Para isso, você pode baixar o código fonte e descompactar dentro da pasta, ou você usa o seguinte comando no terminal
  `git clone https://github.com/NickProfessor/callback-return.git`
  dentro da pasta desejada.
- Assim que o projeto for baixado corretamente, você deve importar o arquivo _.sql_ que está disponível na pasta raíz do _callback_.
  Agora, acompanhe os passos para importar os dados:

#### Importando o Banco de Dados

1. Acesse o phpMyAdmin:

   - Abra o XAMPP e inicie o servidor Apache e MySQL.
   - No navegador, vá até http://localhost/phpmyadmin/ para acessar o phpMyAdmin.

2. Crie um Banco de Dados:

   - No phpMyAdmin, clique em "Novo" na barra lateral esquerda.
   - Nomeie o banco de dados (exemplo: callback_return).
   - Selecione o collation como utf8_general_ci para garantir que caracteres especiais sejam tratados corretamente.
   - Clique em "Criar".

3. Importe o arquivo SQL:

   - Clique no banco de dados que você acabou de criar.
   - No menu superior, clique na opção "Importar".
   - Clique em "Escolher arquivo" e selecione o arquivo .sql presente na pasta raiz do seu projeto.
   - Após selecionar o arquivo, clique em "Executar" para importar a estrutura do banco de dados para o MySQL.

#### Configuração do Projeto

1. Configuração do arquivo de conexão com o banco de dados:

   - Navegue até a pasta do projeto e localize o arquivo de configuração de banco de dados (geralmente algo como _config.php_).
   - Edite esse arquivo com os dados do seu banco de dados (nome, usuário, senha). Se você estiver usando o XAMPP, os dados de acesso padrão geralmente são:
     - Host: localhost
     - Usuário: root
     - Senha: (deixe em branco, a menos que tenha configurado uma senha no MySQL)
     - Banco de Dados: O nome do banco de dados que você criou (callback_bd).

### Inicie o Servidor Local:

Se você estiver usando o servidor embutido do PHP, abra o terminal na pasta do projeto e execute o comando:

`php -S localhost:8000`

Isso iniciará o servidor PHP local na porta 8000. Acesse o site através de http://localhost:8000 no seu navegador.

Se preferir usar o Apache do XAMPP, apenas certifique-se de que o servidor Apache está rodando e acesse o projeto pelo endereço http://localhost/nome_da_pasta_do_projeto.

### E pronto, agora é só explorar as funcionalidades do site.

- Se você quiser fazer alguma observação ou encontrar algum problema, abra um issue. (Se quiser enviar uma solução, envie um pull request).

Agradecemos a sua colaboração! <3
