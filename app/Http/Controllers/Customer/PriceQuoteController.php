<?php

namespace App\Http\Controllers\Customer;

use App\Events\SendMailPriceQuoteEvent;
use App\Events\UnlinkPdfEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PriceQuoteRequest;
use App\Models\Customer;
use App\Models\PriceQuote;
use App\Services\PriceQuoteService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PriceQuoteController extends Controller
{
    protected $priceQuoteService;

    public function __construct(PriceQuoteService $priceQuoteService)
    {
        $this->priceQuoteService = $priceQuoteService;
    }

    public function index(Request $request)
    {
        $datas = $this->priceQuoteService->getListPriceQuote($request);
        return view('price_quote.index', compact('datas'));
    }

    public function create()
    {
        $services = $this->priceQuoteService->getListService();
        $customers = $this->priceQuoteService->getListCustomer();
        return view('price_quote.create', compact('services', 'customers'));
    }

    public function store(PriceQuoteRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->priceQuoteService->createPriceQuote($request);
            DB::commit();
            return redirect()->route('priceQuote.index')->with([
                'status_succeed' => trans('message.create_price_quote_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function edit($id)
    {
        $data = $this->priceQuoteService->getPriceQuoteById($id);
        $service_saves = $this->priceQuoteService->getServiceByData($data->id);
        $services = $this->priceQuoteService->getListService();
        $customers = $this->priceQuoteService->getListCustomer();
        return view('price_quote.edit', compact('services', 'customers', 'data', 'service_saves'));
    }

    public function update(PriceQuoteRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->priceQuoteService->updatePriceQuote($request, $id);
            DB::commit();
            return redirect()->route('priceQuote.index')->with([
                'status_succeed' => trans('message.create_price_quote_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function detail($id)
    {
        $data = $this->priceQuoteService->getPriceQuoteById($id);
        $services = $this->priceQuoteService->getListServiceDetail($data->id);
        return view('price_quote.detail', compact('data', 'services'));
    }

    public function exportPdf($id)
    {
        $datas = $this->priceQuoteService->getListServiceDetail($id)->toArray();
        $customer_id = PriceQuote::select('customer_id')->where('id', $id)->first()->customer_id;
        $customer = Customer::select('email', 'name')->where('id', $customer_id)->first();
        $name = $customer->name;
        $pdf = Pdf::loadView('price_quote.export', ['datas' => $datas, 'name' => $name]);
        return $pdf->download('myPDF.pdf');
    }

    public function send(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $datas = $this->priceQuoteService->getListServiceDetail($id)->toArray();

            $customer_id = PriceQuote::select('customer_id')->where('id', $id)->first()->customer_id;

            $customer = Customer::select('email', 'name')->where('id', $customer_id)->first();

            $email = $customer->email;
            $name = $customer->name;

            $price_quote = $this->priceQuoteService->getPriceQuoteById($id);
            $content = $price_quote->content;
            $pdf = Pdf::loadView('price_quote.export', ['datas' => $datas, 'name' => $name]);

            $pdfDirectory = public_path('pdfs');
            if (!file_exists($pdfDirectory)) {
                mkdir($pdfDirectory, 0777, true);
            }

            // Lưu tệp PDF vào đường dẫn tạm thời
            $pdfPath = public_path('pdfs/myPDF.pdf');
            $pdf->save($pdfPath);
            event(new SendMailPriceQuoteEvent($pdfPath, $email, $content));
            event(new UnlinkPdfEvent($pdfPath));

            $price_quote->update(['status' => 1]);

            return response()->json([
                'code' => 200,
            ]);
        }
    }
}
