<?php
namespace App\Repositories;


use App\Models\HouseHolder;
use Illuminate\Support\Facades\Storage;

class HouseHolderRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;


    public function getListHouseHolder($request)
    {
        $houseHolders = HouseHolder::query();

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

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/householders');
            $request->image_path = Storage::url($path);
        }

        HouseHolder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'image_path' => $request->image_path,
            'tax_code' => $request->tax_code ?? '',
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

        if ($request->hasFile('image_path')) {
            if ($houseHolder->image_path) {
                $imagePath = 'public/householders/' . basename($houseHolder->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->store('public/householders');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $houseHolder->image_path;
        }

        $houseHolder->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'image_path' => $imagePath,
            'tax_code' => $request->input('tax_code', ''),
            'code' => $houseHolder->code, // Ensure 'code' is not changed
            'description' => $request->input('description', ''),
        ]);

        return true;
    }
}
