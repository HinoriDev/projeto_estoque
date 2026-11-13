<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f4f6fb">
    <title>@yield('title', 'Painel') · TecniX</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ route('reports.index') }}" aria-label="TecniX, início">
            <span class="brand-mark">T</span>
            <span class="brand-copy"><strong>TECNIX</strong><small>gestão de produtos</small></span>
        </a>
        <nav class="main-nav" aria-label="Navegação principal">
            <a class="@yield('nav-reports')" href="{{ route('reports.index') }}"><span>▤</span>Relatórios</a>
            <a class="@yield('nav-products')" href="{{ route('products.index') }}"><span>◫</span>Produtos</a>
        </nav>
    </header>
    <main class="page">
        @if(session('status'))<div class="alert" role="status">{{ session('status') }}</div>@endif
        @if($errors->any())
            <div class="alert alert-error" role="alert"><strong>Confira os dados informados:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
    <footer class="footer">TecniX · Gestão simples para o seu catálogo</footer>
</body>
</html>
