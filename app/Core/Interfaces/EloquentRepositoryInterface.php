<?php

namespace App\Core\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface EloquentRepositoryInterface
{
    /**
     * Tüm kayıtları ilişkileriyle (N+1 optimizasyonlu) birlikte getirir.
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * ID'ye göre kayıt bulur, bulamazsa hata fırlatır.
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    /**
     * Yeni bir kayıt oluşturur.
     */
    public function create(array $payload): ?Model;

    /**
     * Mevcut bir kaydı günceller.
     */
    public function update(int $modelId, array $payload): bool;

    /**
     * Bir kaydı siler (Soft Delete trait'i varsa yazılımsal siler).
     */
    public function deleteById(int $modelId): bool;
}