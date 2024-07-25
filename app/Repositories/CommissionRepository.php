<?php
namespace App\Repositories;

use App\Models\Commission;
use App\Models\Commissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommissionRepository{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListCommission($request){
        $commission = Commission::query();
        if($request->name != null){
            $commission = $commission->where('name', 'LIKE', "%{$request->name}%");
        }
        $commission = $commission->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $commission;
    }

    public function getCommissionById($id){
        $commission = Commission::find($id);
        return $commission;
    }

    public function createCommission($request){
        $commission = new Commission();
        $commission->name = $request->name;
        $commission->min_price = $request->min_price;
        $commission->max_price = $request->max_price;
        $commission->percent = $request->percent;
        $commission->save();
        return true;
    }

    public function updateCommission($request, $id){
        $commission = Commission::find($id);
        $commission->name = $request->name;
        $commission->min_price = $request->min_price;
        $commission->max_price = $request->max_price;
        $commission->percent = $request->percent;
        $commission->save();
        return true;
    }

    public function deleteCommission($id){
        $commission = Commission::find($id);
        $commission->delete();
        return true;
    }
}
