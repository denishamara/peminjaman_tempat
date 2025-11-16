<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Peminjaman Tempat' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6.4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    
    <style>
        /* Modern Layout Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(138, 43, 226, 0.3), transparent 50%),
                radial-gradient(circle at 40% 90%, rgba(59, 130, 246, 0.3), transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        .main-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Glass Card Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }
        
        /* Modern Button */
        .btn-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animated Background Shapes */
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: float 20s infinite ease-in-out;
            pointer-events: none;
            z-index: 0;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            top: 60%;
            right: 10%;
            animation-delay: 5s;
        }
        
        .shape-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            bottom: 10%;
            left: 50%;
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -30px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
        
        /* Content Area */
        .content-wrapper {
            flex: 1;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1rem;
            }
            
            .glass-card {
                border-radius: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    
    <div class="main-wrapper">
