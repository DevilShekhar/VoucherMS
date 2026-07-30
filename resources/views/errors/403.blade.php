<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden Page</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* --------------------------------------------------
           1. CSS RESET & GLOBAL VARIABLES
           Resetting margins and padding ensures consistent
           rendering across different web browsers.
        -------------------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #00a9ff;
            --primary-gradient: linear-gradient(90deg, #1dc8ff, #00a9ff);
            --heading-color: #2f2f63;
            --text-color: #6f7287;
            --bg-color: #ffffff;
            --card-bg: #f8f9fa;
        }

        /* Dark Theme Variables (Toggled via JS for educational purposes) */
        body.dark-theme {
            --bg-color: #12122b;
            --heading-color: #ffffff;
            --text-color: #a0a5c0;
            --card-bg: #1e1e3f;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background-color 0.4s ease;
        }

        /* --------------------------------------------------
           2. LAYOUT CONTAINER
           Flexbox & Max-width keep content centered & responsive.
        -------------------------------------------------- */
        .container {
            width: 100%;
            max-width: 900px;
            text-align: center;
            padding: 40px 20px;
        }

        /* --------------------------------------------------
           3. ILLUSTRATION & ANIMATION
           CSS Animations allow smooth motion without JavaScript.
        -------------------------------------------------- */
        .illustration {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* --------------------------------------------------
           4. TYPOGRAPHY & BUTTONS
        -------------------------------------------------- */
        h1 {
            margin-top: 30px;
            color: var(--heading-color);
            font-size: 48px;
            font-weight: 700;
            transition: color 0.4s ease;
        }

        p {
            margin-top: 16px;
            color: var(--text-color);
            font-size: 16px;
            line-height: 1.6;
            transition: color 0.4s ease;
        }

        .btn {
            display: inline-block;
            margin-top: 35px;
            padding: 14px 42px;
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            border-radius: 50px;
            background: var(--primary-gradient);
            box-shadow: 0 10px 22px rgba(0, 169, 255, 0.35);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 169, 255, 0.45);
        }

        /* --------------------------------------------------
           5. EDUCATIONAL / DEBUG TOOLBAR
           A control panel allowing students to inspect UI behavior.
        -------------------------------------------------- */
        .edu-controls {
            margin-top: 50px;
            padding: 20px;
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px dashed #00a9ff;
            max-width: 600px;
            width: 100%;
        }

        .edu-controls h3 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary-color);
            margin-bottom: 12px;
        }

        .edu-btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .edu-btn {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--heading-color);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-family: inherit;
            transition: 0.2s;
        }

        .edu-btn:hover {
            background: var(--primary-color);
            color: #fff;
        }

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 36px;
            }

            p {
                font-size: 14px;
            }

            .illustration {
                max-width: 300px;
            }
        }
    </style>
</head>

<body>

    <!-- Main Content Container -->
    <main class="container">

        <!-- Vector SVG Graphic (Guarantees image loads without external dependencies) -->
        <div class="illustration" id="illustration">
            <svg viewBox="0 0 500 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Outer Arch / Door Frame -->
                <path d="M170 260 V 120 A 80 80 0 0 1 330 120 V 260 Z" fill="#e2e8f0" stroke="#cbd5e1"
                    stroke-width="4" />
                <path d="M185 260 V 130 A 65 65 0 0 1 315 130 V 260 Z" fill="#ffffff" />
                <!-- Lock Icon -->
                <rect x="225" y="160" width="50" height="40" rx="6" fill="#00a9ff" />
                <path d="M235 160 V 145 A 15 15 0 0 1 265 145 V 160" stroke="#00a9ff" stroke-width="5" fill="none"
                    stroke-linecap="round" />
                <circle cx="250" cy="177" r="4" fill="#ffffff" />
                <!-- Background 403 Text Overlay -->
                <text x="30" y="210" font-size="110" font-weight="800" fill="#f1f5f9" font-family="sans-serif">4</text>
                <text x="360" y="210" font-size="110" font-weight="800" fill="#f1f5f9" font-family="sans-serif">3</text>
                <!-- Ground Line -->
                <line x1="50" y1="260" x2="450" y2="260" stroke="#cbd5e1" stroke-width="4" stroke-linecap="round" />
            </svg>
        </div>

        <!-- Headline & Description -->
        <h1>We are Sorry...</h1>
        <p id="error-message">
            The page you're trying to access has restricted access.<br>
            Please refer to your system administrator.
        </p>


        <a href="{{ route('dashboard') }}" class="btn">Go Back</a>


    </main>


</body>

</html>