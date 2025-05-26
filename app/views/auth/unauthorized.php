<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès non autorisé</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .bg-gradient {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
    </style>
</head>
<body class="bg-gradient min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden fade-in">
        <div class="bg-blue-500 py-4 px-6">
            <div class="flex items-center">
                <div class="bg-white p-2 rounded-full mr-4">
                    <i class="fas fa-lock text-blue-500 text-2xl"></i>
                </div>
                <h1 class="text-white text-2xl font-bold">Accès restreint</h1>
            </div>
        </div>
        
        <div class="p-8">
            <div class="text-center mb-8">
                <i class="fas fa-user-lock text-blue-500 text-6xl mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Accès non autorisé</h2>
                <p class="text-gray-600">Désolé, vous n'avez pas les autorisations nécessaires pour accéder à cette page.</p>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Si vous pensez qu'il s'agit d'une erreur, veuillez contacter l'administrateur du site.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center">
                <button onclick="window.history.back()" class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la page précédente
                </button>
            </div>
        </div>
        
        <div class="bg-gray-50 px-6 py-4 text-center">
            <p class="text-xs text-gray-500">
                © 2025 Votre Application. Tous droits réservés.
            </p>
        </div>
    </div>
    
    <script>
        // Add slight delay to elements for staggered animation
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>