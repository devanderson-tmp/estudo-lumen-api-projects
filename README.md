# Projects API
Projeto pessoal de estudo, cuja finalidade é salvar projetos em um banco de dados.

## Project
### Project schema
| Campo | Tipo | Descrição |
| --- | --- | --- |
| id  | int  | O id do projeto |
| image | string | Link para a imagem do projeto |
| title | string | O título do projeto |
| description | string | A descrição do projeto |
| repo | string | Link para o repositório do projeto |
| demo | string | Link para o site do projeto |
| languages | array | Lista de tecnologias usadas no projeto |

### Requests
Acesse a lista de todos os projetos usando o endpoint `/projects`
```
GET https://devanderson-projetos.herokuapp.com/api/projects
```

Visualize um único projeto adicionando o id como um parâmetro `/projects/1`
```
GET https://devanderson-projetos.herokuapp.com/api/projects/1
```

Todas as respostas retornarão dados em `json`.
