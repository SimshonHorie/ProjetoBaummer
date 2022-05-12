antes de começar a utilizar o sistema, você deve criar a virtualhost do site:

Cole o conteúdo do arquivo vhost(está no github) na seguinte pasta:

C:\xampp\apache\conf\extra\httpd-vhosts.conf

E em seguida vá até:
C:\Windows\System32\drivers\etc\hosts

e copie e cole o seguinte comando:
127.0.0.1		www.projetotarefas.com.br

renomeie a pasta do projeto no xampp para "projetotarefas"

Após isso vá na pasta "Banco de Dados" e cole o Sql no phpMyAdmin

As classes do projeto se encontram em "\vendor\dist\src"

No campo cpf, coloquei apenas cpf válidos, portanto, tem que ir no site gerador de cpf, para poder validar e conseguir fazer o cadastro
