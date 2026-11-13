<?php

namespace App\Modules\Reports\Services\Formatters;

use App\Modules\Reports\Services\ReportGenerator;
use App\Modules\Reports\Models\ReportRequest;

final class HtmlReportGenerator extends ReportGenerator
{
    protected function format(array $rows, ReportRequest $request): string
    {
        $output = '<h1>'.e($request->title)."</h1>\n<table>\n<tr><th>id</th><th>produto</th><th>categoria</th><th>preço</th><th>estoque</th><th>data</th></tr>\n";
        foreach ($rows as $row) $output .= '<tr><td>'.e((string) $row['id']).'</td><td>'.e($row['produto']).'</td><td>'.e($row['categoria']).'</td><td>'.e((string) $row['preco']).'</td><td>'.e((string) $row['estoque']).'</td><td>'.e($row['data'])."</td></tr>\n";
        if ($request->includeTotal) $output .= "<tr><td colspan='3'>TOTAL</td><td>".$this->total($rows)."</td><td colspan='2'></td></tr>\n";
        return $output."</table>\n";
    }
}
