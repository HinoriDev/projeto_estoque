<?php

namespace App\Modules\Reports\Console\Commands;

use App\Modules\Reports\Services\ReportService;
use Illuminate\Console\Command;

final class ArchiveReportCsv extends Command
{
    protected $signature = 'reports:archive-csv';
    protected $description = 'Arquiva o último CSV de produtos.';

    public function handle(ReportService $reports): int
    {
        $result = $reports->archiveCsv();
        $this->line(trim($result));

        return str_starts_with($result, 'Arquivado') ? self::SUCCESS : self::FAILURE;
    }
}
