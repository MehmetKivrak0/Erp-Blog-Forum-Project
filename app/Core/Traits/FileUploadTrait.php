<?php

namespace App\Core\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    /**
     * Gelen dosyayı sisteme yükler ve yolunu döndürür.
     * İsteğe bağlı olarak eski dosyayı siler.
     *
     * @param UploadedFile $file Yüklenen dosya
     * @param string $path Hangi klasöre kaydedileceği (Örn: 'posts', 'avatars')
     * @param string|null $oldFile Eğer güncelleniyorsa eski dosyanın silinmesi için yolu
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $path = 'uploads', ?string $oldFile = null): string
    {
        // Eğer eski bir dosya varsa ve diskte mevcutsa sil (sunucuyu çöpten kurtar)
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        // Dosya adı çakışmalarını önlemek için benzersiz bir isim oluştur
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Dosyayı public diskine belirtilen klasör altında kaydet ve yolunu döndür
        return $file->storeAs($path, $fileName, 'public');
    }
}
