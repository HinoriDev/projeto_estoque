<?php

namespace App\Modules\Reports\Services\Factories;

use App\Modules\Reports\Services\ReportGenerator;

/** Factory Method: concrete formats decide which generator is created. */
abstract class AbstractReportOutputFactory implements ReportOutputFactory
{
    final public function createGenerator(): ReportGenerator
    {
        return $this->makeGenerator();
    }

    abstract protected function makeGenerator(): ReportGenerator;
}
