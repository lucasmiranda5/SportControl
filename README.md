# SportControl
Sistema para controle de inscrição de evento eportivo do IFNMG

Sistema open source desenvolvido por Lucas Miranda para o IFNMG para ser usando no controle de inscrições do JIFENMG em qualquer etapa.

## Demos
Painel Admin: http://lucasmiranda.com.br/sportcontrol/painel Usuario: admin | senha: admin
Professor: http://lucasmiranda.com.br/sportcontrol/   Usuario: professor | Senha: professor
## Módulos

### Administrador

A administrador é dividido em:
1 - Instituição 
2 - Campus
3 - Usuários
4 - Categorias de Modalidades
5 - Modalidades
6 - Eventos
7 - Atletas
8 - Equipes
9 - Fichas de Inscrições
10 - Administradores (Em construção)

**1-Instituição**

Cadastros das instituições participantes de algum evento esportivo. ex(IFNMG, IFMG,IFBA...)

**2-Campus**

Cadastros dos campus de cada instituição.

**3-Usuários**

Usuários de cada campus, onde o mesmo pode fazer o controle dos eventos cadastrados

**4-Categorias de modalidades**

As categorias como Individual, coletivo, revezamento. Essa categoria defini se a modalidade terá ou não sub modalidade. Ex: Temos a equipe Natação composta de 10 atletas e temos as categorias como 100m peitos, 100m borboletas onde teremos 2 participantes da equipe de natação, ou sejá 100m peitos será uma supe modalidade de natação.

**5-Modalidades**

As modalidades para as eventos.

**6-Eventos**

Pode cadastrar varios eventos dentro do sistema como JIFENMG 2016, JIFENMG 2017... Dentro dela veiculamos as modalidades ao evento onde coloca a quantidade maxima de atletas para aquela modalidade e a data limite maxima inscrição.

**7-Atletas**

Faz o cadastro dos atletas para cada instituição e campus

**8-Equipes**

Víncula os atletas as modalidades

**9-Fichas de inscrição**

Onde é gerado os arquivos das fichas para cada campus e evento

**10 - Administradores**

Cadastro dos administradores do sistema

### Professor

A administrador é dividido em:

1 - Modalidades
2 - Atletas
3 - Equipes
4 - Fichas de Inscrições
5 - Perfil (Em construção)

**1-Modalidades**

Onde é possivel ver as modalidades que o campus do professor estar autorizado a cadastrar equipe para cada evento

**2-Atletas**

Faz o cadastro para o campus do professor

**3-Equipes**

Onde o professor monta cada equipe.

**4-Fichas de inscrições**

Onde o professor gera as fichas para cada evento

**5-Perfil**

Onde o professor pode alterar suas informações.

#Como instalar o sistema

O sistema foi desenvolvido todo em Laravel. Para instalar baixe os arquivos do github e de um **composer update**. Faça o upload do banco de dados onde a estrutura estar no arquivo **bancoDados.sql** e configure as informações no arquivo **config/database.php**, configure as seguintes variaveis dentro do arquivo **config/app.php** **url** onde estar http://localhost coloque a url do sistema. Depois disso de um **php artisan key:generate**

#Como colaborar

Crie uma Issue ou envie um Pull Request

