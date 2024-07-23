<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Payment;
use App\Models\PriceQuote;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class HomeController extends Controller
{
    const BAO_GIA = 5;

    public function index()
    {
        $now = Carbon::now()->toDateString();
        $check = DB::table('flag')->where('name', config('mail.NAME_MAIL_SERVICE'))->first();
        if (isset($check) && $check->date != $now) {
            Artisan::call('send:noti-service-expire');
            DB::table('flag')->where('name', config('mail.NAME_MAIL_SERVICE'))->update(['date' => Carbon::now()]);
        }

        $customers = Customer::select(
            'customer_status.name',
            DB::raw('COUNT(customers.id) as total_customers')
        )
            ->leftjoin('customer_status', 'customer_status.id', 'customers.status')
            ->groupBy('customer_status.name')
            ->get();

        $price_quote = PriceQuote::take(self::BAO_GIA)->get();

        return view('home.index', compact('customers', 'price_quote'));
    }

    public function noti_1()
    {
        $day = Carbon::now()->addDay(1)->startOfDay();
        $noti = CustomerService::whereDate('ended_at', $day)->count();
        return $noti;
    }

    public function noti_7()
    {
        $day = Carbon::now()->addDay(7)->startOfDay();
        $noti = CustomerService::whereDate('ended_at', $day)->count();
        return $noti;
    }

    public function noti_30()
    {
        $day = Carbon::now()->addDay(30)->startOfDay();
        $noti = CustomerService::whereDate('ended_at', $day)->count();
        return $noti;
    }


    public function statistic(Request $request)
    {
        $type = $request->type;

        $now = Carbon::now();
        if ($type == 'week') {
            $to = $now->format('Y-m-d');
            $from = $now->copy()->subDays(7)->format('Y-m-d');
        } elseif ($type == 'month') {
            $from = $now->copy()->startOfMonth()->format('Y-m-d');
            $to = $now->copy()->endOfMonth()->format('Y-m-d');
        }else{
            $data = $request->all();
            $from = Carbon::createFromFormat('d/m/Y', $data['from'])->format('Y-m-d');
            $to = Carbon::createFromFormat('d/m/Y', $data['to'])->format('Y-m-d');
        }

        $receipts = Receipt::select(
            DB::raw('SUM(REPLACE(price, ",", "")) AS total_price'),
            DB::raw('DATE(date) as date')
        )
            ->whereBetween('date', [$from, $to])
            ->groupBy(DB::raw('DATE(date)'))
            ->get();

        $payments = Payment::select(
            DB::raw('SUM(REPLACE(price, ",", "")) AS total_price'),
            DB::raw('DATE(date) as date')
        )
            ->whereBetween('date', [$from, $to])
            ->groupBy(DB::raw('DATE(date)'))
            ->get();

        $chartData = [];
        $sum_receipt = 0;
        $sum_payment = 0;

        foreach ($receipts as $receipt) {
            $chartData[$this->formatDate($receipt->date)] = $receipt->total_price;
            $sum_receipt += (int)str_replace(',', '', $receipt->total_price);
        }

        $chartDataOd = [];

        foreach ($payments as $payment) {
            $chartDataOd[$this->formatDate($payment->date)] = $payment->total_price;
            $sum_payment += (int)str_replace(',', '', $payment->total_price);
        }

        $startDate = Carbon::parse($from);
        $endDate = Carbon::parse($to);
        $arrDate = [];
        $arrReceipt = [];
        $arrPayment = [];


        do {
            $index = $startDate->format('d-m-Y');
            $arrDate[] = $index;
            $arrPayment[] = array_key_exists($index, $chartDataOd) ? $chartDataOd[$index] : 0;
            $arrReceipt[] = array_key_exists($index, $chartData) ? $chartData[$index] : 0;
        } while ($startDate->addDay()->lte($endDate));

        return response()->json([
            'receipt' => $arrReceipt,
            'date' => $arrDate,
            'payment' => $arrPayment,
            'sum_receipt' => number_format($sum_receipt),
            'sum_payment' => number_format($sum_payment),
        ]);
    }


    function formatDate($dateString)
    {
        $timestamp = strtotime($dateString);
        $formattedDate = date("d-m-Y", $timestamp);
        return $formattedDate;
    }
}
