<?php

namespace App\Modules\Reports\Console\Commands;

use App\Modules\Reports\Services\ReportService;
use Illuminate\Console\Command;

final class RestoreReportCsv extends Command
{
    protected $signature = 'reports:restore-csv';
    protected $description = 'Restaura o CSV de produtos arquivado.';

    public function handle(ReportService $reports): int
    {
        $restored = $reports->restoreCsv();
        $this->line($restored ? 'Relatório restaurado.' : 'Não há CSV arquivado para restaurar.');

        return $restored ? self::SUCCESS : self::FAILURE;
    }
}
