<?php

namespace App\Core\Traits;

use Illuminate\Support\Str;

trait SlugGeneratorTrait
{
    /**
     * Başlığa (title) göre veritabanında benzersiz bir slug oluşturur.
     * Eğer aynı isimde varsa sonuna sayı ekler (Örn: yazi-basligi, yazi-basligi-1, yazi-basligi-2).
     *
     * @param string $title Örn: "Benim İlk Yazım"
     * @param string $column Slug sütununun adı (genelde 'slug')
     * @return string Örn: "benim-ilk-yazim-1"
     */
    public function generateUniqueSlug(string $title, string $column = 'slug'): string
    {
        // Başlığı küçük harfe çevirip Türkçe karakterleri düzeltir
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Veritabanında (Bu Trait'i kullanan Model'de) bu slug var mı diye sürekli kontrol et
        while (self::where($column, $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
