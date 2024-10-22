<?php

namespace App\Http\Controllers\admin;

use ZipArchive;
// use Barryvdh\DomPDF\PDF;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Order::select('*')->get())
                ->addColumn('created_at', function ($order) {
                    return Carbon::parse($order->created_at)->format('d M, Y h:i A');
                })
                ->addColumn('id', function ($order) {
                    $url = route('admin.orders.show', $order->id);
                    return '<a href="' . htmlspecialchars($url) . '">' . $order->id . '</a>';
                })
                ->addColumn('status', function ($order) {
                    if ($order->status == "pending") {
                        return '<span class="badge badge-warning">Pending</span>';
                    } elseif ($order->status == "processing") {
                        return '<span class="badge badge-info">Processing</span>';
                    } elseif ($order->status == "shipped") {
                        return '<span class="badge badge-primary">Shipped</span>';
                    } elseif ($order->status == "delivered") {
                        return '<span class="badge badge-success">Delivered</span>';
                    } else {
                        return '<span class="badge badge-danger">Cancelled</span>';
                    }
                })
                ->rawColumns(['status', 'id'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.orders.index');
    }

    public function show(string $id)
    {
        $orders = Order::query()->with('details')->find($id);

        return view('admin.orders.show', compact('orders'));
    }

    public function exportAllInvoices()
    {
        $orders = Order::all();

        $zipFileName = 'all_invoices.zip';

        $zip = new ZipArchive;

        $tempPath = storage_path('app/temp');

        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }

        $zip->open($tempPath . '/' . $zipFileName, ZipArchive::CREATE);

        foreach ($orders as $order) {
            $pdf = PDF::loadView('admin.orders.invoice', compact('order'));
            $pdfContent = $pdf->output();
            $pdfFileName = 'invoice-' . $order->id . '.pdf';
            $zip->addFromString($pdfFileName, $pdfContent);
        }

        $zip->close();

        return Response::download($tempPath . '/' . $zipFileName)->deleteFileAfterSend(true);
    }

    public function exportInvoice($id)
    {
        $order = Order::with('details')->find($id);

        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));

        return $pdf->download('invoice-' . $id . '.pdf');
    }

    public function update(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
