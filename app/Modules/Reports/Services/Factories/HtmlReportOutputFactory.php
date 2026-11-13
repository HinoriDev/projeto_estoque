<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Models\ReportFile;
use App\Modules\Reports\Services\Formatters\HtmlReportGenerator;
use App\Modules\Reports\Services\ReportGenerator;

final class HtmlReportOutputFactory extends AbstractReportOutputFactory
{
    protected function makeGenerator(): ReportGenerator
    {
        return new HtmlReportGenerator();
    }

    public function createFile(): ReportFile
    {
        return new ReportFile('html', 'text/html; charset=UTF-8');
    }
}
