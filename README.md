## Tutorial 

1. **Passo a Passo**
    - Primeiro abra seu Xampp e inicie o MySQL e o Apache
    - Crie um banco de dados cujo nome precisa ser `ckc_bd`


2. **Entrando no Sistema**
    - Clone esse repositório na pasta do Xampp `htdocs`
    - É IMPORTANTE que fique /htdocs/sistemackc
    - Agora é só digitar na URL `localhost/sistemackc`
    - Verifique abaixo as rotas disponives
  
OBS.: Não precisa se preocupar em Inserir o SQL das Tabelas, nosso sistema esta cuidando disso.
   

## Rotas Disponiveis
| Rota                        | Descrição                                                                                           |
|-----------------------------|-----------------------------------------------------------------------------------------------------|
| `sistemackc/`               | Esta rota é a Landing Page (index) do sistema.                                                     |
| `sistemackc/logout`         | Esta rota é responsável apenas por finalizar uma sessão. Se não estiver logado, nada acontecerá.   |
| `sistemackc/historia`       | Esta rota é responsável por mostrar a página de história no site do usuário.                        |
| `sistemackc/etapas`         | Esta rota é responsável por mostrar as etapas no site para o usuário.                                   |
| `sistemackc/usuario/{id}`   | Esta rota acessa o perfil de um usuário específico de acordo com o ID passado.                     |
| `sistemackc/usuario/login`  | Esta rota é responsável pelo Login e redireciona para o Cadastro. (Futuramente para o Esqueci minha senha) |
| `sistemackc/usuario/cadastro` | Esta rota realiza o Cadastro de um usuário no Sistema e persiste seu dado no BD.                  |
| `sistemackc/usuario/atualizar/{id}` | Esta rota atualiza as informações do perfil de um usuário de acordo com o ID passado.          |
| `sistemackc/usuario/atualizar/senha/{id}` | Esta rota atualiza a senha do usuário de acordo com o ID passado.                                 |
| `sistemackc/admtm85/menu`   | Esta rota é responsável por mostrar o menu do painel administrativo.                                |
| `sistemackc/admtm85/usuario`| Esta rota mostra a lista de usuários no painel administrativo.                                      |
| `sistemackc/admtm85/usuario/cadastrar` | Esta rota cadastra um novo usuário no painel administrativo.                                   |
| `sistemackc/admtm85/usuario/{id}` | Esta rota acessa o perfil de um usuário específico no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/usuario/atualizar/{id}` | Esta rota atualiza as informações do perfil de um usuário no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/usuario/atualizar/senha/{id}` | Esta rota atualiza a senha de um usuário no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/usuario/excluir/{id}` | Esta rota exclui um usuário do sistema no painel administrativo de acordo com o ID passado.      |
| `sistemackc/admtm85/kartodromo` | Esta rota mostra a lista de kartódromos no painel administrativo.                                    |
| `sistemackc/admtm85/kartodromo/cadastrar` | Esta rota cadastra um novo kartódromo no painel administrativo.                                   |
| `sistemackc/admtm85/kartodromo/atualizar/{id}` | Esta rota atualiza as informações de um kartódromo no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/kartodromo/excluir/{id}` | Esta rota exclui um kartódromo do sistema no painel administrativo de acordo com o ID passado.   |
| `sistemackc/admtm85/campeonato` | Esta rota mostra a lista de campeonatos no painel administrativo.                                   |
| `sistemackc/admtm85/campeonato/cadastrar` | Esta rota cadastra um novo campeonato no painel administrativo.                                   |
| `sistemackc/admtm85/campeonato/atualizar/{id}` | Esta rota atualiza as informações de um campeonato no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/campeonato/excluir/{id}` | Esta rota exclui um campeonato do sistema no painel administrativo de acordo com o ID passado.   |
| `sistemackc/admtm85/corrida` | Esta rota mostra a lista de corridas no painel administrativo.                                       |
| `sistemackc/admtm85/corrida/cadastrar` | Esta rota cadastra uma nova corrida no painel administrativo.                                      |
| `sistemackc/admtm85/corrida/atualizar/{id}` | Esta rota atualiza as informações de uma corrida no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/corrida/excluir/{id}` | Esta rota exclui uma corrida do sistema no painel administrativo de acordo com o ID passado.     |
| `sistemackc/admtm85/resultado` | Esta rota da acesso ao crud de resultados.                                       |
| `sistemackc/admtm85/resultado/cadastrar` | Esta rota cadastra um novo resultado no painel administrativo.                                      |
| `sistemackc/admtm85/resultado/atualizar/{id}` | Esta rota atualiza as informações de um resulatdo no painel administrativo de acordo com o ID passado. |
| `sistemackc/admtm85/resultado/excluir/{id}` | Esta rota exclui um resultado do sistema no painel administrativo de acordo com o ID passado.     |


## Criando novo arquivo HTML
1.
    - Abra a pasta `View` do Projeto
    - Caso esteja criando uma nova visualização para o `Usuário` basta criar um arquivo dentro da pasta Usuario, de preferencia com extensão .php
    - Caso esteja criando uma nova visualização para o `ADM`  e não tiver a pasta ADM, pode criar ela e seu arquivo HTML dentro dessa pasta
  
## Criando novo arquivo CSS
1.
    - Abra a pasta `View` do Projeto
    - Abra a pasta `CSS` 
    - Crie seu arquivo .css

## Inserindo Icones e Imagens no Site
1.
    - Abra a pasta `View` do Projeto
    - Abra a pasta `IMG` 
    - Abra a pasta `ImgSistema`
OBS.: A pasta `ImgUsuario` são as imagens que os Usuários irão salvar em seus perfis


## Tutorial de Como criar uma Rota
Nessa arquitetura foi utilizado um Array com as Routes, então usamos um Array com Chave e valor, abaixo segue explicação de como atribuir valor a uma rota criada.
1. 
    - Vá no arquivo Routes
    - Utilize o seguinte formato para adicionar uma nova rota:
    `'/caminho_da_rota' => 'pasta#Controller#função',`

    
    Por exemplo:
    '/minha_nova_rota' => 'meuController#minhaFuncao'


