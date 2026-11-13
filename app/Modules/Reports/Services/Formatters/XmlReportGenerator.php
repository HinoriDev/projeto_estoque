<?php

namespace App\Modules\Reports\Services\Formatters;

use App\Modules\Reports\Services\ReportGenerator;
use App\Modules\Reports\Models\ReportRequest;

final class XmlReportGenerator extends ReportGenerator
{
    protected function format(array $rows, ReportRequest $request): string
    {
        $xml = new \SimpleXMLElement('<relatorio/>');
        $xml->addChild('titulo', htmlspecialchars($request->title, ENT_XML1));
        $items = $xml->addChild('itens');
        foreach ($rows as $row) {
            $item = $items->addChild('produto');
            foreach ($row as $key => $value) $item->addChild($key, htmlspecialchars((string)$value, ENT_XML1));
        }
        if ($request->includeTotal) $xml->addChild('total', (string)$this->total($rows));
        return $xml->asXML() ?: '';
    }
}
