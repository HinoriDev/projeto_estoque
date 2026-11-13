<?php

namespace App\Modules\Reports\Models;

final readonly class ReportRequest
{
    public function __construct(
        public string $format, public array $sales, public ?string $startDate, public ?string $endDate,
        public ?string $category, public ?string $sortBy, public bool $descending, public string $title,
        public bool $includeTotal, public ?string $path, public bool $sendEmail, public ?string $emailDestination,
    ) {
        if ($startDate && $endDate && $startDate > $endDate) throw new \InvalidArgumentException('A data inicial deve ser anterior à data final.');
        if ($sendEmail && !$emailDestination) throw new \InvalidArgumentException('Informe o destinatário do e-mail.');
        if ($sortBy && !in_array($sortBy, ['id', 'produto', 'categoria', 'preco', 'estoque', 'data'], true)) throw new \InvalidArgumentException('Campo de ordenação inválido.');
    }
}
