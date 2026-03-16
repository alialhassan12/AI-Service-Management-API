<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Request Received</title>
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
            font-size: 28px;
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
            text-align: center;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .status-box {
            background-color: #fff8e1;
            border-left: 4px solid #ffb300;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            text-align: center;
        }
        .status-box p {
            margin: 0;
            font-size: 16px;
            color: #ff8f00;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background-color: #f8fbfc;
            border-radius: 8px;
            overflow: hidden;
        }
        .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eeeeee;
        }
        .details-table td:first-child {
            font-weight: bold;
            color: #555555;
            width: 40%;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .cta-container {
            text-align: center;
            margin: 35px 0;
        }
        .cta-button {
            background: #ffffff;
            color: #1E215D !important;
            border: 2px solid #1E215D;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s;
        }
        .cta-button:hover {
            background: #1E215D;
            color: #ffffff !important;
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
            <h2>Subscription Request Received 🎉</h2>
            
            <p>Hello{{ isset($user) ? ' ' . $user->name : '' }},</p>
            
            <p>Thank you for your interest in Abidjan.ai! We have successfully received your subscription request to our AI services platform.</p>
            
            <div class="status-box">
                <p>⏳ Status: Pending Admin Approval</p>
            </div>

            @if(isset($plan))
            <table class="details-table">
                <tr>
                    <td>Service Name</td>
                    <td>{{ $plan->service ? $plan->service->name : 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Plan Name</td>
                    <td>{{ $plan->name }}</td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>${{ number_format($plan->price, 2) }}</td>
                </tr>
                <tr>
                    <td>Duration</td>
                    <td>{{ $plan->duration_days }} Days</td>
                </tr>
                <tr>
                    <td>Request Limit</td>
                    <td>{{ $plan->request_limit }} Requests</td>
                </tr>
            </table>
            @endif
            
            <p>Our administration team is currently reviewing your request. This process usually takes a short amount of time. We will notify you via email as soon as your subscription has been approved and activated.</p>
            
            <p>If you have any questions in the meantime, feel free to reply to this email or contact our support team.</p>

            <div class="cta-container">
                <a href="{{ config('app.url') }}/dashboard" class="cta-button">Return to Dashboard</a>
            </div>

            <p>Thank you for choosing Abidjan.ai!<br>
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
