<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunucu Hatası | 500</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        .error-code {
            font-size: 120px;
            font-weight: 700;
            line-height: 1;
            margin: 0;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(56, 189, 248, 0.2);
            animation: pulse 2s infinite ease-in-out;
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            margin: 20px 0 10px;
            color: #f1f5f9;
        }

        .error-message {
            font-size: 16px;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-block;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            background: #4f46e5;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.39);
        }

        .btn-home:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .illustration {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Modern SVG Icon -->
        <svg class="illustration" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="url(#gradient)" stroke-width="1.5">
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#38bdf8" />
                    <stop offset="100%" stop-color="#818cf8" />
                </linearGradient>
            </defs>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>

        <h1 class="error-code">500</h1>
        <h2 class="error-title">Sunucu Hatası</h2>
        <p class="error-message">
            Beklenmedik bir sorunla karşılaştık ve sistem şu anda isteğinizi işleyemiyor. Teknik ekibimiz durumdan haberdar edildi ve çözmek için çalışıyor.
        </p>
        <a href="/" class="btn-home">Ana Sayfaya Dön</a>
        
        @if(config('app.debug') && !request()->wantsJson())
            <div style="margin-top:30px; padding:15px; background:rgba(0,0,0,0.3); border-radius:8px; text-align:left; font-size:12px; color:#cbd5e1; border:1px solid #334155;">
                <strong style="color: #fbbf24;">⚠️ Geliştirici Notu:</strong> Şu anda <code>APP_DEBUG=true</code> olduğu için asıl hatanın detaylarını görmeniz gerekir. Eğer bir tarayıcıdan bağlanıyorsanız hata anında Spatie Ignition ekranı açılacaktır. Bu sayfa sadece Canlı Ortamdaki (Production) kullanıcıların göreceği sayfanın tasarımıdır.
            </div>
        @endif
    </div>

</body>
</html>
