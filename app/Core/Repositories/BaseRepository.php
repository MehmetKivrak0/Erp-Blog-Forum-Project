<?php

namespace App\Core\Repositories;

use App\Core\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;
    
    /**
     * BaseRepository constructor.
     * Hangi model ile çalışacağımızı dışarıdan alıyoruz (Örn: Post, ForumTopic)
     *
     * @param Model $model
     */

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Tüm kayıtları, istenilen sütunlar ve ilişkilerle (N+1 optimizasyonu) getirir.
     */

   public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }
    /**
     * ID'ye göre kaydı bulur. Bulamazsa Laravel'in ModelNotFound hatasını fırlatır.
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }
    /**
     * Yeni kayıt oluşturur ve oluşturulan taze veriyi geri döner.
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        
        return $model->fresh();
    }

    /**
     * Mevcut kaydı bulup günceller.
     */
    public function update(int $modelId, array $payload): bool
    {
        $model = $this->findById($modelId);
        
        return $model->update($payload);
    }

    /**
     * Kaydı siler (Eğer modelde SoftDeletes trait'i varsa yazılımsal siler).
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }
}
