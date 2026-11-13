<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Models\ReportFile;
use App\Modules\Reports\Services\Formatters\CsvReportGenerator;
use App\Modules\Reports\Services\ReportGenerator;

final class CsvReportOutputFactory extends AbstractReportOutputFactory
{
    protected function makeGenerator(): ReportGenerator
    {
        return new CsvReportGenerator();
    }

    public function createFile(): ReportFile
    {
        return new ReportFile('csv', 'text/csv; charset=UTF-8');
    }
}
