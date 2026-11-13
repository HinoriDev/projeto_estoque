@extends('layouts.app')

@section('title', 'Relatórios')
@section('nav-reports', 'active')

@section('content')
<section class="page-heading">
    <div><p class="eyebrow">Visão geral</p><h1>Relatórios</h1><p class="description">Filtre o catálogo e exporte os dados no formato que você precisa.</p></div>
</section>

<section class="panel">
    <div class="panel-heading"><span class="panel-icon">▤</span><div><h2>Configurar relatório</h2><p>Escolha o formato e os filtros para gerar seu arquivo.</p></div></div>
    <form method="post" action="{{ route('reports.generate') }}">
        @csrf
        <div class="report-grid">
            <div class="field"><label for="format">Formato do arquivo</label><select id="format" name="format"><option value="csv" @selected(old('format', 'csv') === 'csv')>CSV — planilha</option><option value="html" @selected(old('format') === 'html')>HTML — página web</option><option value="json" @selected(old('format') === 'json')>JSON — dados</option><option value="xml" @selected(old('format') === 'xml')>XML — dados estruturados</option><option value="markdown" @selected(old('format') === 'markdown')>Markdown — texto</option></select></div>
            <div class="field"><label for="title">Título do relatório</label><input id="title" name="title" value="{{ old('title', 'Relatório de produtos') }}" placeholder="Ex.: Estoque de novembro"></div>
            <div class="field"><label for="start_date">Data inicial</label><input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}"></div>
            <div class="field"><label for="end_date">Data final</label><input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}"></div>
            <div class="field"><label for="category">Categoria</label><input id="category" name="category" value="{{ old('category') }}" placeholder="Todas as categorias"></div>
            <div class="field"><label for="sort_by">Ordenar por</label><select id="sort_by" name="sort_by"><option value="">Sem ordenação</option><option value="data" @selected(old('sort_by') === 'data')>Data de cadastro</option><option value="preco" @selected(old('sort_by') === 'preco')>Preço</option><option value="estoque" @selected(old('sort_by') === 'estoque')>Estoque</option><option value="produto" @selected(old('sort_by') === 'produto')>Nome do produto</option></select></div>
            <div class="check-row span-2">
                <label class="check-card"><input type="checkbox" name="descending" value="1" @checked(old('descending'))><span class="check-copy"><strong>Ordem decrescente</strong><small>Exibe do maior para o menor</small></span></label>
                <label class="check-card"><input type="checkbox" name="include_total" value="1" @checked(old('include_total'))><span class="check-copy"><strong>Incluir total de preços</strong><small>Adiciona a soma ao final do relatório</small></span></label>
            </div>
            <div class="field span-2"><button class="btn btn-primary report-submit" type="submit">↓ &nbsp; Gerar e baixar relatório</button></div>
        </div>
    </form>
    <p class="report-note">O arquivo será salvo e baixado automaticamente após a geração.</p>
</section>

<section class="utility-panel">
    <div class="utility-copy"><span class="utility-icon">↗</span><span><strong>Arquivo CSV de produtos</strong><small>Arquive ou restaure o último CSV gerado.</small></span></div>
    <div class="utility-actions">
        <form method="post" action="{{ route('reports.archive') }}">@csrf<button class="btn btn-secondary" type="submit">Arquivar CSV</button></form>
        <form method="post" action="{{ route('reports.undo') }}">@csrf<button class="btn btn-secondary" type="submit">Restaurar último</button></form>
    </div>
</section>
@endsection
