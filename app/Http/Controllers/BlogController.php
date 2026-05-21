<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\BaseController;
use App\Blog\Services\BlogService;

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
