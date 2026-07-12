<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

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
        if (Schema::hasTable('settings')) {
            try {
                $settings = Setting::pluck('value', 'key')->all();

                if (!empty($settings['smtp_host'])) {
                    $encryption = $settings['smtp_encryption'] ?? 'none';
                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.host' => $settings['smtp_host'],
                        'mail.mailers.smtp.port' => $settings['smtp_port'] ?? 587,
                        'mail.mailers.smtp.username' => $settings['smtp_username'] ?? '',
                        'mail.mailers.smtp.password' => $settings['smtp_password'] ?? '',
                        'mail.mailers.smtp.encryption' => $encryption !== 'none' ? $encryption : null,
                        'mail.from.address' => $settings['smtp_from_address'] ?? ($settings['smtp_username'] ?? 'hello@example.com'),
                        'mail.from.name' => $settings['smtp_from_name'] ?? config('app.name'),
                    ]);
                }
            } catch (\Exception $e) {
                // Prevent app from breaking during migrations or build
            }
        }
    }
}
