<?php

namespace App\Enums\Settings;

enum SEOEnum: string 
{
   case MetaTitle              = 'seo.meta_title';
   case MetaKeywords           = 'seo.meta_keywords';
   case MetaDescription        = 'seo.meta_description';
   case Index                  = 'seo.index';
   case Follow                 = 'seo.follow';
   case SiteMapEnabled         = 'seo.sitemap_enabled';
   case SiteMapURL             = 'seo.sitemap_url';
   case CanonicalURL           = 'seo.canonical_url';
   
   case OGTitle                = 'seo.og_title';
   case OGType                 = 'seo.og_type';
   case OGDescription          = 'seo.og_description';
   case OGURL                  = 'seo.og_url';
   case OGSiteName             = 'seo.og_site_name';
   case OGImage                = 'seo.og_image';
   
   case TwitterCard            = 'seo.twitter_card';
   case TwitterSite            = 'seo.twitter_site';
   case TwitterCreator         = 'seo.twitter_creator';
   case TwitterTitle           = 'seo.twitter_title';
   case TwitterDescription     = 'seo.twitter_description';
   case TwitterImage           = 'seo.twitter_image';

   case GoogleAnalyticsID      = 'seo.google_analytics_id';
   case GoogleTagManagerID     = 'seo.google_tag_manager_id';
   case GoogleSiteVerification = 'seo.google_site_verification';

   case FacebookPixelID        = 'seo.facebook_pixel_id';
   case BingSiteVerification   = 'seo.bing_site_verification';
   case TikTokPixelID          = 'seo.tiktok_pixel_id';

   case SchemaType             = 'seo.schema_type';
   case SchemaName             = 'seo.schema_name';
   case SchemaURL              = 'seo.schema_url';
   case SchemaEmail            = 'seo.schema_email';
   case SchemaPhone            = 'seo.schema_phone';
   case SchemaAddress          = 'seo.schema_address';
   case SchemaLogo             = 'seo.schema_logo';

}