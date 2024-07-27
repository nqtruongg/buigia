<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    const DANG_TRONG = 0;
    const DA_DAT_COC = 1;
    const DA_DUOC_THUE = 2;

    use HasFactory, SoftDeletes;

    protected $table = 'services';

    protected $guarded = [];

    public static function checkType($type)
    {
        $html = '';
        switch ($type) {
            case self::DANG_TRONG:
                $html .= "<span>" . trans('language.service.not_extend') . "</span>";
                break;
            case self::DA_DAT_COC:
                $html .= "<span>" . trans('language.service.deposited') . "</span>";
                break;
            case self::DA_DUOC_THUE:
                $html .= "<span>" . trans('language.service.extend') . "</span>";
                break;
            default:
                $html .= "<span>" . trans('language.valuable') . "</span>";
                break;
        }
        return $html;
    }

    public function serviceImages()
    {
        return $this->hasMany(ServiceImage::class, 'service_id');
    }

    public function houseHolder()
    {
        return $this->belongsTo(HouseHolder::class, 'house_holder_id');
    }


    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryService::class, 'service_and_categoryservices', 'service_id', 'categoryService_id');
    }

}
