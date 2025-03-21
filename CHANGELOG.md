## [2.0] - 2025-03-21

### Alterado

- Todos os registros do banco foram apagados, com exceção dos registros da tabela tema

- A tabela de integrantes foi modificada e teve o nome alterado para 'aluno'

- Todas as tabelas que sofrerão alterações de dados agora possuem duas colunas: "data_registro" e "data_atualizacao". É importante ter ciência do momento em que certas operações são realizadas.

- A tabela de usuários foi modificada para incluir novas colunas: 'email', 'foto', 'tipo_usuario', 'ativo', 'data_registro', 'data_atualizacao':

  - A coluna 'email' foi adicionada para permitir a autenticação de usuários através do endereço de e-mail.
  - A coluna 'foto' foi adicionada para guardar o caminho da foto do usuário. Agora o usuário poderá ter uma foto de perfil.
  - A coluna 'tipo_usuario' foi adicionada para diferenciar os tipos de usuários e atribuir permissões específicas no sistema (01-Comum, 02-Administrador, 03-Aluno, 04-Professor).
  - A coluna 'ativo' foi necessária para que não seja preciso excluir um usuário, apenas desativá-lo (1-ativo ou 0-inativo)
  - A coluna 'data_registro' foi criado em todas as tabelas que terão alterações de dados, isso é, para ter um controle melhor do que está acontecendo no sistema e banco
  - A coluna 'data_atualizacao' foi criado com o mesmo propósito, a diferença é que essa coluna é alterada SEMPRE que o registro sofre alteração, diferente da 'data_registro' que só armazena o momento que o registro é criado.

- A tabela 'aluno' foi modificada para incluir novas colunas: 'ra', 'rm', 'turma', 'serie', 'curso', 'ativo', 'id_usuario':

  - A coluna 'ra' será utilizada para armazenar o registro acadêmico do aluno.
  - A coluna 'rm' será utilizada para armazenar o registro de matrícula do aluno.
  - A coluna 'turma' será utilizada para informar a qual turma o aluno pertence
  - A coluna 'serie' será utilizada para informar a qual serie o aluno pertence
  - A coluna 'curso' será utilizada para informar a qual curso o aluno pertence. (se participar de algum curso)
  - A coluna 'ativo' será utilizado para informar a situação atual do aluno em relação ao sistema, se a conta está criada ou foi excluída.
  - A coluna 'id_usuário' serve para referenciar que usuário aquele aluno representa, já que todo aluno é um usuário no sistema.

- A tabela 'projeto_has_tema' teve o nome alterado para 'tema_has_projeto', para manter o padrão de nomes.

- A contagem de auto_increment de todas as tabelas foi zerada

### Adicionado

- A tabela 'pergunta' foi criada para armazenar as perguntas que serão questionadas ao avaliador com relação ao projeto apresentado/exposto. A tabela conta com uma coluna específica 'ordem' para que o administrador possa definir a ordem das perguntas.

- A tabela 'resposta' foi criada para armazenar as respostas informadas pelo avaliador para cada pergunta da tabela 'pergunta'. A tabela conta com as seguintes colunas: 'id_resposta', 'id_avaliacao', 'id_pergunta', 'versao_pergunta_texto', 'resposta', 'tipo_resposta'

  - A coluna 'id_resposta' serve para identificar unicamente cada resposta
  - A coluna 'id_avaliacao' serve para identificar a qual avaliação a reposta pertence
  - A coluna 'versao_pergunta_texto' guarda a versão da pergunta no momento em que a pessoa respondeu, para evitar possiveis conflitos futuramente, caso o administrador queira alterar a pergunta.
  - A coluna 'resposta' armazena a respsota dada propriamente dita
  - A coluna 'tipo_resposta' tem como objetivo identificar se a resposta é numérica ou texto.

- A tabela 'mensagem' foi criada para armazenar as mensagens que transitaram de administradores/professores para alunos. Essa tabela conta com as seguintes colunas: 'id_mensagem', 'id_remetente', 'tipo_remetente', 'id_destinatario', 'titulo', 'conteudo', 'data_envio', 'lida':

  - A coluna 'id_mensagem' serve para identificar unicamnete uma mensagem
  - A coluna 'id_remetente' refere-se a quem está enviando a mensagem
  - A coluna 'id_destinatario' refere-se a quem receberá a mensagem
  - A coluna 'titulo' armazena o texto que será apresentado como título da mensagem
  - A coluna 'conteudo' armazena o texto com a mensagem propriamente dita
  - A coluna 'data_envio' serve para registrar o momento em que a mensagem foi enviada
  - A coluna 'lida' serve para identificar se o aluno leu ou não a mensagem (0-Não, 1-sim)

- Agora o usuário será identificado pelo email.
- Ao logar, ou cadastrar, o usuário já define uma sessão.
- Uma nova classe 'SessionManager' foi criada, isso para armazenar todas as funcionalidades necessárias sobre sessão
- Como forma de teste, foram criados 3 páginas que só permitem determinado tipo de usuário
- Foi adicionado um log que registra toda interação com o banco de dados através do sistema
- Agora o usuário do tipo administrador pode adicionar usuários do tipo aluno. Todo usuário do tipo aluno é registrado na tabela 'aluno'

### Removido

- O ID não é mais exibido para o usuário, e foram removidas as telas que exibiam o ID.
- Tudo que envolve sala, ou qualquer local em que o projeto está sendo apresentado, foi removido do projeto.
