<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            ['key' => 'first_post', 'name' => 'First Post', 'description' => 'İlk blog yazınızı veya forum konunuzu oluşturdunuz.', 'icon' => 'emoji_events'],
            ['key' => 'active_chatter', 'name' => 'Active Chatter', 'description' => '5 veya daha fazla yorum yaptınız.', 'icon' => 'chat'],
            ['key' => 'core_contributor', 'name' => 'Core Contributor', 'description' => 'Yönetici veya geliştirici ekibine katıldınız.', 'icon' => 'shield'],
            ['key' => 'popular_author', 'name' => 'Popular Author', 'description' => 'Bir gönderiniz çok sayıda beğeni aldı.', 'icon' => 'star'],
            ['key' => 'problem_solver', 'name' => 'Problem Solver', 'description' => 'Forumda bir cevabınız çözüm olarak işaretlendi.', 'icon' => 'check_circle'],
            ['key' => 'consistent_writer', 'name' => 'Consistent Writer', 'description' => '7 günlük seriye ulaştınız.', 'icon' => 'local_fire_department'],
            ['key' => 'trend_setter', 'name' => 'Trend Setter', 'description' => 'Açtığınız bir konu 10\'dan fazla yanıt aldı.', 'icon' => 'trending_up'],
            ['key' => 'helpful_member', 'name' => 'Helpful Member', 'description' => 'Cevaplarınızla çok sayıda "faydalı" oyu aldınız.', 'icon' => 'thumb_up'],
            ['key' => 'early_adopter', 'name' => 'Early Adopter', 'description' => 'Platformun ilk üyelerinden birisiniz.', 'icon' => 'psychiatry'],
            ['key' => 'knowledge_seeker', 'name' => 'Knowledge Seeker', 'description' => 'Forumda 10 farklı konuya katılım sağladınız.', 'icon' => 'menu_book'],
            ['key' => 'community_pillar', 'name' => 'Community Pillar', 'description' => 'Platformda 1 yılı tamamladınız.', 'icon' => 'account_balance'],
            ['key' => 'master_creator', 'name' => 'Master Creator', 'description' => 'Toplamda 50 içerik oluşturdunuz.', 'icon' => 'workspace_premium'],
        ];

        foreach ($achievements as $ach) {
            Achievement::updateOrCreate(['key' => $ach['key']], $ach);
        }
    }
}
