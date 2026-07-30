<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            text-align: center;
        }

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
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        h1 {
            margin-top: 20px;
            font-size: 2.2rem;
            font-weight: 700;
            color: #2d2d5a;
        }

        p {
            margin-top: 12px;
            font-size: 0.95rem;
            color: #6c757d;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 42px;
            background-color: #17bebb;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 25px;
            box-shadow: 0 8px 20px rgba(23, 190, 187, 0.35);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #14a8a5;
            box-shadow: 0 12px 24px rgba(23, 190, 187, 0.45);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- SVG Illustration -->
        <div class="illustration">
            <svg viewBox="0 0 500 250" fill="none" xmlns="http://www.w3.org/2000/svg">
                <text x="40" y="180" font-size="160" font-weight="700" fill="#f0f4f8"
                    font-family="'Poppins', sans-serif">5</text>
                <text x="310" y="180" font-size="160" font-weight="700" fill="#f0f4f8"
                    font-family="'Poppins', sans-serif">0</text>

                <!-- Server Rack & Warning Concept -->
                <g transform="translate(190, 45)">
                    <rect x="15" y="15" width="90" height="120" rx="10" fill="#ffffff" stroke="#b0bec5"
                        stroke-width="4" />
                    <!-- Drive slots -->
                    <rect x="27" y="32" width="66" height="16" rx="4" fill="#f0f4f8" stroke="#cfd8dc"
                        stroke-width="2" />
                    <circle cx="80" cy="40" r="3" fill="#ff5252" />

                    <rect x="27" y="56" width="66" height="16" rx="4" fill="#f0f4f8" stroke="#cfd8dc"
                        stroke-width="2" />
                    <circle cx="80" cy="64" r="3" fill="#17bebb" />

                    <rect x="27" y="80" width="66" height="16" rx="4" fill="#f0f4f8" stroke="#cfd8dc"
                        stroke-width="2" />
                    <circle cx="80" cy="88" r="3" fill="#ff5252" />

                    <!-- Warning badge -->
                    <circle cx="60" cy="115" r="16" fill="#17bebb" />
                    <path d="M60 107 V115 M60 119 V121" stroke="#ffffff" stroke-width="3" stroke-linecap="round" />
                </g>

                <line x1="50" y1="210" x2="450" y2="210" stroke="#cfd8dc" stroke-width="3" stroke-linecap="round" />
            </svg>
        </div>

        <h1>Internal Server Error</h1>
        <p>
            Something went wrong on our end.<br>
            Please try refreshing the page or try again later.
        </p>

        <a href="javascript:location.reload()" class="btn">Try Refreshing</a>
        <a href="{{ route('dashboard') }}" class="btn">Go Back</a>
    </div>

</body>

</html>