<?php

namespace App\Repositories;

use App\Models\CommissionBonus;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Receipt;
use App\Models\Receivable;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceivableRepository
{
    const PAGINATE = 15;
    const CONG_NO_MOI = 0;
    const CNGH = 1;
    const RECEPT_1 = 1;
    const RECEPT_2 = 2;
    const RECEPT_3 = 3;

    public function getListReceivable($request)
    {
        $receivables = Receivable::select(
            'receivables.id',
            'receivables.contract_value',
            'receivables.amount_owed',
            'receivables.type',
            'receivables.ended_at',
            'customers.name as customer_name',
            'customers.code as customer_code',
            'customers.id as customer_id',
            'services.name as service_name'
        )
            ->leftjoin('customers', 'customers.id', 'receivables.customer_id')
            ->leftjoin('services', 'services.id', 'receivables.service_id');

        if ($request->name != null) {
            $receivables = $receivables->where('customers.name', 'LIKE', "%{$request->name}%");
        }

        if ($request->code != null) {
            $receivables = $receivables->where('customers.code', 'LIKE', "%{$request->code}%");
        }

        if ($request->services != null) {
            $receivables = $receivables->where('services.id', $request->services);
        }

        if ($request->from != null) {
            $receivables = $receivables->whereDate('receivables.ended_at', '>=', Carbon::createFromFormat('d/m/Y', $request->from));
        }

        if ($request->to != null) {
            $receivables = $receivables->whereDate('receivables.ended_at', '<=', Carbon::createFromFormat('d/m/Y', $request->to));
        }

        if ($request->type != null) {
            $receivables = $receivables->where('receivables.type', $request->type);
        }

        if ($request->status !== null) {
            if ($request->status == '1') {
                $receivables = $receivables->where('receivables.amount_owed', 0);
            } else {
                $receivables = $receivables->where('receivables.amount_owed', '!=', 0);
            }
        }
        $receivables = $receivables->orderBy('receivables.id', 'desc')->paginate(self::PAGINATE);
        return $receivables;
    }

    public function getListCustomer()
    {
        $customer_ids = CustomerService::pluck('customer_id')->unique();

        $customers = Customer::select('id', 'name', 'code')->whereIn('id', $customer_ids)->get();

        return $customers;
    }

    public function getReceivableById($id)
    {
        $receivable = Receivable::find($id);
        $receivable = Receivable::select(
            'receivables.id',
            'receivables.customer_id',
            'receivables.signed_date',
            'receivables.contract_value',
            'receivables.amount_owed',
            'receivables.advance_date_1',
            'receivables.advance_date_2',
            'receivables.advance_date_3',
            'receivables.advance_value_1',
            'receivables.advance_value_2',
            'receivables.advance_value_3',
            'receivables.reason_3',
            'receivables.reason_2',
            'receivables.reason_1',
            'receivables.note',
            'receivables.ended_at',
            'services.id as service_id',
            'services.name as service_name',
        )
            ->leftjoin('services', 'services.id', 'receivables.service_id')
            ->where('receivables.id', $id)->first();
        return $receivable;
    }

    public function createReceivable($request)
    {
        $values = $request->customer_service_id;
        foreach ($values as $key => $item) {
            $contract_value = str_replace(',', '', $request->contract_value[$key]);
            $advance_value_1 = str_replace(',', '', $request->advance_value_1[$key]);
            $advance_value_2 = str_replace(',', '', $request->advance_value_2[$key]);
            $advance_value_3 = str_replace(',', '', $request->advance_value_3[$key]);

            $amount_owed = (int) $contract_value - ((int) $advance_value_1 + (int) $advance_value_2 + (int) $advance_value_3);
            $user_id = CustomerService::select('user_id')->where('id', $item)->first();
            $user = User::findOrFail($user_id->user_id);
            $params = [
                'customer_id' => $request->customer,
                'contract_value' => $contract_value,
                'advance_date_1' => isset($request->advance_date_1[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1[$key]) : $request->advance_date_1[$key],
                'advance_date_2' => isset($request->advance_date_2[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2[$key]) : $request->advance_date_2[$key],
                'advance_date_3' => isset($request->advance_date_3[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3[$key]) : $request->advance_date_3[$key],
                'advance_value_1' => !empty($advance_value_1) ? $advance_value_1 : null,
                'advance_value_2' => !empty($advance_value_2) ? $advance_value_2 : null,
                'advance_value_3' => !empty($advance_value_3) ? $advance_value_3 : null,
                'amount_owed' => $amount_owed,
                'service_id' => $request->service_id[$key],
                'note' => $request->note[$key],
                'customer_service_id' => $request->customer_service_id[$key],
                'type' => self::CONG_NO_MOI,
                'ended_at' => isset($request->ended_at[$key]) ? Carbon::createFromFormat('d/m/Y', $request->ended_at[$key]) : $request->ended_at[$key],
                'reason_1' => $request->reason_1[$key],
                'reason_2' => $request->reason_2[$key],
                'reason_3' => $request->reason_3[$key],
                'user_id' => $user_id->user_id ?? null,
            ];
            $data = Receivable::create($params);

            $customer = Customer::select('id', 'address')->where('id', $request->customer)->first();

            if ($request->advance_value_1[$key] != null) {
                $receipt = Receipt::create([
                    'customer_id' => $request->customer,
                    'price' => $request->advance_value_1[$key],
                    'date' => isset($request->advance_date_1[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1[$key]) : $request->advance_date_1[$key],
                    'reason' => $request->reason_1[$key],
                    'receivable_id' => $data->id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_1,
                    'user_id' => $user_id->user_id ?? null,
                ]);

                $commissionBonus = CommissionBonus::create([
                    'customer_service_id' => $request->customer_service_id[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receipt_id' => $receipt->id,
                    'reason' => $request->reason_1[$key],
                    'price' => (floatval(str_replace(',', '', $request->advance_value_1[$key])) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_1[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1[$key]) : $request->advance_date_1[$key],
                ]);
            }

            if ($request->advance_value_2[$key] != null) {
                $receipt = Receipt::create([
                    'customer_id' => $request->customer,
                    'price' => $request->advance_value_2[$key],
                    'date' => isset($request->advance_date_2[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2[$key]) : $request->advance_date_2[$key],
                    'reason' => $request->reason_2[$key],
                    'receivable_id' => $data->id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_2,
                    'user_id' => $user_id->user_id ?? null,
                ]);
                $commissionBonus = CommissionBonus::create([
                    'customer_service_id' => $request->customer_service_id[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receipt_id' => $receipt->id,
                    'reason' => $request->reason_2[$key],
                    'price' => (floatval(str_replace(',', '', $request->advance_value_2[$key])) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_2[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2[$key]) : $request->advance_date_2[$key],
                ]);
            }

            if ($request->advance_value_3[$key] != null) {
                $receipt = Receipt::create([
                    'customer_id' => $request->customer,
                    'price' => $request->advance_value_3[$key],
                    'date' => isset($request->advance_date_3[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3[$key]) : $request->advance_date_3[$key],
                    'reason' => $request->reason_3[$key],
                    'receivable_id' => $data->id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_3,
                    'user_id' => $user_id->user_id ?? null,
                ]);
                $commissionBonus = CommissionBonus::create([
                    'customer_service_id' => $request->customer_service_id[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receipt_id' => $receipt->id,
                    'reason' => $request->reason_3[$key],
                    'price' => (floatval(str_replace(',', '', $request->advance_value_3[$key])) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_3[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3[$key]) : $request->advance_date_3[$key],
                ]);
            }
        }

        return true;
    }

    public function updateReceivable($request, $id)
    {
        $receivable = Receivable::find($id);
        $contract_value = str_replace(',', '', $request->contract_value);
        $advance_value_1 = str_replace(',', '', $request->advance_value_1);
        $advance_value_2 = str_replace(',', '', $request->advance_value_2);
        $advance_value_3 = str_replace(',', '', $request->advance_value_3);
        $user = User::findOrFail($receivable->user_id);
        $amount_owed = (int) $contract_value - ((int) $advance_value_1 + (int) $advance_value_2 + (int) $advance_value_3);

        $params = [
            'advance_date_1' => isset($request->advance_date_1) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1) : $request->advance_date_1,
            'advance_date_2' => isset($request->advance_date_2) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2) : $request->advance_date_2,
            'advance_date_3' => isset($request->advance_date_3) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3) : $request->advance_date_3,
            'advance_value_1' => !empty($advance_value_1) ? $advance_value_1 : null,
            'advance_value_2' => !empty($advance_value_2) ? $advance_value_2 : null,
            'advance_value_3' => !empty($advance_value_3) ? $advance_value_3 : null,
            'amount_owed' => $amount_owed,
            'note' => $request->note,
            'reason_1' => $request->reason_1,
            'reason_2' => $request->reason_2,
            'reason_3' => $request->reason_3,
            'user_id' => $receivable->user_id ?? null,
        ];

        $receivable->update($params);

        $customer = Customer::select('id', 'address')->where('id', $receivable->customer_id)->first();

        if ($request->advance_value_1 != null) {
            $receipt = Receipt::updateOrCreate(
                ['id' => $request->receipt1],
                [
                    'customer_id' => $customer->id,
                    'price' => $request->advance_value_1,
                    'date' => isset($request->advance_date_1) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1) : $request->advance_date_1,
                    'reason' => $request->reason_1,
                    'receivable_id' => $id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_1,
                    'user_id' => $receivable->user_id ?? null,
                ]
            );
            CommissionBonus::updateOrCreate(
                ['receipt_id' => $receipt->id],
                [
                    'customer_service_id' => $receivable->customer_service_id,
                    'user_id' => $receivable->user_id ?? null,
                    'reason' => $request->reason_1,
                    'price' => (floatval(str_replace(',', '', $request->advance_value_1)) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_1) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1) : $request->advance_date_1,
                ]
            );

        }

        if ($request->advance_value_2 != null) {
            $receipt = Receipt::updateOrCreate(
                ['id' => $request->receipt2],
                [
                    'customer_id' => $customer->id,
                    'price' => $request->advance_value_2,
                    'date' => isset($request->advance_date_2) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2) : $request->advance_date_2,
                    'reason' => $request->reason_2,
                    'receivable_id' => $id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_2,
                    'user_id' => $receivable->user_id ?? null,
                ]
            );

            CommissionBonus::updateOrCreate(
                ['receipt_id' => $receipt->id],
                [
                    'customer_service_id' => $receivable->customer_service_id,
                    'user_id' => $receivable->user_id ?? null,
                    'reason' => $request->reason_2,
                    'price' => (floatval(str_replace(',', '', $request->advance_value_2)) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_2) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2) : $request->advance_date_2,
                ]
            );
        }

        if ($request->advance_value_3 != null) {

            $receipt = Receipt::updateOrCreate(
                ['id' => $request->receipt3],
                [
                    'customer_id' => $customer->id,
                    'price' => $request->advance_value_3,
                    'date' => isset($request->advance_date_3) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3) : $request->advance_date_3,
                    'reason' => $request->reason_3,
                    'receivable_id' => $id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_3,
                    'user_id' => $receivable->user_id ?? null,
                ]
            );
            CommissionBonus::updateOrCreate(
                ['receipt_id' => $receipt->id],
                [
                    'customer_service_id' => $receivable->customer_service_id,
                    'user_id' => $receivable->user_id ?? null,
                    'reason' => $request->reason_3,
                    'price' => (floatval(str_replace(',', '', $request->advance_value_3)) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_3) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3) : $request->advance_date_3,
                ]
            );
        }



        return true;
    }

    public function getServiceByCustomer($customer_id)
    {

        $services = CustomerService::select(
            'services.id',
            'services.name',
            'customer_service.id as customer_service_id',
            'customer_service.note as note',
        )
            ->leftjoin('services', 'services.id', 'customer_service.service_id')
            ->where('customer_id', $customer_id)
            ->get();

        return $services;
    }

    public function createReceivableExtend($request)
    {
        $values = $request->customer_service_id;
        foreach ($values as $key => $item) {
            $contract_value = str_replace(',', '', $request->contract_value[$key]);
            $advance_value_1 = str_replace(',', '', $request->advance_value_1[$key]);
            $advance_value_2 = str_replace(',', '', $request->advance_value_2[$key]);
            $advance_value_3 = str_replace(',', '', $request->advance_value_3[$key]);

            $amount_owed = (int) $contract_value - ((int) $advance_value_1 + (int) $advance_value_2 + (int) $advance_value_3);
            $user_id = CustomerService::select('user_id')->where('id', $item)->first();
            $user = User::findOrFail($user_id->user_id);
            $params = [
                'customer_id' => $request->customer,
                'contract_value' => $contract_value,
                'advance_date_1' => isset($request->advance_date_1[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1[$key]) : $request->advance_date_1[$key],
                'advance_date_2' => isset($request->advance_date_2[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2[$key]) : $request->advance_date_2[$key],
                'advance_date_3' => isset($request->advance_date_3[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3[$key]) : $request->advance_date_3[$key],
                'advance_value_1' => !empty($advance_value_1) ? $advance_value_1 : null,
                'advance_value_2' => !empty($advance_value_2) ? $advance_value_2 : null,
                'advance_value_3' => !empty($advance_value_3) ? $advance_value_3 : null,
                'amount_owed' => $amount_owed,
                'service_id' => $request->service_id[$key],
                'note' => $request->note[$key],
                'customer_service_id' => $request->customer_service_id[$key],
                'type' => self::CNGH,
                'ended_at' => isset($request->ended_at[$key]) ? Carbon::createFromFormat('d/m/Y', $request->ended_at[$key]) : $request->ended_at[$key],
                'user_id' => $user_id->user_id ?? null,
            ];

            CustomerService::where('id', $item)->update([
                'ended_at' => isset($request->ended_at[$key]) ? Carbon::createFromFormat('d/m/Y', $request->ended_at[$key]) : $request->ended_at[$key]
            ]);

            $data = Receivable::create($params);

            if ($request->advance_value_1[$key] != null) {
                $receipt = Receipt::create([
                    'customer_id' => $request->customer,
                    'price' => $request->advance_value_1[$key],
                    'date' => isset($request->advance_date_1[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1[$key]) : $request->advance_date_1[$key],
                    'reason' => $request->reason_1[$key],
                    'receivable_id' => $data->id,
                    'user_id' => $user_id->user_id ?? null,
                    'type' => self::RECEPT_1
                ]);
                $commissionBonus = CommissionBonus::create([
                    'customer_service_id' => $request->customer_service_id[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receipt_id' => $receipt->id,
                    'reason' => $request->reason_1[$key],
                    'price' => (floatval(str_replace(',', '', $request->advance_value_1[$key])) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_1[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1[$key]) : $request->advance_date_1[$key],
                ]);
            }

            if ($request->advance_value_2[$key] != null) {
                $receipt = Receipt::create([
                    'customer_id' => $request->customer,
                    'price' => $request->advance_value_2[$key],
                    'date' => isset($request->advance_date_2[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2[$key]) : $request->advance_date_2[$key],
                    'reason' => $request->reason_2[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receivable_id' => $data->id,
                    'type' => self::RECEPT_2
                ]);
                $commissionBonus = CommissionBonus::create([
                    'customer_service_id' => $request->customer_service_id[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receipt_id' => $receipt->id,
                    'reason' => $request->reason_2[$key],
                    'price' => (floatval(str_replace(',', '', $request->advance_value_2[$key])) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_2[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2[$key]) : $request->advance_date_2[$key],
                ]);
            }

            if ($request->advance_value_3[$key] != null) {
                $receipt = Receipt::create([
                    'customer_id' => $request->customer,
                    'price' => $request->advance_value_3[$key],
                    'date' => isset($request->advance_date_3[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3[$key]) : $request->advance_date_3[$key],
                    'reason' => $request->reason_3[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receivable_id' => $data->id,
                    'type' => self::RECEPT_3
                ]);
                $commissionBonus = CommissionBonus::create([
                    'customer_service_id' => $request->customer_service_id[$key],
                    'user_id' => $user_id->user_id ?? null,
                    'receipt_id' => $receipt->id,
                    'reason' => $request->reason_3[$key],
                    'price' => (floatval(str_replace(',', '', $request->advance_value_3[$key])) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_3[$key]) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3[$key]) : $request->advance_date_3[$key],
                ]);
            }
        }

        return true;
    }

    public function updateReceivableExtend($request, $id)
    {
        $receivable = Receivable::find($id);
        $contract_value = str_replace(',', '', $request->contract_value);
        $advance_value_1 = str_replace(',', '', $request->advance_value_1);
        $advance_value_2 = str_replace(',', '', $request->advance_value_2);
        $advance_value_3 = str_replace(',', '', $request->advance_value_3);
        $user = User::findOrFail($receivable->user_id);
        $amount_owed = (int) $contract_value - ((int) $advance_value_1 + (int) $advance_value_2 + (int) $advance_value_3);

        $params = [
            'contract_value' => $contract_value,
            'ended_at' => isset($request->ended_at) ? Carbon::createFromFormat('d/m/Y', $request->ended_at) : $request->ended_at,
            'advance_date_1' => isset($request->advance_date_1) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1) : $request->advance_date_1,
            'advance_date_2' => isset($request->advance_date_2) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2) : $request->advance_date_2,
            'advance_date_3' => isset($request->advance_date_3) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3) : $request->advance_date_3,
            'advance_value_1' => !empty($advance_value_1) ? $advance_value_1 : null,
            'advance_value_2' => !empty($advance_value_2) ? $advance_value_2 : null,
            'advance_value_3' => !empty($advance_value_3) ? $advance_value_3 : null,
            'amount_owed' => $amount_owed,
            'note' => $request->note,
            'reason_1' => $request->reason_1,
            'reason_2' => $request->reason_2,
            'reason_3' => $request->reason_3,
            'user_id' => $receivable->user_id ?? null,
        ];

        $receivable->update($params);

        CustomerService::where('id', $receivable->customer_service_id)->update([
            'ended_at' => isset($request->ended_at) ? Carbon::createFromFormat('d/m/Y', $request->ended_at) : $request->ended_at
        ]);

        $customer = Customer::select('id', 'address')->where('id', $receivable->customer_id)->first();

        if ($request->advance_value_1 != null) {
            $receipt = Receipt::updateOrCreate(
                ['id' => $request->receipt1],
                [
                    'customer_id' => $customer->id,
                    'price' => $request->advance_value_1,
                    'date' => isset($request->advance_date_1) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1) : $request->advance_date_1,
                    'reason' => $request->reason_1,
                    'receivable_id' => $id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_1,
                    'user_id' => $receivable->user_id ?? null,
                ]
            );
            CommissionBonus::updateOrCreate(
                ['receipt_id' => $receipt->id],
                [
                    'customer_service_id' => $receivable->customer_service_id,
                    'user_id' => $receivable->user_id ?? null,
                    'reason' => $request->reason_1,
                    'price' => (floatval(str_replace(',', '', $request->advance_value_1)) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_1) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_1) : $request->advance_date_1,
                ]
            );
        }

        if ($request->advance_value_2 != null) {

            $receipt = Receipt::updateOrCreate(
                ['id' => $request->receipt2],
                [
                    'customer_id' => $customer->id,
                    'price' => $request->advance_value_2,
                    'date' => isset($request->advance_date_2) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2) : $request->advance_date_2,
                    'reason' => $request->reason_2,
                    'receivable_id' => $id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_2,
                    'user_id' => $receivable->user_id ?? null,
                ]
            );
            CommissionBonus::updateOrCreate(
                ['receipt_id' => $receipt->id],
                [
                    'customer_service_id' => $receivable->customer_service_id,
                    'reason' => $request->reason_2,
                    'user_id' => $receivable->user_id ?? null,
                    'price' => (floatval(str_replace(',', '', $request->advance_value_2)) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_2) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_2) : $request->advance_date_2,
                ]
            );
        }

        if ($request->advance_value_3 != null) {

            $receipt = Receipt::updateOrCreate(
                ['id' => $request->receipt3],
                [
                    'customer_id' => $customer->id,
                    'price' => $request->advance_value_3,
                    'date' => isset($request->advance_date_3) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3) : $request->advance_date_3,
                    'reason' => $request->reason_3,
                    'receivable_id' => $id,
                    'address' => $customer->address,
                    'type' => self::RECEPT_3,
                    'user_id' => $receivable->user_id ?? null,
                ]
            );
            CommissionBonus::updateOrCreate(
                ['receipt_id' => $receipt->id],
                [
                    'customer_service_id' => $receivable->customer_service_id,
                    'reason' => $request->reason_3,
                    'user_id' => $receivable->user_id ?? null,
                    'price' => (floatval(str_replace(',', '', $request->advance_value_3)) * floatval($user->commission->percent)) / 100,
                    'date' => isset($request->advance_date_3) ? Carbon::createFromFormat('d/m/Y', $request->advance_date_3) : $request->advance_date_3,
                ]
            );
        }

        return true;
    }
}
