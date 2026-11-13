@extends('layouts.app')

@section('title', 'Produtos')
@section('nav-products', 'active')

@section('content')
<section class="page-heading">
    <div><p class="eyebrow">Catálogo</p><h1>Produtos</h1><p class="description">Cadastre e mantenha os itens que alimentam seus relatórios.</p></div>
    <div class="heading-stat"><strong>{{ $products->count() }}</strong><span>produto{{ $products->count() === 1 ? '' : 's' }}<br>no catálogo</span></div>
</section>

<section class="panel">
    <div class="panel-heading"><span class="panel-icon">＋</span><div><h2>Novo produto</h2><p>Preencha os dados para adicionar um item ao catálogo.</p></div></div>
    <form class="product-form" method="post" action="{{ route('products.store') }}">
        @csrf
        <div class="field"><label for="name">Nome do produto</label><input id="name" name="name" placeholder="Ex.: Café especial" value="{{ old('name') }}" required></div>
        <div class="field"><label for="category">Categoria</label><input id="category" name="category" placeholder="Ex.: Bebidas" value="{{ old('category') }}" required></div>
        <div class="field"><label for="price">Preço (R$)</label><input id="price" type="number" name="price" placeholder="0,00" min="0" step="0.01" value="{{ old('price') }}" required></div>
        <div class="field"><label for="stock">Estoque</label><input id="stock" type="number" name="stock" placeholder="0" min="0" step="1" value="{{ old('stock', 0) }}" required></div>
        <button class="btn btn-primary" type="submit">＋ Cadastrar</button>
    </form>
</section>

<section class="panel">
    <div class="panel-heading"><span class="panel-icon">◫</span><div><h2>Catálogo de produtos</h2><p>Edite os campos diretamente e salve suas alterações.</p></div></div>
    <div class="table-wrap"><table>
        <thead><tr><th>Produto</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr></thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td><form id="update-{{ $product->id }}" method="post" action="{{ route('products.update', $product) }}">@csrf @method('PUT')</form><input class="table-input product-name-input" form="update-{{ $product->id }}" aria-label="Nome do produto" name="name" value="{{ $product->name }}" required></td>
                <td><input class="table-input" form="update-{{ $product->id }}" aria-label="Categoria" name="category" value="{{ $product->category }}" required></td>
                <td><input class="table-input" form="update-{{ $product->id }}" aria-label="Preço" type="number" name="price" min="0" step="0.01" value="{{ $product->price }}" required></td>
                <td><input class="table-input" form="update-{{ $product->id }}" aria-label="Estoque" type="number" name="stock" min="0" step="1" value="{{ $product->stock }}" required></td>
                <td><div class="table-actions"><button class="btn btn-primary btn-small" form="update-{{ $product->id }}">Salvar</button><form method="post" action="{{ route('products.destroy', $product) }}">@csrf @method('DELETE')<button class="btn btn-danger btn-small" onclick="return confirm('Remover este produto?')">Excluir</button></form></div></td>
            </tr>
        @empty
            <tr><td class="empty-state" colspan="5"><span class="empty-icon">◫</span><strong>Nenhum produto cadastrado</strong><br>Use o formulário acima para adicionar o primeiro produto.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</section>
@endsection
