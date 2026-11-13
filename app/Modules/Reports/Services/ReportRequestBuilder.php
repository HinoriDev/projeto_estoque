<?php

namespace App\Modules\Reports\Services;

use App\Modules\Reports\Models\ReportRequest;

final class ReportRequestBuilder
{
    private array $values = [
        'format' => null, 'sales' => [], 'startDate' => null, 'endDate' => null,
        'category' => null, 'sortBy' => null, 'descending' => false, 'title' => 'Relatório',
        'includeTotal' => false, 'path' => null, 'sendEmail' => false, 'emailDestination' => null,
    ];

    public function format(string $value): self { $this->values['format'] = $value; return $this; }
    public function sales(array $value): self { $this->values['sales'] = $value; return $this; }
    public function period(?string $start, ?string $end): self { $this->values['startDate'] = $start; $this->values['endDate'] = $end; return $this; }
    public function category(?string $value): self { $this->values['category'] = $value; return $this; }
    public function orderBy(?string $field, bool $descending = false): self { $this->values['sortBy'] = $field; $this->values['descending'] = $descending; return $this; }
    public function title(string $value): self { $this->values['title'] = $value; return $this; }
    public function includeTotal(bool $value = true): self { $this->values['includeTotal'] = $value; return $this; }
    public function saveTo(?string $path): self { $this->values['path'] = $path; return $this; }
    public function email(?string $destination): self { $this->values['sendEmail'] = $destination !== null; $this->values['emailDestination'] = $destination; return $this; }

    public function build(): ReportRequest
    {
        if (!$this->values['format']) throw new \InvalidArgumentException('Formato é obrigatório.');
        return new ReportRequest(...$this->values);
    }
}
