<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Models\ReportFile;
use App\Modules\Reports\Services\Formatters\XmlReportGenerator;
use App\Modules\Reports\Services\ReportGenerator;

final class XmlReportOutputFactory extends AbstractReportOutputFactory
{
    protected function makeGenerator(): ReportGenerator
    {
        return new XmlReportGenerator();
    }

    public function createFile(): ReportFile
    {
        return new ReportFile('xml', 'application/xml');
    }
}
