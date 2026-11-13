<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Models\ReportFile;
use App\Modules\Reports\Services\ReportGenerator;

/** Abstract Factory for a compatible report formatter and download file. */
interface ReportOutputFactory
{
    public function createGenerator(): ReportGenerator;
    public function createFile(): ReportFile;
}
