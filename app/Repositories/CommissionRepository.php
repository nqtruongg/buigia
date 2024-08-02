<?php
namespace App\Repositories;

use App\Models\Commission;
use App\Models\CommissionBonus;
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
        if($request->percent != null){
            $commission = $commission->where('percent', 'LIKE', "%{$request->percent}%");
        }
        $commission = $commission->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $commission;
    }

    public function getListCommissionBonus($request){
        $commissionBonus = CommissionBonus::query()
        ->join('users', 'commission_bonuses.user_id', '=', 'users.id') // Thực hiện join với bảng users
        ->join('customer_service', 'commission_bonuses.customer_service_id', '=', 'customer_service.id') // Join với bảng customer_service
        ->join('services', 'customer_service.service_id', '=', 'services.id') // Join với bảng service
        ->select('commission_bonuses.*'); // Chọn tất cả các trường từ bảng commission_bonuses

    if ($request->first_name != null) {
        $commissionBonus = $commissionBonus->where('users.first_name', 'LIKE', "%{$request->first_name}%");
    }
    if ($request->last_name != null) {
        $commissionBonus = $commissionBonus->where('users.last_name', 'LIKE', "%{$request->last_name}%");
    }
    if ($request->phone != null) {
        $commissionBonus = $commissionBonus->where('users.phone', 'LIKE', "%{$request->phone}%");
    }
    if ($request->service != null) {
        $commissionBonus = $commissionBonus->where('services.name', 'LIKE', "%{$request->service}%");
    }
    if($request->date != null){
        $commissionBonus = $commissionBonus->where('commission_bonuses.date', 'LIKE', "%{$request->date}%");
    }

    $commissionBonus = $commissionBonus->orderBy('commission_bonuses.id', 'desc')
        ->paginate(self::PAGINATE);

    return $commissionBonus;
    }

    public function getCommissionById($id){
        $commission = Commission::find($id);
        return $commission;
    }

    public function createCommission($request){
        $commission = new Commission();
        $commission->name = $request->name;
        // $commission->min_price = $request->min_price;
        // $commission->max_price = $request->max_price;
        $commission->percent = $request->percent;
        $commission->save();
        return true;
    }

    public function updateCommission($request, $id){
        $commission = Commission::find($id);
        $commission->name = $request->name;
        // $commission->min_price = $request->min_price;
        // $commission->max_price = $request->max_price;
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
