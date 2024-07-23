<?php

namespace App\Http\Controllers\Customer;

use App\Helper\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDialogRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\CustomerDocument;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        $customers = $this->customerService->getListCustomerIndex($request);
        $status = $this->customerService->getCustomerStatus();
        $staff = $this->customerService->getStaff();
        return view('customer.index', compact('customers', 'status', 'staff'));
    }

    public function create()
    {
        $status = $this->customerService->getCustomerStatus();
        $services = $this->customerService->getListService();
        $suppliers = $this->customerService->getListSupplier();
        $staff = $this->customerService->getStaff();
        return view('customer.create', compact('status', 'services', 'suppliers', 'staff'));
    }

    public function store(CustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->customerService->createCustomer($request);
            DB::commit();
            return redirect()->route('customer.index')->with([
                'status_succeed' => trans('message.create_customer_success')
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
        $customer = $this->customerService->getCustomerById($id);
        $files = json_encode($this->customerService->getFileCustomerEdit($id));
        $status = $this->customerService->getCustomerStatus();
        $services = $this->customerService->getListService();
        $service_saves = $this->customerService->getListServiceSave($id);
        $suppliers = $this->customerService->getListSupplier();
        $staff = $this->customerService->getStaff();
        return view('customer.edit', compact('files', 'customer', 'status', 'services', 'service_saves', 'suppliers', 'staff'));
    }

    public function update(CustomerRequest $request, $id)
    {
        try {
            $url = $request->url_previous;
            DB::beginTransaction();
            $this->customerService->updateCustomer($request, $id);
            DB::commit();

            if ($url) {
                return redirect()->to($url)->with([
                    'status_succeed' => trans('message.update_customer_success')
                ]);
            }

            return redirect()->route('customer.index')->with([
                'status_succeed' => trans('message.update_customer_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function getPriceSv(Request $request)
    {
        if ($request->ajax()) {
            $id_service = $request->id_service;
            $service = $this->customerService->getPriceService($id_service);
            return response()->json([
                'code' => 200,
                'service' => $service
            ]);
        }
    }

    public function delete($id)
    {
        try {

            DB::beginTransaction();
            $this->customerService->deleteCustomer($id);
            DB::commit();
            return [
                'status' => 200,
                'msg' => [
                    'text' => trans('message.success'),
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => trans('message.server_error')
            ], 500);
        }
    }

    public function detail(Request $request, $id)
    {
        $customer = $this->customerService->getCustomerDetail($id);
        $documents = $this->customerService->getFileCustomer($request, $id);
        $services = $this->customerService->getDetailService($id);
        $list_services = $this->customerService->getListService();
        $suppliers = $this->customerService->getListSupplier();
        return view('customer.detail', compact('customer', 'documents', 'services', 'list_services', 'suppliers'));
    }

    public function dialog(Request $request, $id)
    {
        $customer = $this->customerService->getCustomerDetail($id);
        $dialogs = $this->customerService->getCustomerDialog($request, $id);
        $services = $this->customerService->getDetailService($id);
        $list_services = $this->customerService->getListService();
        $suppliers = $this->customerService->getListSupplier();
        return view('customer.dialog', compact('customer', 'dialogs', 'services', 'list_services', 'suppliers'));
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('files');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('temp', $fileName);

        $path = '/temp/' . $fileName;

        return response()->json(['success' => true, 'path' => $path]);
    }

    public function removeFile(Request $request)
    {
        $fileName = $request->input('file_name');

        // Xóa file tạm
        Storage::delete('temp/' . $fileName);

        return response()->json(['success' => true, 'message' => 'Temp file deleted successfully']);
    }

    public function download($id, $file_name)
    {
        $filePath = public_path('storage/customer/' . $id . '/' . $file_name);

        if (file_exists($filePath)) {
            return response()->download($filePath, $file_name);
        }

        return abort(404);
    }

    public function deleteFile($file_id)
    {
        try {
            DB::beginTransaction();
            $file = CustomerDocument::find($file_id);
            if ($file) {
                $filePath = $file->file_path;
                if (File::exists(public_path($filePath))) {
                    File::delete(public_path($filePath));
                }

                $file->delete();
            }
            DB::commit();
            return [
                'status' => 200,
                'msg' => [
                    'text' => trans('message.success'),
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => trans('message.server_error')
            ], 500);
        }
    }

    public function createDialog(CustomerDialogRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->customerService->createCustomerDialog($request, $id);
            DB::commit();
            return redirect()->back()->with([
                'status_succeed' => trans('message.create_customer_dialog_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function updateDialog(CustomerDialogRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->customerService->updateCustomerDialog($request, $id);
            DB::commit();
            return redirect()->back()->with([
                'status_succeed' => trans('message.update_customer_dialog_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function deleteDialog($id)
    {
        try {

            DB::beginTransaction();
            $this->customerService->deleteCustomerDialog($id);
            DB::commit();
            return [
                'status' => 200,
                'msg' => [
                    'text' => trans('message.success'),
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => trans('message.server_error')
            ], 500);
        }
    }

    public function updateService(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->customerService->updateService($request, $id);
            DB::commit();
            return redirect()->back()->with([
                'status_succeed' => trans('message.update_customer_service_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function uploadDetail(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->customerService->createFileDetail($request, $id);
            DB::commit();
            return redirect()->back()->with([
                'status_succeed' => trans('message.create_customer_document_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function toggleStatus(Request $request)
    {
        $item = Customer::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
}
