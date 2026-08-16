<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function generatePdf($id = 1)
    {
        $invoice = $this->getInvoiceData($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))->setPaper('a4');

        return $pdf->download('invoice-' . $invoice['number'] . '.pdf');
    }

    public function generateCsv($id = 1)
    {
        $invoice = $this->getInvoiceData($id);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="invoice-' . $invoice['number'] . '.csv"',
        ];

        $callback = function () use ($invoice) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Description', 'Qty', 'Unit Price', 'Amount']);

            foreach ($invoice['items'] as $item) {
                fputcsv($file, [
                    $item['description'],
                    $item['qty'],
                    $item['unit_price'],
                    $item['amount'],
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Subtotal', $invoice['subtotal']]);

            foreach ($invoice['gst_lines'] as $gst) {
                fputcsv($file, [$gst['label'], $gst['amount']]);
            }

            fputcsv($file, ['Total', $invoice['total']]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getInvoiceData($id): array
    {
        return [
            'number' => '2022435',
            'issue_date' => '19/7/2022',
            'due_date' => '3/8/2022',
            'reference' => '2022435',
            'business' => [
                'name' => 'FAHUSHE',
                'address' => "5 Martin Pl\nSydney NSW 2000\nAustralia",
                'phone' => '+61200000000',
                'website' => 'www.yourbusinessname.com.au',
                'email' => 'email@yourbusinessname.com.au',
            ],
            'client' => [
                'name' => 'Your Client',
                'address' => "100 Harris St\nSydney NSW NSW 2009\nAustralia",
            ],
            'items' => [
                ['description' => 'Services & products', 'qty' => 1, 'unit_price' => 100.00, 'amount' => 100.00],
                ['description' => 'More services & products', 'qty' => 1, 'unit_price' => 2000.00, 'amount' => 2000.00],
            ],
            'subtotal' => 2100.00,
            'gst_lines' => [
                ['label' => 'GST 10% from $100.00', 'amount' => 10.00],
                ['label' => 'GST 20% from $2,000.00', 'amount' => 400.00],
            ],
            'total' => 2510.00,
        ];
    }
}
