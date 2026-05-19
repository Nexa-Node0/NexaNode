<?php
namespace App\Helper;

use App\Enums\Settings\Puppeteer\FileFormatEnum;

class FilamentBrowsershotHelper
{

    //browsershot configurations
    private $format     = FileFormatEnum::A4;
    private $margin_tp  = 0;
    private $margin_bt  = 0;
    private $margin_rt  = 0;
    private $margin_lt  = 0;
    private $landscape  = false;
    private $scale      = 1;
    private $background = true;
    private $eager      = true;


    //table data
    private $table_data = null;
    
    //company Data
    private $company_logo = setting(MediaEnum::LightmodeLogo->value);
    private $company_brand = setting(MediaEnum::Name->value);

}
