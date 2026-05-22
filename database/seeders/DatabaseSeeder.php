<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Core\Enums\UserRole;
use App\Core\Enums\PostStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Categories
        $categories = [
            ['name' => 'General', 'slug' => 'general', 'type' => 'blog'],
            ['name' => 'Rust', 'slug' => 'rust', 'type' => 'blog'],
            ['name' => 'React', 'slug' => 'react', 'type' => 'blog'],
            ['name' => 'Rust Developers', 'slug' => 'rust-dev', 'type' => 'forum'],
            ['name' => 'React Specialists', 'slug' => 'react-specialists', 'type' => 'forum'],
            ['name' => 'Node API Scalers', 'slug' => 'node-api', 'type' => 'forum'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Fetch categories to link posts
        $rustCategory = Category::where('slug', 'rust')->first();
        $reactCategory = Category::where('slug', 'react')->first();
        $generalCategory = Category::where('slug', 'general')->first();

        // 2. Seed Users
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@devnexus.io'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'status' => 'active',
            ]
        );

        $moderatorUser = User::updateOrCreate(
            ['email' => 'sarah.j@techcloud.com'],
            [
                'name' => 'Sarah Jenkins',
                'password' => Hash::make('password'),
                'role' => UserRole::MODERATOR,
                'status' => 'active',
            ]
        );

        $developerUser = User::updateOrCreate(
            ['email' => 'mike@ross.dev'],
            [
                'name' => 'Mike Ross',
                'password' => Hash::make('password'),
                'role' => UserRole::DEVELOPER,
                'status' => 'active',
            ]
        );

        $regularUser = User::updateOrCreate(
            ['email' => 'alex@devnexus.io'],
            [
                'name' => 'Alex Coder',
                'password' => Hash::make('password'),
                'role' => UserRole::USER,
                'status' => 'active',
            ]
        );

        // 3. Seed Posts
        // Seeding some published posts
        Post::updateOrCreate(
            ['slug' => 'mastering-rust-lifetimes-deep-dive'],
            [
                'user_id' => $regularUser->id,
                'category_id' => $rustCategory->id,
                'title' => 'Mastering Rust Lifetimes: A Deep Dive',
                'content' => "Rust's ownership model is powerful but lifetimes can be tricky for newcomers. Lifetimes are the compiler's way of ensuring that all references are valid and don't point to freed memory. In this article, we explore generic lifetime annotations, subtyping, and common lifetime patterns...",
                'status' => PostStatus::PUBLISHED,
            ]
        );

        // Seeding some pending posts (for moderation queue)
        Post::updateOrCreate(
            ['slug' => 'best-practices-react-19-concurrent-mode'],
            [
                'user_id' => $regularUser->id,
                'category_id' => $reactCategory->id,
                'title' => 'Best practices for React 19 concurrent mode?',
                'content' => "I'm having issues with selective hydration in the new beta releases. When enabling concurrent rendering and server-side components in React 19, selective hydration causes mismatch warnings on nested dynamic containers. Here is the reproduction stack...",
                'status' => PostStatus::PENDING,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'why-clean-code-is-a-myth'],
            [
                'user_id' => $developerUser->id,
                'category_id' => $generalCategory->id,
                'title' => 'Why Clean Code is a Myth',
                'content' => "Controversial opinion: your perfectionism is killing the product. We focus too much on abstractions and DRY patterns that make the code unreadable. Sometimes duplication is cheaper than the wrong abstraction. Let's look at real-world examples...",
                'status' => PostStatus::PENDING,
            ]
        );
    }
}
