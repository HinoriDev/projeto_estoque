<?php

namespace App\Modules\Reports\Services;

use App\Modules\Products\Models\Product;
use App\Modules\Reports\Services\Factories\ReportOutputFactory;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReportService extends BaseService
{
    public function generate(array $input): array
    {
        $filters = Validator::make($input, [
            'format' => ['required', 'in:csv,html,json,xml,markdown'],
            'title' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:80'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'sort_by' => ['nullable', 'in:id,produto,categoria,preco,estoque,data'],
            'descending' => ['nullable', 'boolean'],
            'include_total' => ['nullable', 'boolean'],
        ])->validate();
        $factoryClass = config('reports.factories')[$filters['format']];
        /** @var ReportOutputFactory $factory */
        $factory = app($factoryClass);
        $file = $factory->createFile();
        $path = $filters['format'] === 'csv'
            ? base_path('out/produtos.csv')
            : storage_path('app/reports/'.uniqid('report_', true).'.'.$file->extension);
        $products = $this->getAll(Product::class, 'name')
            ->map(fn (Product $product): array => $product->toReportRow())
            ->all();
        $request = $this->buildWith(ReportRequestBuilder::class, function (ReportRequestBuilder $builder) use ($filters, $products, $path): void {
            $builder->format($filters['format'])
                ->sales($products)
                ->period($filters['start_date'] ?? null, $filters['end_date'] ?? null)
                ->category($filters['category'] ?? null)
                ->orderBy($filters['sort_by'] ?? null, (bool) ($filters['descending'] ?? false))
                ->title($filters['title'] ?? 'Relatório de produtos')
                ->includeTotal((bool) ($filters['include_total'] ?? false))
                ->saveTo($path);
        });
        $content = $factory->createGenerator()->generate($request);

        return [
            'content' => $content,
            'path' => $path,
            'format' => $request->format,
            'content_type' => $file->contentType,
        ];
    }

    public function archiveCsv(): string
    {
        $source = base_path('out/produtos.csv');
        $destination = base_path('arquivo/produtos.csv');

        if (!is_file($source)) return 'Relatório não encontrado.';
        if (!is_dir(dirname($destination))) mkdir(dirname($destination), 0777, true);
        if (!rename($source, $destination)) throw new \RuntimeException('Não foi possível arquivar o relatório.');

        Log::info('Relatório de produtos arquivado', ['source' => $source, 'destination' => $destination]);
        return "Arquivado.\n";
    }

    public function restoreCsv(): bool
    {
        $source = base_path('out/produtos.csv');
        $destination = base_path('arquivo/produtos.csv');
        if (!is_file($destination)) return false;
        if (!is_dir(dirname($source))) mkdir(dirname($source), 0777, true);

        $restored = rename($destination, $source);
        if ($restored) Log::info('Relatório de produtos restaurado', ['source' => $source]);
        return $restored;
    }
}
