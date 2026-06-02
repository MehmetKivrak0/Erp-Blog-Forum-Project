<?php

namespace App\Core\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EloquentRepositoryInterface
{
    /**
     * Tüm kayıtları ilişkileriyle (N+1 optimizasyonlu) birlikte getirir.
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Kayıtları sayfalayarak (paginate) getirir.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Belirli kriterlere göre (where) filtreleyerek kayıtları getirir.
     */
    public function findBy(array $criteria, array $columns = ['*'], array $relations = []): Collection;

    /**
     * ID'ye göre kayıt bulur, bulamazsa hata fırlatır.
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    /**
     * Belirtilen kriterlere göre kaydı bulur, yoksa yeni kayıt oluşturur.
     */
    public function firstOrCreate(array $attributes, array $values = []): Model;

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