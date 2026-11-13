<?php

namespace App\Modules\Reports\Console\Commands;

use App\Modules\Reports\Services\ReportService;
use Illuminate\Console\Command;

final class GenerateReport extends Command
{
    protected $signature = 'reports:generate
        {format : csv, html, json, xml ou markdown}
        {--title= : Título do relatório}
        {--category= : Filtrar por categoria}
        {--from= : Data inicial}
        {--to= : Data final}
        {--sort= : Campo de ordenação}
        {--descending : Ordenar em ordem decrescente}
        {--include-total : Incluir o total dos preços}';

    protected $description = 'Gera um relatório dos produtos cadastrados.';

    public function handle(ReportService $reports): int
    {
        $result = $reports->generate([
            'format' => $this->argument('format'),
            'title' => $this->option('title'),
            'category' => $this->option('category'),
            'start_date' => $this->option('from'),
            'end_date' => $this->option('to'),
            'sort_by' => $this->option('sort'),
            'descending' => $this->option('descending'),
            'include_total' => $this->option('include-total'),
        ]);

        $this->info('Relatório gerado: '.$result['path']);
        return self::SUCCESS;
    }
}
