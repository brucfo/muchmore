# muchmore
Desafio Much More

Estar utilizando o `PHP 7.4.5`

Valide se `extension=pdo_mysql` esteja habilitada.

Atualizar o _DATABASE_URL_ 
`mysql://USUARIO:SENHA@127.0.0.1:3306/DATA_BASE_NAME?serverVersion=5.7`
com os dados do seu servidor e uma database que deseja criar.

**TODOS OS PASSOS A PARTIR DESTE PONTO DEVEM SER FEITOS NA PASTA DO PROJETO
ATRAVÉS DO TERMINAL (LINHA DE COMANDO)**

Utilizar o comando `composer install`

rodar o comando `php bin\console doctrine:database:create` 

Após rodar o comando deve ser exibido a seguinte mensagem:

*Created database `NOME_DA_SUA_DATABASE` for connection named default*

Após a criação da database vamos efetuar o migration da aplicação para gerar 
as tabelas utilizando o comando:

`php bin/console doctrine:migrations:migrate`

O sistema irá te dar uma mensagem confirme com yes e deve ter uma resposta 
semelhante a abaixo:

`[notice] Migrating up to DoctrineMigrations\Version20200928115417`<br />
 `[notice] finished in 524.6ms, used 14M memory, 3 migrations executed, 4 sql queries`
 
 Significa que as tabelas para o sisetema foi criada e pronta para utilização.
 
 A pasta na qual o projeto deve rodar é a public, caso esteja rodando com 
 apache, se for rodar direto com o php executar o comando:
 
 `php -S localhost:8081 -t public`
 
 Isso irá criar um servidor local respondendo na pasta 8081 e estará disponível 
 para acesso e testes da aplicação. 
 
 Para testar a aplicação existe uma collection de POSTMAN na pasta postman, 
 nesse caso coloquei uma para cada versão do POSTMAN utilize a que você possui 
 recomendo a v2_1, você deve fazer a importação da collection para o seu 
 POSTMAN ele irá criar uma pasta chamda `muchmore` onde todos as requests 
 estão criadas.
 
 **OBS:** Apesar da criação de usuário pedir senha, não criei um sistema de 
 autenticação o foco do projeto foi o algoritmo de shortURL e as requisições 
 no padrão **_REST_** porém a senha permite que seja criado um sistema de 
 autenticação com validação de token no futuro para melhorias do projeto.
 
 Vamos aos passos:
 
  1. Crie um usário utilizando `Cadastrar-Usuario na pasta user`, repare que 
  no Body do POSTMAN vai ter um json com as informações do usuário, você 
  pode alterar para criar usuário com o nome, email e senha que quiser.
  1. Você pode listar todos os usuários criados utilizando o 
  `Listar-Todos na pasta user`
  1. Você pode buscar um usuário específico no `Buscar-por-ID na pasta user`
  1. Pode altera o nome do usuário através do `AtualizarUsuario na pasta user`
   a informação vai estar em formato json no Body do POSTMAN
  1. Para gerar uma URL CURTA utilize `Gerar dentro da pasta link`, deve ser 
  alterado o Body para poder mudar a URL que quer utilizar. OBS: Se quiser 
  um usuário anônimo deve remover o usuário do json deixando apenas o "link" 
  dessa forma será gravado como NULL o usuário que fez a requisição.
  1. Caso você queria links maiores do que apenas uma letra deve mudar o 
  auto_incremento da tabela no mysql rodando o seguinte comando no Mysql 
  Workbench `ALTER TABLE url_short AUTO_INCREMENT = 10476051;` isso altera o 
  id do auto incremto que é a base para encurtar a URL e fará com que tenha 
  pelo menos 4 caracteres
  1. Para testar o redirect recomendo apenas copiar a url encurtada e colar 
  diretamente no seu navegador, dessa forma ele irá acessar o site e 
  contabilizar +1 click no link (`Pode usar o Link Short (Redirect) no postman` 
  porém no postman as imagens não são carregadas corretamente, por isso a 
  sugestão de usar o navegador).
  1. Para as statistas dos links  se você quer saber uma url encurtada 
  específica utilize o `Stats Short Link dentro da pasta Stats` mudar o final 
  para a URL CURTA que o sistema gerou pra você `/stats/URL_GERADA`
  1. Para todos os links gerados por um usuário utilize `Stats By User` para 
  ver os links anônimos passe o 0 como id do usuário (Será pesquisados 
  usuarios NULL).
  
  Caso tenha alguma dúvida ou dificuldade em fazer a aplicação rodar, não 
  deixe de entrar em contato.
  
  A Maioria dos GETS pode mudar o parâmetro final para acessar a estatística
  do registro que o sistema recém gerou.