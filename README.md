# TecniX — Cadastro de Produtos e Relatórios

Aplicação web em Laravel para cadastrar produtos, manter preço e estoque e gerar relatórios filtrados. A interface permite cadastrar, editar e excluir produtos. Os relatórios podem ser baixados em CSV, HTML, JSON, XML ou Markdown.

## Requisitos

- PHP 8.3 ou superior, com PDO SQLite; a extensão SimpleXML é necessária para exportar XML.
- Composer.
- Laravel 13 (instalado pelas dependências do projeto).

## Instalação local

Na pasta do projeto, instale as dependências:

```powershell
composer install
```

Crie o arquivo `.env` a partir do exemplo, se ainda não existir, configure a chave e prepare o SQLite:

```powershell
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate
if (-not (Test-Path database/database.sqlite)) { New-Item -ItemType File -Path database/database.sqlite | Out-Null }
php artisan migrate
```

Inicie o servidor local:

```powershell
php artisan serve
```

Abra o endereço exibido pelo Artisan, normalmente `http://127.0.0.1:8000`. A aplicação usa SQLite por padrão, conforme `DB_CONNECTION=sqlite` no `.env.example`. O arquivo do banco local é ignorado pelo Git; as migrations criam as tabelas em uma instalação nova.

## Como usar a aplicação

### Cadastro de produtos

Acesse `/produtos` ou escolha **Produtos** na navegação. O formulário cadastra:

- Nome do produto.
- Categoria.
- Preço com até duas casas decimais.
- Quantidade em estoque, como número inteiro não negativo.

Os dados existentes aparecem na tabela. Edite os campos diretamente e clique em **Salvar** para atualizar. Use **Excluir** para remover um item. As validações são executadas pelo `ProductService`.

### Relatórios

Acesse `/` ou escolha **Relatórios**. Informe o formato e, se necessário, um título, categoria, período, ordenação e totalizador. **Gerar e baixar relatório** aplica os filtros aos produtos cadastrados e entrega o arquivo.

- CSV é salvo em `out/produtos.csv`.
- HTML, JSON, XML e Markdown são salvos em `storage/app/reports/` com nomes únicos.
- O totalizador soma os preços unitários dos produtos incluídos no relatório.
- **Arquivar CSV** move `out/produtos.csv` para `arquivo/produtos.csv`.
- **Restaurar último** devolve o CSV arquivado ao diretório `out/` durante a sessão atual.

Os formatos também podem ser gerados no terminal pelos comandos Artisan:

```powershell
php artisan reports:generate csv --include-total
php artisan reports:generate json --category="Bebidas" --sort=preco --descending
php artisan reports:generate csv --from=2026-01-01 --to=2026-12-31 --title="Inventário anual"
```

Opções disponíveis: `--title`, `--category`, `--from`, `--to`, `--sort`, `--descending` e `--include-total`. Os campos aceitos em `--sort` são `id`, `produto`, `categoria`, `preco`, `estoque` e `data`.

Para arquivar ou restaurar o último CSV pelo terminal:

```powershell
php artisan reports:archive-csv
php artisan reports:restore-csv
```

Os comandos Artisan usam o mesmo `ReportService` da interface web. Não é necessário executar comandos de geração para iniciar o servidor.

## Arquitetura MVCS

A aplicação mantém as camadas comuns do Laravel e organiza as funcionalidades em módulos:

- **Model:** representa os dados e os objetos do módulo. `Product` é o model Eloquent da tabela `products`; `toReportRow()` apresenta os dados no formato usado pelos relatórios. `ReportRequest` guarda as opções validadas de uma geração.
- **View:** contém a interface Blade em `resources/views`. `layouts/app.blade.php` compartilha cabeçalho e mensagens; `products/index.blade.php` e `reports/index.blade.php` são as telas dos módulos. `public/css/app.css` define o visual responsivo.
- **Controller:** recebe a requisição web, chama o service adequado e devolve a view, redirecionamento ou download. Controllers dos módulos ficam em `app/Modules/<Modulo>/Http/Controllers`.
- **Service:** concentra validação e regras de negócio. `ProductService` faz operações de cadastro; `ReportService` filtra e transforma produtos, monta o pedido e executa a geração.

A base compartilhada está em `app/Services/BaseService`. Os services dos módulos herdam dela as operações comuns de consulta e persistência. O método `buildWith()` permite configurar e executar um Builder fornecido pelo módulo.

### Organização dos módulos

```text
app/
  Services/
    BaseService.php
  Modules/
    Products/
      Models/Product.php
      Services/ProductService.php
      Http/Controllers/ProductController.php
    Reports/
      Models/ReportRequest.php
      Services/ReportService.php
      Services/ReportRequestBuilder.php
      Services/ReportGenerator.php
      Services/Formatters/
      Services/Factories/
      Console/Commands/
resources/views/
  layouts/app.blade.php
  products/index.blade.php
  reports/index.blade.php
public/css/app.css
routes/web.php
```

`routes/web.php` é a entrada central das rotas web; cada rota encaminha para o controller do módulo correspondente. As telas dos módulos ficam agrupadas na camada global de views do Laravel.

## Padrões de projeto em PHP

Os padrões abaixo são classes próprias em PHP. O projeto usa Laravel para roteamento, persistência, validação, views e Artisan; não usa o Query Builder do Laravel como implementação do padrão Builder.

### Builder

`ReportRequestBuilder` cria `ReportRequest` passo a passo. Métodos fluentes definem formato, dados, período, categoria, ordenação e destino. `build()` valida a consistência final antes de devolver o pedido. `BaseService::buildWith()` configura o Builder e chama seu `build()`.

### Template Method

`ReportGenerator::generate()` define a sequência invariável: filtrar, ordenar, formatar e salvar. Cada formatter em `Services/Formatters` implementa somente o formato de saída. Para incluir outro formato, crie uma subclasse de `ReportGenerator`.

### Factory Method e Abstract Factory

`ReportOutputFactory` define a família de objetos compatíveis para um formato: o gerador e os metadados do arquivo (extensão e tipo de conteúdo). `AbstractReportOutputFactory` expõe o Factory Method `makeGenerator()`, implementado pelas fábricas concretas, como `CsvReportOutputFactory` e `JsonReportOutputFactory`. O mapeamento das fábricas fica em `config/reports.php`.

### Artisan

A geração, o arquivamento e a restauração pelo terminal são comandos Laravel Artisan em `app/Modules/Reports/Console/Commands`. Cada comando delega ao `ReportService`, mantendo a regra de negócio no service e a integração de terminal na camada Console.

## Rotas principais

| Método | Caminho | Função |
|---|---|---|
| GET | `/` | Tela de relatórios |
| POST | `/reports` | Gera e baixa um relatório |
| POST | `/reports/archive-csv` | Arquiva o CSV atual |
| POST | `/reports/undo` | Restaura o CSV na sessão atual |
| GET | `/produtos` | Lista e cadastra produtos |
| POST | `/produtos` | Cadastra produto |
| PUT | `/produtos/{product}` | Atualiza produto |
| DELETE | `/produtos/{product}` | Exclui produto |

## Arquivos locais e logs

- `.env`: configuração local; não deve ser enviado ao Git.
- `database/database.sqlite`: banco local; ignorado pelo Git.
- `out/`: CSV corrente.
- `arquivo/`: CSV arquivado.
- `storage/app/reports/`: demais relatórios gerados.
- `storage/logs/laravel.log`: log da aplicação.
