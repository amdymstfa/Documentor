<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentor - Authentification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f4ff',
                            500: '#667eea',
                            600: '#5a67d8',
                            700: '#4c51bf'
                        },
                        secondary: {
                            500: '#764ba2',
                            600: '#6b46c1'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center p-4">
    <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden w-full max-w-4xl min-h-[600px] flex">
        <!-- Section de bienvenue -->
        <div class="flex-1 bg-gradient-to-br from-primary-500 to-secondary-500 text-white flex flex-col justify-center items-center text-center p-12 lg:p-16">
            <div class="text-6xl mb-8 opacity-80">📚</div>
            <h1 class="text-4xl font-bold mb-6">Documentor</h1>
            <p class="text-lg opacity-90 leading-relaxed max-w-sm">
                Votre plateforme de gestion documentaire collaborative et professionnelle
            </p>
        </div>

        <!-- Section d'authentification -->
        <div class="flex-1 flex flex-col">
            <!-- Boutons de basculement -->
            <div class="p-8 pb-4">
                <div class="bg-gray-100 rounded-2xl p-1.5 flex">
                    <button 
                        id="login-toggle" 
                        class="toggle-btn flex-1 py-3 px-6 rounded-xl font-semibold transition-all duration-300 bg-gradient-to-r from-primary-500 to-secondary-500 text-white shadow-lg"
                        onclick="switchForm('login')"
                    >
                        Connexion
                    </button>
                    <button 
                        id="register-toggle" 
                        class="toggle-btn flex-1 py-3 px-6 rounded-xl font-semibold transition-all duration-300 text-gray-600"
                        onclick="switchForm('register')"
                    >
                        Inscription
                    </button>
                </div>
            </div>

            <div class="flex-1 px-8 pb-8">
                <!-- Messages d'erreur/succès -->
                <div id="error-message" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                </div>
                <div id="success-message" class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                </div>

                <!-- Formulaire de connexion -->
                <form id="login-form" class="auth-form space-y-6">
                    <div class="form-group">
                        <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <input 
                            type="email" 
                            id="login-email" 
                            name="email" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/10 transition-all duration-300 bg-gray-50 focus:bg-white"
                            placeholder="votre@email.com"
                        >
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="login-password" 
                            name="mot_de_passe" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/10 transition-all duration-300 bg-gray-50 focus:bg-white"
                            placeholder="••••••••"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 mt-8"
                    >
                        Se connecter
                    </button>
                </form>

                <!-- Formulaire d'inscription -->
                <form id="register-form" class="auth-form hidden space-y-6">
                    <div class="form-group">
                        <label for="register-name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom complet
                        </label>
                        <input 
                            type="text" 
                            id="register-name" 
                            name="nom" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/10 transition-all duration-300 bg-gray-50 focus:bg-white"
                            placeholder="Jean Dupont"
                        >
                    </div>
                    <div class="form-group">
                        <label for="register-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Adresse email
                        </label>
                        <input 
                            type="email" 
                            id="register-email" 
                            name="email" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/10 transition-all duration-300 bg-gray-50 focus:bg-white"
                            placeholder="votre@email.com"
                        >
                    </div>
                    <div class="form-group">
                        <label for="register-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="register-password" 
                            name="mot_de_passe" 
                            required 
                            minlength="6"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/10 transition-all duration-300 bg-gray-50 focus:bg-white"
                            placeholder="••••••••"
                        >
                    </div>
                    <div class="form-group">
                        <label for="register-role" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rôle
                        </label>
                        <select 
                            id="register-role" 
                            name="role_id" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/10 transition-all duration-300 bg-gray-50 focus:bg-white"
                        >
                            <option value="">Sélectionner un rôle</option>
                            <option value="1">Rédacteur</option>
                            <option value="2">Validateur</option>
                            <option value="3">Client</option>
                            <option value="4">Générateur</option>
                        </select>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-primary-500 to-secondary-500 text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 mt-8"
                    >
                        S'inscrire
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchForm(formType) {
            // Toggle active buttons
            const toggleButtons = document.querySelectorAll('.toggle-btn');
            toggleButtons.forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-primary-500', 'to-secondary-500', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-600');
            });
            
            const activeButton = document.getElementById(formType + '-toggle');
            activeButton.classList.remove('text-gray-600');
            activeButton.classList.add('bg-gradient-to-r', 'from-primary-500', 'to-secondary-500', 'text-white', 'shadow-lg');
            
            // Toggle active forms
            document.querySelectorAll('.auth-form').forEach(form => {
                form.classList.add('hidden');
            });
            document.getElementById(formType + '-form').classList.remove('hidden');
            
            // Clear messages
            clearMessages();
        }

        function showMessage(message, type = 'error') {
            clearMessages();
            const messageElement = document.getElementById(type + '-message');
            messageElement.textContent = message;
            messageElement.classList.remove('hidden');
        }

        function clearMessages() {
            document.getElementById('error-message').classList.add('hidden');
            document.getElementById('success-message').classList.add('hidden');
        }

        // Gestion des formulaires avec AJAX - CORRIGÉ
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showMessage('Connexion réussie ! Redirection...', 'success');
                    setTimeout(() => {
                        window.location.href = result.user.redirect_url || '/dashboard';
                    }, 1500);
                } else {
                    showMessage(result.message || 'Erreur de connexion');
                }
            } catch (error) {
                console.error('Erreur login:', error);
                showMessage('Erreur de connexion au serveur');
            }
        });

        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Validation côté client
            if (!data.nom || !data.email || !data.mot_de_passe || !data.role_id) {
                showMessage('Tous les champs sont obligatoires');
                return;
            }
            
            if (data.mot_de_passe.length < 6) {
                showMessage('Le mot de passe doit contenir au moins 6 caractères');
                return;
            }
            
            console.log('Données envoyées:', data); // Debug
            
            try {
                // URL COHÉRENTE CORRIGÉE
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                console.log('Status HTTP:', response.status); // Debug
                const result = await response.json();
                console.log('Réponse reçue:', result); // Debug
                
                if (response.ok && result.success) {
                    showMessage('Inscription réussie ! Vous pouvez maintenant vous connecter.', 'success');
                    this.reset();
                    setTimeout(() => switchForm('login'), 2000);
                } else {
                    showMessage(result.message || 'Erreur lors de l\'inscription');
                }
            } catch (error) {
                console.error('Erreur inscription:', error);
                showMessage('Erreur de connexion au serveur');
            }
        });

        // Responsive behavior
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                // Mobile adjustments if needed
            }
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .bg-white\/95 {
                flex-direction: column;
                max-width: 400px;
            }
            
            .flex-1:first-child {
                order: -1;
                padding: 2rem;
            }
            
            .flex-1:first-child h1 {
                font-size: 2rem;
            }
        }
    </style>
</body>
</html>