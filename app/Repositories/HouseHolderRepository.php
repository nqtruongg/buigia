<?php
namespace App\Repositories;


use App\Models\HouseHolder;

class HouseHolderRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;


    public function getListHouseHolder($request)
    {
        $houseHolders = HouseHolder::all();

        if($request->name != null){
            $houseHolders = $houseHolders->where('name', 'LIKE', "%{$request->name}%");
        }

        $houseHolders = $houseHolders->paginate(self::PAGINATE);
        return $houseHolders;
    }

    public function getHouseHolderById($id)
    {
        $houseHolder = HouseHolder::find($id);
        return $houseHolder;
    }

    public function createHouseHolder($request)
    {
        $code = $this->generateHouseHolderCode();

        HouseHolder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'tax_code' => $request->tax_code ?? '',
            'type' => $request->type ?? '',
            'status' => $request->status,
            'code' => $code,
            'description' => $request->description ?? '',
        ]);
        return true;
    }

    public function generateHouseHolderCode()
    {
        $currentYear = now()->year;
        $lastHouseHolder = HouseHolder::whereYear('created_at', $currentYear)->latest()->first();

        if ($lastHouseHolder) {
            $lastCode = $lastHouseHolder->code;
            $lastNumber = (int) substr($lastCode, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $currentYear . '-HH' . $newNumber;
    }

    public function updateHouseHolder($request, $id)
    {
        $houseHolder = HouseHolder::find($id);
        $houseHolder->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'tax_code' => $request->tax_code ?? '',
            'type' => $request->type ?? '',
            'status' => $request->status,
            'description' => $request->description ?? '',
        ]);
        return true;
    }
}
