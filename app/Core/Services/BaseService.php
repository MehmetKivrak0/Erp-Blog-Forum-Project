<?php

namespace App\Core\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BaseService
{
    /**
     * İş mantığını güvenli bir şekilde (Database Transaction ile) yürütür.
     * "Ya hep ya hiç" kuralı: Hata olursa tüm SQL işlemlerini geri alır (Rollback).
     *
     * @param callable $callback Yapılacak asıl işlemler (Anonim fonksiyon)
     * @param string $errorMessage Hata anında fırlatılacak mesaj
     * @return mixed
     * @throws Exception
     */
    protected function executeSafe(callable $callback, string $errorMessage = 'İşlem sırasında bir hata oluştu.')
    {
        // Veritabanını kilitle ve izlemeye başla
        DB::beginTransaction();

        try {
            // Fonksiyonun içindeki işlemleri çalıştır
            $result = $callback();

            // Her şey sorunsuzsa veritabanına kalıcı olarak yaz
            DB::commit();

            return $result;
            
        } catch (Exception $e) {
            // En ufak bir hata çıkarsa, yapılan tüm işlemleri geri al (Rollback)
            DB::rollBack();

            // Hatayı log dosyasına yaz (Böylece kullanıcı görmez ama biz arkada hatayı buluruz)
            Log::error($errorMessage . ' | Sistem Hatası: ' . $e->getMessage());

            // Hatayı dışarı fırlat ki API/Controller bunu yakalayıp kullanıcıya temiz bir mesaj dönsün
            throw new Exception($errorMessage);
        }
    }
}