<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Models\ReportFile;
use App\Modules\Reports\Services\Formatters\JsonReportGenerator;
use App\Modules\Reports\Services\ReportGenerator;

final class JsonReportOutputFactory extends AbstractReportOutputFactory
{
    protected function makeGenerator(): ReportGenerator
    {
        return new JsonReportGenerator();
    }

    public function createFile(): ReportFile
    {
        return new ReportFile('json', 'application/json');
    }
}
