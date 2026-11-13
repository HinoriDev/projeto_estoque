<?php

namespace App\Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reports\Services\ReportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ReportController extends Controller
{
    public function __construct(private ReportService $reports) {}

    public function index() { return view('reports.index'); }

    public function generate(Request $request): Response
    {
        $report = $this->reports->generate($request->all());
        return response($report['content'])->header('Content-Type', $report['content_type'])
            ->header('Content-Disposition', 'attachment; filename="'.basename($report['path']).'"');
    }

    public function archive(Request $request)
    {
        $result = $this->reports->archiveCsv();
        if (str_starts_with($result, 'Arquivado')) {
            $request->session()->put('report_archive', true);
        }
        return response($result);
    }

    public function undo(Request $request)
    {
        $archive = $request->session()->pull('report_archive');
        if ($archive) $this->reports->restoreCsv();
        return back()->with('status', $archive ? 'Relatório restaurado.' : 'Não há arquivamento recente para desfazer.');
    }
}
