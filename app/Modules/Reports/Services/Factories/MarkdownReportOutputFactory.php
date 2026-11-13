<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Models\ReportFile;
use App\Modules\Reports\Services\Formatters\MarkdownReportGenerator;
use App\Modules\Reports\Services\ReportGenerator;

final class MarkdownReportOutputFactory extends AbstractReportOutputFactory
{
    protected function makeGenerator(): ReportGenerator
    {
        return new MarkdownReportGenerator();
    }

    public function createFile(): ReportFile
    {
        return new ReportFile('md', 'text/markdown; charset=UTF-8');
    }
}
