<?php

namespace App\Modules\Reports\Models;

final readonly class ReportFile
{
    public function __construct(
        public string $extension,
        public string $contentType,
    ) {}
}
