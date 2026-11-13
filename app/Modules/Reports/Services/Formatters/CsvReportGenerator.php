<?php

namespace App\Modules\Reports\Services\Formatters;

use App\Modules\Reports\Services\ReportGenerator;
use App\Modules\Reports\Models\ReportRequest;

final class CsvReportGenerator extends ReportGenerator
{
    protected function format(array $rows, ReportRequest $request): string
    {
        $output = "id;produto;categoria;preco;estoque;data\n";
        foreach ($rows as $row) $output .= implode(';', $row)."\n";
        if ($request->includeTotal) $output .= 'TOTAL;;;;'.$this->total($rows).";\n";
        return $output;
    }
}
