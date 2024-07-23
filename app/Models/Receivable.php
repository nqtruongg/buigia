<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receivable extends Model
{
    use HasFactory, SoftDeletes;

    const CONG_NO_MOI = 0;
    const CNGH = 1;

    protected $table = 'receivables';

    protected $guarded = [];

    public static function checkType($type)
    {
        $html = '';
        switch ($type) {
            case self::CONG_NO_MOI:
                $html .= "<span>" . trans('language.receivable.cnm') . "</span>";
                break;
            case self::CNGH:
                $html .= "<span>" . trans('language.receivable.cngh') . "</span>";
                break;
            default:
                $html .= "<span>" . trans('language.valuable') . "</span>";
                break;
        }
        return $html;
    }
}
