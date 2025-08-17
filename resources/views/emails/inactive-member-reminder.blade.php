<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder: Kamu tidak aktif belajar selama {{ $inactiveDays }} hari!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color:rgb(211, 211, 211);
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 80px;
            height: 80px;
            background-color: #ffffff;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 10px;
            overflow: hidden;
        }
        .logo-content {
            text-align: center;
            padding-top: 15px;
        }
        .logo-content img {
            width: 90%;
            height: 90%;
            object-fit: contain;
        }
        .content {
            padding: 30px 20px;
            border-radius: 10px;
            margin: 20px;
        }
        .greeting {
            color: #8b0000;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .message {
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            background-color: #6c757d;
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            text-align: center;
            margin: 0 auto;
        }
        .button:hover {
            background-color: #5a6268;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #000000;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <div class="logo-content">
                    <img src="{{ asset('qacnew.png') }}" alt="QAC Logo">
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">Assalaamu'alaikum.</div>
            <div class="message">
                Dear {{ $member->full_name }}, kami melihat kamu belum aktif belajar kelas selama {{ $inactiveDays }} hari, yuk lanjutkan belajarnya untuk terus Tadabbur dan belajar Bahasa Arab Al-Qur'an 😊
            </div>
            <div style="text-align: center;">
                <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            Salam, QAC Jakarta
        </div>
    </div>
</body>
</html>
