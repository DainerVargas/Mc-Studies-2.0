<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento | MC Language Studies</title>
    <link rel="icon" type="image/png" href="{{ asset('Logo.png') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Work+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        :root {
            --primary: #05ccd1;
            --primary-dark: #04b3b8;
            --secondary: #99bf51;
            --secondary-dark: #88ab47;
            --white: #ffffff;
            --dark: #1e293b;
            --gray-text: #64748b;
            --bg-light: #f7f6f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Work Sans', 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Gradients */
        .bg-blobs {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.6;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            animation: move 20s infinite alternate;
        }

        .blob-1 {
            width: 500px;
            height: 500px;
            background: rgba(5, 204, 209, 0.3);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .blob-2 {
            width: 400px;
            height: 400px;
            background: rgba(153, 191, 81, 0.3);
            bottom: -50px;
            right: -50px;
            animation-delay: -5s;
        }

        .blob-3 {
            width: 300px;
            height: 300px;
            background: rgba(4, 179, 184, 0.2);
            top: 40%;
            left: 60%;
            animation-delay: -10s;
        }

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(50px, 100px) scale(1.1); }
        }

        /* Maintenance Card */
        .maintenance-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 32px;
            padding: 4rem 3rem;
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 10;
        }

        .logo-container {
            margin-bottom: 2.5rem;
        }

        .logo-container img {
            height: 100px;
            width: auto;
            filter: drop-shadow(0 8px 15px rgba(0, 0, 0, 0.08));
        }

        .icon-box {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 24px;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 15px 30px rgba(5, 204, 209, 0.25);
        }

        .icon-box span {
            font-size: 40px;
            animation: rotate 4s infinite linear;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        h1 {
            color: var(--dark);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        p {
            color: var(--gray-text);
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            background: #fff5f5;
            color: #e53e3e;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 2rem;
            border: 1px solid #fed7d7;
        }

        .status-badge span {
            font-size: 18px;
            margin-right: 8px;
        }

        .buttons-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.8rem 2rem;
            border-radius: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 20px rgba(5, 204, 209, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(5, 204, 209, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--dark);
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            transform: translateY(-3px);
            border-color: #cbd5e1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Decorative dots */
        .dots {
            position: absolute;
            width: 150px;
            height: 150px;
            opacity: 0.1;
            z-index: -1;
        }

        .dots-top { top: 10%; right: 10%; }
        .dots-bottom { bottom: 10%; left: 10%; }

        @media (max-width: 480px) {
            .maintenance-card {
                padding: 3rem 1.5rem;
            }
            h1 {
                font-size: 1.8rem;
            }
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <div class="maintenance-card">
        <div class="logo-container">
            <img src="{{ asset('Logo.png') }}" alt="MC Language Studies Logo">
        </div>

        <div class="icon-box">
            <span class="material-symbols-outlined">settings</span>
        </div>

        <h1>Estamos en Mantenimiento</h1>
        
        <div class="status-badge">
            <span class="material-symbols-outlined">block</span>
            Registro e Inicio de Sesión Deshabilitados
        </div>

        <p>
            Estamos realizando mejoras importantes en nuestra plataforma para brindarte una mejor experiencia. 
            Por el momento, el acceso al sistema no está disponible. Volveremos pronto.
        </p>

        <div class="buttons-container">
            <button onclick="window.location.reload()" class="btn btn-primary">
                Actualizar Página
            </button>
            <a href="mailto:soporte@mclanguages.com" class="btn btn-secondary">
                Contactar Soporte
            </a>
        </div>
    </div>

    <!-- Background Decoration SVG Patterns -->
    <svg class="dots dots-top" viewBox="0 0 100 100">
        <pattern id="pattern-dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
            <circle cx="2" cy="2" r="2" fill="currentColor" />
        </pattern>
        <rect width="100" height="100" fill="url(#pattern-dots)" />
    </svg>
    <svg class="dots dots-bottom" viewBox="0 0 100 100">
        <rect width="100" height="100" fill="url(#pattern-dots)" />
    </svg>

</body>
</html>
