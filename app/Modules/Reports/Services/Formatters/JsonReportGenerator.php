<?php

namespace App\Modules\Reports\Services\Formatters;

use App\Modules\Reports\Services\ReportGenerator;
use App\Modules\Reports\Models\ReportRequest;

final class JsonReportGenerator extends ReportGenerator
{
    protected function format(array $rows, ReportRequest $request): string
    {
        $data = ['titulo' => $request->title, 'itens' => $rows];
        if ($request->includeTotal) $data['total'] = $this->total($rows);
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)."\n";
    }
}
