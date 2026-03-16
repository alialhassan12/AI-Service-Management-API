<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Abidjan.ai</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #091236, #1E215D);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 1px;
            background: -webkit-linear-gradient(#00C9FF, #92FE9D);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .content h2 {
            margin-top: 0;
            font-size: 22px;
            color: #1E215D;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .cta-container {
            text-align: center;
            margin: 35px 0;
        }
        .cta-button {
            background: linear-gradient(135deg, #00C9FF, #92FE9D);
            color: #091236 !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 10px rgba(0, 201, 255, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 201, 255, 0.4);
        }
        .features {
            background-color: #f8fbfc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #00C9FF;
        }
        .features ul {
            margin: 0;
            padding-left: 20px;
            color: #444;
        }
        .features li {
            margin-bottom: 10px;
        }
        .footer {
            background-color: #f4f7f6;
            color: #888888;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            border-top: 1px solid #eeeeee;
        }
        .footer a {
            color: #1E215D;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
                width: 100%;
            }
            .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Abidjan.ai</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Welcome, {{ $user->name ?? 'Explorer' }}! 🚀</h2>
            
            <p>We are thrilled to have you join <strong>Abidjan.ai</strong>. You've just taken the first step into a world of seamless AI integration and intelligent service management.</p>
            
            <p>Our platform empowers you to design, deploy, and monitor AI services with unprecedented ease. Whether you're building intelligent agents, orchestrating complex capabilities, or managing automation, we've got you covered.</p>
            
            <div class="features">
                <p style="margin-bottom: 10px; font-weight: bold;">Here is what you can do right away:</p>
                <ul>
                    <li>Explore our API endpoints and AI integration tools.</li>
                    <li>Manage and automate your intelligent workflows.</li>
                    <li>Track performance and AI request usage in real-time.</li>
                </ul>
            </div>

            <div class="cta-container">
                <a href="{{ config('app.url') }}/dashboard" class="cta-button">Go to Dashboard</a>
            </div>

            <p>If you have any questions or need a hand getting started, our support team is just an email away. We're always here to help you build the future.</p>

            <p>Happy building!<br>
            <strong>The Abidjan.ai Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Abidjan.ai. All rights reserved.</p>
            <p>
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a> | 
                <a href="{{ config('app.url') }}/terms">Terms of Service</a>
            </p>
        </div>
    </div>
</body>
</html>
