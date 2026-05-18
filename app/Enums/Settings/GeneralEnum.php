<?php

namespace App\Enums\Settings;

enum GeneralEnum: string
{
    case Tagline = 'general.tagline';
    case CopyrightText = 'general.copyright_text';
    case SiteDescription = 'general.site_description';
    case Phone = 'general.phone';
    case SupportedEmail = 'general.support_email';
    case WebsiteURL = 'general.website_url';
    case Address = 'general.address';

    case Timezone = 'general.timezone';
    case DateFormat = 'general.date_format';
    case TimeFormat = 'general.time_format';
    case Language = 'general.language';
    case Currency = 'general.currency';
    case CurrencyPosition = 'general.currency_position';
    case MaintenanceMode = 'general.maintenance_mode';
    case RegistrationEnabled = 'general.registration_enabled';
    case DarkModeEnabled = 'general.dark_mode_enabled';
    case CookieConsentEnabled = 'general.cookie_consent_enabled';
    case NewsletterEnabled = 'general.newsletter_enabled';
    case BlogEnabled = 'general.blog_enabled';
}
