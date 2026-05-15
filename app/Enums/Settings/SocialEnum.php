<?php

namespace App\Enums\Settings;

enum SocialEnum: string 
{
    case Facebook  = 'social.facebook';
    case Instagram = 'social.instagram';
    case Twitter   = 'social.twitter';
    case Youtube   = 'social.youtube';
    case TikTok    = 'social.tiktok';
    case Vimeo     = 'social.vimeo';

    case WhatsApp  = 'social.whatsapp';
    case Telegram  = 'social.telegram';
    case Discord   = 'social.discord';
    case LinkedIn  = 'social.linkedin';
    case Github    = 'social.github';
    case Dribble   = 'social.dribble';
    case Behance   = 'social.behance';

    case Pinterest = 'social.pinterest';
    case Snapchat  = 'social.snapchat';
    case Threads   = 'social.threads';
    case Reddit    = 'social.reddit';
}
