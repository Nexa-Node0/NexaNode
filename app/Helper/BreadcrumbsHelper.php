<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class BreadcrumbsHelper
{
    public static function generateBreadcrumbsURL(Model $model, string $title, string $action){
        $baseClass = strtolower(class_basename($model) . "s");
        return [
             url("/admin/{$baseClass}/") => ucfirst($baseClass),
             url("/admin/{$baseClass}" . $model->id) => $title,
             '' => $action
        ];
    }
}