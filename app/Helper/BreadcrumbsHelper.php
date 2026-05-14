<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class BreadcrumbsHelper
{
    public static function generateBreadcrumbsURL(Model $model, string $title, string $action){

        $baseSegment = method_exists($model, 'adminBasePath')
            ? $model->adminBasePath()
            : strtolower(class_basename($model) . "s");

        $label = ucfirst(class_basename($model) . "s");

        return [
             url("/admin/{$baseSegment}/")              => $label,
             url("/admin/{$baseSegment}/" . $model->id) => $title,
             ''                                         => $action
        ];
    }
}