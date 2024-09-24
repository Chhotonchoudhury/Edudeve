<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CompanyInfo;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
    // Load company info into config
    $companyInfo = CompanyInfo::first();

    config([
      'app.company_name' => $companyInfo ? $companyInfo->company_name : 'Edudeve',
      'app.logo' => $companyInfo ? asset('storage/' . $companyInfo->small_logo) : asset('assets/img/logos/logo2.png'),
      'app.favicon' => $companyInfo
        ? asset('storage/' . $companyInfo->favicon)
        : asset('assets/img/favicon/favicon1.png'),
    ]);

    //this is for the email settings
    $settings = EmailSetting::first();

    if ($settings) {
      Config::set('mail.host', $settings->smtp_host);
      Config::set('mail.port', $settings->smtp_port);
      Config::set('mail.username', $settings->smtp_user);
      Config::set('mail.password', $settings->smtp_password);
      Config::set('mail.encryption', $settings->smtp_encryption);
      Config::set('mail.from.address', $settings->sender_email);
      Config::set('mail.from.name', $settings->sender_name);
    }

    // Debugging
  }
}
