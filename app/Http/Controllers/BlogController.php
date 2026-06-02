<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\BaseController;
use App\Blog\Services\BlogService;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Blog\DTOs\CreatePostDTO;
use App\Blog\DTOs\UpdatePostDTO;
class BlogController extends BaseController
{
    public function __construct(protected BlogService $blogService)
    {
    }

    public function index()
    {
        // Repository'deki özel fonksiyonumuzu çağırıyoruz
        $posts = $this->blogService->getPublishedPosts();
        return $this->sendSuccess($posts, 'Blog yazıları başarıyla listelendi.');
    }

    public function store(StorePostRequest $request)
    {
        try {
            $dto = CreatePostDTO::fromRequest($request);
            $post = $this->blogService->createPost($dto);
            return $this->sendSuccess($post, 'Blog yazısı başarıyla oluşturuldu.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Kayıt işlemi başarısız.', [$e->getMessage()], 500);
        }
    }

    public function update(UpdatePostRequest $request, int $id)
    {
        try {
            $dto = UpdatePostDTO::fromRequest($request, $id);
            $post = $this->blogService->updatePost($dto);
            return $this->sendSuccess($post, 'Blog yazısı başarıyla güncellendi.');
        } catch (\Exception $e) {
            return $this->sendError('Güncelleme işlemi başarısız.', [$e->getMessage()], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->blogService->deletePost($id);
            return $this->sendSuccess(null, 'Blog yazısı başarıyla silindi.');
        } catch (\Exception $e) {
            return $this->sendError('Silme işlemi başarısız.', [$e->getMessage()], 500);
        }
    }
}
