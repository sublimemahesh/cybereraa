<?php

namespace App\Traits;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use stdClass;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use View;

trait HasInvoice
{

    public function stream($output, $filename = 'invoice.pdf'): Response
    {
        return new Response($output, ResponseAlias::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename=' . $filename,
        ]);
    }

    private function render(StdClass $invoice): string
    {
        $view = view('invoices.template', compact('invoice'));
        $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');
        return Pdf::setOptions(['enable_php' => true])->loadHtml($html)->output();
    }

    private function toHtml(StdClass $invoice): \Illuminate\Contracts\View\View
    {
        return View::make('invoices.template', compact('invoice'));
    }

    private function getLogo(): string
    {
        $url = asset('assets/backend/images/logo/logo-full.png');
        $type = pathinfo($url, PATHINFO_EXTENSION);
        $data = file_get_contents($url);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    private function getQr(): string
    {
        $url = asset('assets/images/tycoon1m.com-qr.png');
        $type = pathinfo($url, PATHINFO_EXTENSION);
        $data = file_get_contents($url);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
