<?php

namespace App\Modules\Reports\Services\Formatters;

use App\Modules\Reports\Services\ReportGenerator;
use App\Modules\Reports\Models\ReportRequest;

final class MarkdownReportGenerator extends ReportGenerator
{
    protected function format(array $rows, ReportRequest $request): string
    {
        $output = '# '.$request->title."\n\n| ID | Produto | Categoria | Preço | Estoque | Data |\n|---:|---|---|---:|---:|---|\n";
        foreach ($rows as $row) $output .= '| '.$row['id'].' | '.$row['produto'].' | '.$row['categoria'].' | '.$row['preco'].' | '.$row['estoque'].' | '.$row['data']." |\n";
        if ($request->includeTotal) $output .= "\n**Total:** ".$this->total($rows)."\n";
        return $output;
    }
}
