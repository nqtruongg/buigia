<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    const DANG_BAN = 0;
    const DA_DAT_COC = 1;
    const DA_BAN = 2;
    use HasFactory, SoftDeletes;

    protected $table = 'services';

    protected $guarded = [];

    public static function checkType($type)
    {
        $html = '';
        switch ($type) {
            case self::DANG_BAN:
                $html .= "<span>" . trans('language.service.not_extend') . "</span>";
                break;
            case self::DA_DAT_COC:
                $html .= "<span>" . trans('language.service.deposited') . "</span>";
                break;
            case self::DA_BAN:
                $html .= "<span>" . trans('language.service.extend') . "</span>";
                break;
            default:
                $html .= "<span>" . trans('language.valuable') . "</span>";
                break;
        }
        return $html;
    }

    public function houseHolder()
    {
        return $this->belongsTo(HouseHolder::class, 'house_holder_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
