## Tutorial 

1. **Passo a Passo**
    - Primeiro abra seu Xampp e inicie o MySQL e o Apache
    - Crie um banco de dados cujo nome é `ckc_bd`


2. **Entrando no Sistema**
    - Clone esse repositório na pasta do Xampp `htdocs`
    - É IMPORTANTE que fique /htdocs/sistemackc
    - Agora é só digitar na URL `localhost/sistemackc`
    - Verifique abaixo as rotas disponives
   

## Rotas Disponiveis
| Rota                     | Descrição                                                                                           |
|--------------------------|-----------------------------------------------------------------------------------------------------|
| `sistemackc/`            | Esta rota é a Landing Page (index) do sistema.                                                     |
| `sistemackc/logout`      | Esta rota é responsável apenas por finalizar uma sessão. Se não estiver logado, nada acontecerá.   |
| `sistemackc/kartodromo`      | Esta rota é responsável por mostrar os Kartodromos cadastrados pelo ADM   |
| `sistemackc/usuario/{id}`| Esta rota acessa o perfil de um usuário específico de acordo com o ID passado.                     |
| `sistemackc/usuario/login` | Esta rota é responsável pelo Login e redireciona para o Cadastro. (Futuramente para o Esqueci minha senha) |
| `sistemackc/usuario/cadastro` | Esta rota realiza o Cadastro de um usuário no Sistema e persiste seu dado no BD.                   |

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


## Em breve tutorial de como criar rotas (mas se precisar de alguma avisa)
