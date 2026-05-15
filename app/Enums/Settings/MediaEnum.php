<?php

namespace App\Enums\Settings;

enum MediaEnum: string
{
      case Favicon           = 'media.favicon';
      case Name              = 'media.name';
      case Description       = 'media.description';
      case Tagline           = 'media.tagline';
      case LightmodeLogo     = 'media.lightmode_logo';
      case DarkmodeLogo      = 'media.darkmode_logo';

      case MaxFileSize       = 'media.max_file_size';
      case MaxFiles          = 'media.max_files';
      case AllowMediaTypes   = 'media.allowed_media_types';
      
      case WatermarkEnabled  = 'media.watermark_enabled';
      case WatermarkImage    = 'media.watermark_image';
      case WatermarkPosition = 'media.watermark_position';
      case WatermarkOpacity  = 'media.watermark_opacity';

}