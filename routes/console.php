<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 1. Geliştirici Temizliği Komutu (Tüm önbellekleri sıfırlar)
Artisan::command('dev:clear', function () {
    $this->call('optimize:clear');
    $this->info('Tüm önbellekler (Cache, View, Route, Config) başarıyla temizlendi!');
})->purpose('Geliştirme ortamındaki tüm önbellekleri temizler.');

// 2. Yönetici (Admin) Oluşturma Komutu
Artisan::command('admin:create {email} {--password=password123}', function ($email) {
    // Güvenlik Kontrolü: Sadece 'local' (geliştirme) ortamında çalışsın
    if (!app()->environment('local')) {
        $this->error('GÜVENLİK UYARISI: Bu komut sadece geliştirme (local) ortamında çalıştırılabilir!');
        return;
    }

    try {
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Sistem Yöneticisi',
                'password' => bcrypt($this->option('password')),
            ]
        );
        $this->info("Yönetici hesabı {$email} başarıyla oluşturuldu/güncellendi.");
        $this->info("Şifre: " . $this->option('password'));
    } catch (\Exception $e) {
        $this->error('Kullanıcı oluşturulurken bir hata oluştu. Veritabanı tabloları oluşturulmamış (migrate edilmemiş) olabilir.');
        $this->error('Hata: ' . $e->getMessage());
    }
})->purpose('Sisteme hızlıca yeni bir yönetici ekler.');

// 3. Sistem İstatistikleri (Health Check)
Artisan::command('system:stats', function () {
    try {
        $userCount = DB::table('users')->count();
        $this->info("--- SİSTEM İSTATİSTİKLERİ ---");
        $this->line("Kayıtlı Kullanıcı: {$userCount}");
        
        // İleride posts (yazılar) veya comments (yorumlar) tabloları oluştuğunda bu satırları aktif edebilirsiniz:
        /*
        $postCount = DB::table('posts')->count();
        $this->line("Blog Yazısı: {$postCount}");
        */
        
    } catch (\Exception $e) {
        $this->error('Veritabanına ulaşılamadı. Lütfen tabloları migrate ettiğinizden emin olun.');
    }
})->purpose('Sistemdeki güncel istatistikleri gösterir.');
