<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    const DANG_TRONG = 0;
    const DA_GIU_CHO = 1;
    const DA_COC = 2;
    const DA_CHO_THUE = 3;
    const DA_HUY = 4;

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
            case self::DA_GIU_CHO:
                $html .= "<span>" . trans('language.service.reserve') . "</span>";
                break;
            case self::DA_COC:
                $html .= "<span>" . trans('language.service.staked') . "</span>";
                break;
            case self::DA_CHO_THUE:
                $html .= "<span>" . trans('language.service.extend') . "</span>";
                break;
            case self::DA_HUY:
                $html .= "<span>" . trans('language.service.cancelled') . "</span>";
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

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

}
