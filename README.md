# muchmore
Desafio Much More

Primeiro deve ser alterado o _DATABASE_URL_ no arquivo __.env__, configuraçoes como usuario, senha, ip do mysql, porta  e database.

Como esse processo é uma API REST não estou fazendo telas, portanto para testar as rotas pode ser utilizado o **POSTMAN** a collection para importação está na pasta postman, o
servidor será configurado na porta 8081 para reduzir a chance de ter que editar as URL's do postman.O comando para isso é **php -S localhost:8081 -t public** (precisa estar dentro da pasta dfo projeto).

o PHP utilizado na aplicação foi o PHP 7.4.5 por causa do composer é importante usar a mesma versão do PHP.

Valide se _extension=pdo_mysql_ esteja habilitada, rodar o comando **_php bin\console doctrine:database:create_** dentro da pasta do projeto ou criar a database usando o Workbench.

Para rodar os testes execute os seguinte comando:
<br /> **php bin/phpunit --colors** (dentro da pasta do projeto)

Mais conteudo
