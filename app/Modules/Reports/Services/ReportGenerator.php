<?php

namespace App\Modules\Reports\Services;

use App\Modules\Reports\Models\ReportRequest;

abstract class ReportGenerator
{
    final public function generate(ReportRequest $request): string
    {
        $rows = array_values(array_filter($request->sales, function (array $item) use ($request): bool {
            return (!$request->startDate || $item['data'] >= $request->startDate)
                && (!$request->endDate || $item['data'] <= $request->endDate)
                && (!$request->category || $item['categoria'] === $request->category);
        }));
        if ($request->sortBy) {
            $field = $request->sortBy;
            usort($rows, fn (array $a, array $b): int => ($request->descending ? -1 : 1) * ($a[$field] <=> $b[$field]));
        }
        $output = $this->format($rows, $request);
        if ($request->path) {
            $directory = dirname($request->path);
            if (!is_dir($directory)) mkdir($directory, 0777, true);
            file_put_contents($request->path, $output);
        }
        if ($request->sendEmail) echo "[EMAIL] enviando relatório para {$request->emailDestination}\n";
        return $output;
    }

    abstract protected function format(array $rows, ReportRequest $request): string;
    protected function total(array $rows): float { return array_sum(array_column($rows, 'preco')); }
}
