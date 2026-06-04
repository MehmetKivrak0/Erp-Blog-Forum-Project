# ERP, Blog ve Forum Projesi

Bu proje, Kurumsal Kaynak Planlama (ERP), Blog ve Forum yönetimini tek bir çatı altında toplayan, modüler mimariye sahip kapsamlı bir Laravel uygulamasıdır.

## 🚀 Proje Hakkında

Modern web standartlarına uygun olarak geliştirilmiş bu sistem, işletmelerin iç süreçlerini (ERP) yönetirken aynı zamanda dışa dönük bir iletişim kanalı (Blog) ve topluluk etkileşimi (Forum) kurmasına olanak tanır. Uygulama, kodun sürdürülebilirliğini ve yönetilebilirliğini artırmak amacıyla Domain-Driven Design (DDD) prensiplerinden ilham alınarak modüler bir yapıda tasarlanmıştır.

## 📁 Modüler Mimari (Domain-Driven Structure)

Projenin `app/` dizini altındaki ana modüller şunlardır:

- **Auth**: Kullanıcı kimlik doğrulama, yetkilendirme (authorization) ve oturum yönetimi işlemleri.
- **Blog**: İçerik yönetimi, makale yayınlama, kategori oluşturma ve SEO dostu blog işlemleri.
- **Forum**: Kullanıcıların konular (topics) açıp tartışabildiği, topluluk odaklı etkileşim alanı.
- **Comment**: Blog yazıları ve forum gönderileri için ortak olarak kullanılabilen gelişmiş yorum sistemi.
- **Core**: Uygulamanın temel bileşenleri, ortak arayüzler (Interfaces), traitler ve altyapı sınıfları.
- **Services**: Karmaşık iş mantığının (Business Logic) yürütüldüğü, controller sınıflarının yükünü hafifleten servis katmanı.
- **Support**: Yardımcı fonksiyonlar (Helpers), DTO (Data Transfer Object) yapıları ve dışa bağımlılığı azaltan destekleyici sınıflar.

## 🛠️ Kullanılan Teknolojiler

- **Backend:** PHP 8.3+, Laravel 13.x
- **Veritabanı:** MySQL / PostgreSQL (veya desteklenen herhangi bir PDO sürücüsü)
- **Frontend / Asset Yönetimi:** Vite, npm (Frontend frameworklerine hazır altyapı)

## ⚙️ Kurulum

Projeyi yerel ortamınızda çalıştırmak için aşağıdaki adımları izleyebilirsiniz:

1. **Projeyi Klonlayın:**
   ```bash
   git clone https://github.com/MehmetKivrak0/Erp-Blog-Forum-Project.git
   cd Erp-Blog-Forum-Project
   ```

2. **Bağımlılıkları Yükleyin:**
   ```bash
   composer install
   npm install
   ```

3. **Çevre Değişkenlerini Ayarlayın:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Veritabanı Ayarlarını Yapın:**
   `.env` dosyanızdaki `DB_*` ön ekli veritabanı bağlantı bilgilerini kendi sisteminize göre güncelleyin. Ardından veritabanını oluşturun:
   ```bash
   php artisan migrate --seed
   ```

5. **Uygulamayı Çalıştırın:**
   Terminal üzerinden servisleri başlatın:
   ```bash
   php artisan serve
   ```
   Ayrı bir terminalde assetleri derlemek için:
   ```bash
   npm run dev
   ```

## 📝 Lisans

Bu proje açık kaynaklı bir yazılımdır. Detaylı bilgi için repository içeriğini inceleyebilirsiniz.
