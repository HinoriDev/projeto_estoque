<?php

use App\Modules\Reports\Services\Factories\CsvReportOutputFactory;
use App\Modules\Reports\Services\Factories\HtmlReportOutputFactory;
use App\Modules\Reports\Services\Factories\JsonReportOutputFactory;
use App\Modules\Reports\Services\Factories\MarkdownReportOutputFactory;
use App\Modules\Reports\Services\Factories\XmlReportOutputFactory;

return ['factories' => [
    'csv' => CsvReportOutputFactory::class,
    'html' => HtmlReportOutputFactory::class,
    'json' => JsonReportOutputFactory::class,
    'xml' => XmlReportOutputFactory::class,
    'markdown' => MarkdownReportOutputFactory::class,
]];
