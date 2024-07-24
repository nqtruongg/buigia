<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerDialog;
use App\Models\CustomerDocument;
use App\Models\CustomerService;
use App\Models\CustomerStatus;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListCustomerIndex($request)
    {
        $customers = Customer::select(
            'customers.id',
            'customers.name',
            'customers.phone',
            'customers.email',
            'customers.career',
            'customers.code',
            'customer_status.name as status_name',
            'customers.active',
        )->leftjoin('customer_status', 'customer_status.id', 'customers.status');
        if ($request->name != null) {
            $customers = $customers->where('customers.name', 'LIKE', "%{$request->name}%");
        }

        if ($request->code != null) {
            $customers = $customers->where('customers.code', 'LIKE', "%{$request->code}%");
        }

        if ($request->phone != null) {
            $customers = $customers->where('customers.phone', 'LIKE', "%{$request->phone}%");
        }

        if ($request->email != null) {
            $customers = $customers->where('customers.email', 'LIKE', "%{$request->email}%");
        }

        if ($request->tax_code != null) {
            $customers = $customers->where('customers.tax_code', 'LIKE', "%{$request->tax_code}%");
        }

        if ($request->status != null) {
            $customers = $customers->where('customers.status', $request->status);
        }

        if ($request->career != null) {
            $customers = $customers->where('customers.career', 'LIKE', "%{$request->career}%");
        }

        $customers = $customers->orderBy('customers.id', 'desc')->paginate(self::PAGINATE);
        return $customers;
    }

    public function getCustomerById($id)
    {
        $customer = Customer::find($id);
        return $customer;
    }

    public function getCustomerStatus()
    {
        $status = CustomerStatus::select('id', 'name')->get();
        return $status;
    }

    public function getStaff()
    {
        $staff = User::select('id', 'first_name', 'last_name')->where('department_id', 3)->get();
        return $staff;
    }

    public function getListService()
    {
        $services = Service::select('id', 'name')->where('type', 0)->get();
        return $services;
    }

    public function getListSupplier()
    {
        $supplier = Supplier::select('id', 'name')->get();
        return $supplier;
    }

    public function getPriceService($id_service)
    {
        $service = Service::select('price', 'type')->where('id', $id_service)->first();
        return $service;
    }

    public function getFileCustomer($request, $id)
    {
        $files = CustomerDocument::select(
            'id',
            'file_path',
            'file_name',
            'file_size',
            'file_type',
        )->where('customer_id', $id);

        if ($request->name != null) {
            $files = $files->where('file_name', 'LIKE', "%{$request->name}%");
        }

        if ($request->from != null) {
            $files = $files->whereDate('created_at', '>=', Carbon::createFromFormat('d/m/Y', $request->from));
        }

        if ($request->to != null) {
            $files = $files->whereDate('created_at', '<=', Carbon::createFromFormat('d/m/Y', $request->to));
        }

        $files = $files->orderBy('id', 'desc')->paginate(self::PAGINATE_FILE);

        return $files;
    }

    public function getFileCustomerEdit($id)
    {
        $files = CustomerDocument::select(
            'id',
            'file_path',
            'file_name',
            'file_size',
            'file_type',
        )->where('customer_id', $id)->get();

        return $files;
    }

    public function createCustomer($request)
    {
        $services = $request->services;
        $services = array_filter($services, function ($value) {
            return $value !== null;
        });

        $code = $this->generateCode();

        $params = [
            'name' => $request->name,
            'code' => $code,
            'responsible_person' => $request->responsible_person ?? '',
            'tax_code' => $request->tax_code,
            'status' => $request->status,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'invoice_address' => $request->invoice_address,
            'career' => $request->career,
            'user_id' => $request->user_id,
            'type' => $request->type ?? 0,
        ];

        $customer = Customer::create($params);

        if (isset($request->file_paths)) {
            $files = $request->file_paths;
            foreach ($files as $key => $file) {
                if (Storage::exists($file)) {
                    $this->createDocument($file, $customer->id);
                }
            }
        }

        if (!empty($services)) {
            $times = $request->time;
            $view_total = $request->view_total;
            $start = $request->start;
            $end = $request->end;
            $note = $request->note;
            foreach ($services as $key => $service) {
                CustomerService::create([
                    'customer_id' => $customer->id,
                    'service_id' => $service,
                    'time' => $times[$key],
                    'subtotal' => str_replace(',', '', $view_total[$key]),
                    'started_at' => isset($start[$key]) ? Carbon::createFromFormat('d/m/Y', $start[$key]) : $start[$key],
                    'ended_at' => isset($end[$key]) ? Carbon::createFromFormat('d/m/Y', $end[$key]) : $end[$key],
                    'note' => $note[$key] ?? null,
                    'supplier' => $request->supplier[$key],
                ]);
            }
        }
        return true;
    }

    public function updateCustomer($request, $id)
    {
        $services = $request->services ?? [];

        $services = array_filter($services, function ($value) {
            return $value !== null;
        });

        $params = [
            'name' => $request->name,
            'responsible_person' => $request->responsible_person ?? '',
            'tax_code' => $request->tax_code,
            'status' => $request->status,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'invoice_address' => $request->invoice_address,
            'career' => $request->career,
            'user_id' => $request->user_id,
            'type' => $request->type ?? 0,
        ];


        $customer = Customer::find($id);
        $customer->update($params);

        $file_ids = CustomerDocument::where('customer_id', $id)->pluck('id')->toArray();

        if (isset($request->file_saves)) {
            $file_id_rm = array_diff($file_ids, $request->file_saves);
            $listDocuments = CustomerDocument::whereIn('id', $file_id_rm)->pluck('file_path')->toArray();

            foreach ($listDocuments as $item) {
                if (File::exists(public_path($item))) {
                    File::delete(public_path($item));
                }
            }
            CustomerDocument::whereIn('id', $file_id_rm)->delete();
        } else {
            CustomerDocument::where('customer_id', $id)->delete();
        }

        if (isset($request->file_paths)) {
            $files = $request->file_paths;

            foreach ($files as $key => $file) {
                if (Storage::exists($file)) {
                    $this->createDocument($file, $customer->id);
                }
            }
        }

        CustomerService::where('customer_id', $id)->delete();
        if (!empty($services)) {
            $times = $request->time;
            $view_total = $request->view_total;
            $start = $request->start;
            $end = $request->end;
            $note = $request->note;
            foreach ($services as $key => $service) {
                CustomerService::create([
                    'customer_id' => $customer->id,
                    'service_id' => $service,
                    'time' => $times[$key],
                    'subtotal' => str_replace(',', '', $view_total[$key]),
                    'started_at' => isset($start[$key]) ? Carbon::createFromFormat('d/m/Y', $start[$key]) : $start[$key],
                    'ended_at' => isset($end[$key]) ? Carbon::createFromFormat('d/m/Y', $end[$key]) : $end[$key],
                    'note' => $note[$key] ?? null,
                    'supplier' => $request->supplier[$key],

                ]);
            }
        }
        return true;
    }

    public function createDocument($file, $customer_id)
    {
        $fileName = pathinfo($file, PATHINFO_BASENAME);
        $newFile = 'public/customer/' . $customer_id . '/' . $fileName;
        Storage::move($file, $newFile);

        $newFilePath = '/storage/customer/' . $customer_id . '/' . $fileName;

        $filePathNew = public_path($newFilePath);

        $fileMimeType = File::mimeType($filePathNew);
        $fileSize = File::size($filePathNew);
        CustomerDocument::create([
            'customer_id' => $customer_id,
            'file_name' => $fileName,
            'file_type' => $fileMimeType,
            'file_path' => $newFilePath,
            'file_size' => $fileSize
        ]);
    }

    public function getListServiceSave($id)
    {
        $service_saves = CustomerService::select(
            'customer_service.id',
            'customer_service.service_id',
            'customer_service.time',
            'customer_service.subtotal',
            'customer_service.started_at',
            'customer_service.ended_at',
            'customer_service.note',
            'customer_service.supplier',
            'services.price'
        )
            ->leftjoin('services', 'services.id', 'customer_service.service_id')
            ->where('customer_id', $id)->get();
        return $service_saves;
    }

    public function generateCode()
    {
        $currentYear = now()->year;
        $lastCustomer = Customer::whereYear('created_at', $currentYear)->latest()->first();

        if ($lastCustomer) {
            $lastCode = $lastCustomer->code;
            $lastNumber = (int) substr($lastCode, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $currentYear . '-KH' . $newNumber;
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            CustomerService::where('customer_id', $id)->delete();
            CustomerDialog::where('customer_id', $id)->delete();
            $files = CustomerDocument::where('customer_id', $id)->pluck('file_path')->toArray();
            foreach ($files as $item) {
                if (File::exists(public_path($item))) {
                    File::delete(public_path($item));
                }
            }
            CustomerDocument::where('customer_id', $id)->delete();
            $customer->delete();

            return true;
        }

        return false;
    }

    public function getCustomerDetail($id)
    {
        $customer = Customer::select(
            'customers.id',
            'customers.name',
            'customers.phone',
            'customers.email',
            'customers.tax_code',
            'customers.address',
            'customers.invoice_address',
            'customers.code',
            'customers.career',
            'customers.status',
            'customer_status.name as status_name',
        )
            ->leftjoin('customer_status', 'customer_status.id', 'customers.status')
            ->where('customers.id', $id)->first();
        return $customer;
    }

    public function getCustomerDialog($request, $id)
    {
        $dialogs = CustomerDialog::select(
            'customer_dialogs.id',
            'customer_dialogs.customer_id',
            'customer_dialogs.user_id',
            'customer_dialogs.content',
            'customer_dialogs.created_at',
            'customer_dialogs.updated_at',
            DB::raw('CONCAT(users.first_name, " ", users.last_name) as full_name')
        )
            ->leftJoin('users', 'users.id', '=', 'customer_dialogs.user_id')
            ->where('customer_dialogs.customer_id', $id);

        if ($request->has('user_name')) {
            $dialogs->where(DB::raw('CONCAT(users.first_name, " ", users.last_name)'), 'like', '%' . $request->user_name . '%');
        }

        if ($request->from != null) {
            $dialogs->whereDate('customer_dialogs.created_at', '>=', Carbon::createFromFormat('d/m/Y', $request->from));
        }

        if ($request->to != null) {
            $dialogs->whereDate('customer_dialogs.created_at', '<=', Carbon::createFromFormat('d/m/Y', $request->to));
        }

        $dialogs = $dialogs->orderBy('customer_dialogs.id', 'desc')->paginate(self::PAGINATE_FILE);

        return $dialogs;
    }

    public function createCustomerDialog($request, $id)
    {
        $params = [
            'customer_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ];

        CustomerDialog::create($params);

        return true;
    }

    public function updateCustomerDialog($request, $id)
    {
        $dialog = CustomerDialog::find($id);
        if ($dialog) {

            $params = [
                'content' => $request->input('content_' . $id),
            ];

            $dialog->update($params);

            return true;
        }
        return false;
    }

    public function deleteCustomerDialog($id)
    {
        $dialog = CustomerDialog::find($id);
        if ($dialog) {
            $dialog->delete();
            return true;
        }
        return false;
    }

    public function getDetailService($id)
    {
        $services = CustomerService::select(
            'customer_service.id',
            'customer_service.service_id',
            'customer_service.time',
            'customer_service.subtotal',
            'customer_service.started_at',
            'customer_service.ended_at',
            'customer_service.note',
            'customer_service.supplier',
            'services.name as service_name'
        )
            ->leftjoin('services', 'services.id', 'customer_service.service_id')
            ->where('customer_service.customer_id', $id)
            ->get();

        return $services;
    }

    public function updateService($request, $id)
    {
        $customer = Customer::find($id);
        if ($customer) {

            $services = $request->services;

            CustomerService::where('customer_id', $id)->delete();
            if (!empty($services)) {
                $services = array_filter($services, function ($value) {
                    return $value !== null;
                });
                $times = $request->time;
                $view_total = $request->view_total;
                $start = $request->start;
                $end = $request->end;
                $note = $request->note;
                foreach ($services as $key => $service) {
                    CustomerService::create([
                        'customer_id' => $customer->id,
                        'service_id' => $service,
                        'time' => $times[$key],
                        'subtotal' => str_replace(',', '', $view_total[$key]),
                        'started_at' => isset($start[$key]) ? Carbon::createFromFormat('d/m/Y', $start[$key]) : $start[$key],
                        'ended_at' => isset($end[$key]) ? Carbon::createFromFormat('d/m/Y', $end[$key]) : $end[$key],
                        'note' => $note[$key] ?? null,
                    ]);
                }
            }
            return true;
        }
        return false;
    }

    public function createFileDetail($request, $id)
    {
        if (isset($request->file_paths)) {
            $files = $request->file_paths;

            foreach ($files as $key => $file) {
                if (Storage::exists($file)) {
                    $this->createDocument($file, $id);
                }
            }

            return true;
        }

        return false;
    }
}
