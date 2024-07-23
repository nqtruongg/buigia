<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    const VIEW = 0;
    const ADD = 1;
    const EDIT = 2;
    const DELETE = 3;
    const EXPORT = 4;

    protected $table = 'permissions';

    protected $guarded = [];

    public static function checkTypePermission($type)
    {
        $html = '';
        switch ($type) {
            case self::VIEW:
                $html .=  '<span>' . trans('language.permission.view') . '</span>';
                break;
            case self::ADD:
                $html .= '<span>' . trans('language.permission.add') . '</span>';
                break;
            case self::EDIT:
                $html .= '<span>' . trans('language.permission.edit') . '</span>';
                break;
            case self::DELETE:
                $html .= '<span>' . trans('language.permission.delete') . '</span>';
                break;
            case self::EXPORT:
                $html .= '<span>' . trans('language.permission.export') . '</span>';
                break;
            default:
                break;
        }
        return $html;
    }
}
