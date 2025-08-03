<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentor - Validateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl">📚</span>
                    <h1 class="ml-3 text-xl font-bold text-gray-900">Documentor</h1>
                    <span class="ml-4 px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">Validateur</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-gray-500 hover:text-gray-700 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            </svg>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-medium">MV</div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Sidebar -->
            <div class="w-80 bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Documents à valider</h2>

                <!-- Filtres -->
                <div class="mb-4 space-y-3">
                    <select class="w-full p-2 border border-gray-300 rounded-lg text-sm">
                        <option>Tous les statuts</option>
                        <option>En attente de validation</option>
                        <option>En cours de révision</option>
                        <option>Validé</option>
                        <option>Rejeté</option>
                    </select>
                    <select class="w-full p-2 border border-gray-300 rounded-lg text-sm">
                        <option>Tous les rédacteurs</option>
                        <option>Jean Dupont</option>
                        <option>Marie Martin</option>
                        <option>Pierre Durand</option>
                    </select>
                </div>

                <!-- Liste des documents -->
                <div class="space-y-3">
                    <div class="document-item p-4 border border-orange-200 bg-orange-50 rounded-lg cursor-pointer hover:bg-orange-100 active" onclick="selectDocument(this, 'Cahier des charges - Site E-commerce', 'Jean Dupont')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Cahier des charges - Site E-commerce</h3>
                            <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">En attente</span>
                        </div>
                        <p class="text-xs text-gray-500">Par Jean Dupont • Soumis il y a 2h</p>
                        <div class="flex items-center mt-2 text-xs text-orange-600">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Urgent
                        </div>
                    </div>

                    <div class="document-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectDocument(this, 'Application Mobile - Gestion RH', 'Marie Martin')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Application Mobile - Gestion RH</h3>
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">En révision</span>
                        </div>
                        <p class="text-xs text-gray-500">Par Marie Martin • Soumis il y a 1 jour</p>
                        <div class="flex items-center mt-2 text-xs text-gray-500">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                            </svg>
                            2 commentaires
                        </div>
                    </div>

                    <div class="document-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectDocument(this, 'Plateforme IoT - Industrie 4.0', 'Pierre Durand')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Plateforme IoT - Industrie 4.0</h3>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Validé</span>
                        </div>
                        <p class="text-xs text-gray-500">Par Pierre Durand • Validé il y a 2 jours</p>
                    </div>
                </div>
            </div>

            <!-- Zone de validation principale -->
            <div class="flex-1 bg-white rounded-lg shadow-sm">
                <!-- Header du document -->
                <div class="border-b border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 id="document-title" class="text-xl font-bold text-gray-900">Cahier des charges - Site E-commerce</h2>
                            <p class="text-sm text-gray-500 mt-1">Par <span id="document-author">Jean Dupont</span> • Soumis le 15 janvier 2024</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm font-medium rounded-full">En attente de validation</span>
                        </div>
                    </div>
                    
                    <!-- Actions de validation -->
                    <div class="flex items-center space-x-3">
                        <button id="validate-btn" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                            ✓ Valider
                        </button>
                        <button id="reject-btn" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                            ✗ Rejeter
                        </button>
                        <button id="request-changes-btn" class="bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-700 transition-colors">
                            📝 Demander des modifications
                        </button>
                        <button id="add-comment-btn" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                            💬 Ajouter un commentaire
                        </button>
                    </div>
                </div>

                <!-- Contenu du document avec annotations -->
                <div class="flex">
                    <!-- Contenu principal -->
                    <div class="flex-1 p-6">
                        <div id="document-content" class="space-y-6">
                            <!-- Section 1 avec commentaires -->
                            <div class="section-block relative">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">1. Présentation du projet</h3>
                                        <div class="prose max-w-none">
                                            <p class="text-gray-700 leading-relaxed">Ce projet consiste à développer un site e-commerce moderne et performant pour la vente de produits électroniques. L'objectif est de créer une plateforme intuitive permettant aux utilisateurs de naviguer facilement, rechercher des produits et effectuer leurs achats en toute sécurité.</p>
                                        </div>
                                    </div>
                                    <button class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium" onclick="addComment(this)">
                                        + Commenter
                                    </button>
                                </div>
                                
                                <!-- Commentaire existant -->
                                <div class="mt-4 ml-4 p-3 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-sm font-medium text-blue-900">Marie Validateur</span>
                                        <span class="text-xs text-blue-600">Il y a 1h</span>
                                    </div>
                                    <p class="text-sm text-blue-800">Excellente présentation ! Pourriez-vous préciser le type de produits électroniques ciblés ?</p>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="section-block relative">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">2. Objectifs fonctionnels</h3>
                                        <div class="prose max-w-none">
                                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                                <li>Catalogue produits avec recherche avancée</li>
                                                <li>Gestion du panier et processus de commande</li>
                                                <li>Système de paiement sécurisé</li>
                                                <li>Espace client personnalisé</li>
                                                <li>Interface d'administration complète</li>
                                                <li>Gestion des stocks en temps réel</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <button class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium" onclick="addComment(this)">
                                        + Commenter
                                    </button>
                                </div>
                            </div>

                            <!-- Section 3 avec problème -->
                            <div class="section-block relative border-l-4 border-red-400 pl-4 bg-red-50">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">3. Spécifications techniques</h3>
                                        <div class="prose max-w-none">
                                            <p class="text-gray-700 leading-relaxed">Section incomplète - À développer</p>
                                        </div>
                                    </div>
                                    <button class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium" onclick="addComment(this)">
                                        + Commenter
                                    </button>
                                </div>
                                
                                <!-- Commentaire critique -->
                                <div class="mt-4 ml-4 p-3 bg-red-100 border-l-4 border-red-500 rounded-r-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-sm font-medium text-red-900">Marie Validateur</span>
                                        <span class="text-xs text-red-600">Il y a 30min</span>
                                    </div>
                                    <p class="text-sm text-red-800">⚠️ Cette section doit être complétée avant validation. Merci de préciser les technologies, l'architecture et les contraintes techniques.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panneau des commentaires -->
                    <div class="w-80 border-l border-gray-200 p-6 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique des commentaires</h3>
                        
                        <div class="space-y-4">
                            <div class="p-3 bg-white rounded-lg border">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium text-gray-900">Marie Validateur</span>
                                    <span class="text-xs text-gray-500">Il y a 1h</span>
                                </div>
                                <p class="text-sm text-gray-700">Document bien structuré dans l'ensemble. Quelques points à clarifier.</p>
                            </div>
                            
                            <div class="p-3 bg-white rounded-lg border">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium text-gray-900">Jean Dupont</span>
                                    <span class="text-xs text-gray-500">Il y a 45min</span>
                                </div>
                                <p class="text-sm text-gray-700">Merci pour les retours ! Je vais compléter la section technique.</p>
                            </div>
                        </div>

                        <!-- Formulaire nouveau commentaire -->
                        <div class="mt-6">
                            <textarea class="w-full p-3 border border-gray-300 rounded-lg text-sm resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Ajouter un commentaire général..."></textarea>
                            <button class="mt-2 w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                Publier le commentaire
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de validation -->
    <div id="validation-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Valider le document</h3>
            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir valider ce document ? Cette action notifiera le rédacteur.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-validation" class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                <button id="confirm-validation" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Valider</button>
            </div>
        </div>
    </div>

    <script>
        // Gestion des documents
        function selectDocument(element, title, author) {
            document.querySelectorAll('.document-item').forEach(item => {
                item.classList.remove('active', 'ring-2', 'ring-blue-500');
            });
            
            element.classList.add('active', 'ring-2', 'ring-blue-500');
            document.getElementById('document-title').textContent = title;
            document.getElementById('document-author').textContent = author;
        }

        // Ajouter un commentaire sur une section
        function addComment(button) {
            const section = button.closest('.section-block');
            const commentForm = document.createElement('div');
            commentForm.className = 'mt-4 ml-4 p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg';
            commentForm.innerHTML = `
                <textarea class="w-full p-2 border border-gray-300 rounded text-sm resize-none" rows="2" placeholder="Votre commentaire..."></textarea>
                <div class="flex justify-end space-x-2 mt-2">
                    <button onclick="this.closest('div').parentElement.remove()" class="text-sm text-gray-600 hover:text-gray-800">Annuler</button>
                    <button onclick="publishComment(this)" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Publier</button>
                </div>
            `;
            section.appendChild(commentForm);
        }

        function publishComment(button) {
            const form = button.closest('div').parentElement;
            const textarea = form.querySelector('textarea');
            const comment = textarea.value.trim();
            
            if (comment) {
                const commentDiv = document.createElement('div');
                commentDiv.className = 'mt-4 ml-4 p-3 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg';
                commentDiv.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-sm font-medium text-blue-900">Marie Validateur</span>
                        <span class="text-xs text-blue-600">À l'instant</span>
                    </div>
                    <p class="text-sm text-blue-800">${comment}</p>
                `;
                
                form.parentElement.replaceChild(commentDiv, form);
            }
        }

        // Gestion des actions de validation
        document.getElementById('validate-btn').addEventListener('click', () => {
            document.getElementById('validation-modal').classList.remove('hidden');
            document.getElementById('validation-modal').classList.add('flex');
        });

        document.getElementById('cancel-validation').addEventListener('click', () => {
            document.getElementById('validation-modal').classList.add('hidden');
            document.getElementById('validation-modal').classList.remove('flex');
        });

        document.getElementById('confirm-validation').addEventListener('click', () => {
            alert('Document validé avec succès !');
            document.getElementById('validation-modal').classList.add('hidden');
            document.getElementById('validation-modal').classList.remove('flex');
        });

        document.getElementById('reject-btn').addEventListener('click', () => {
            const reason = prompt('Raison du rejet :');
            if (reason) {
                alert('Document rejeté. Le rédacteur sera notifié.');
            }
        });

        document.getElementById('request-changes-btn').addEventListener('click', () => {
            const changes = prompt('Modifications demandées :');
            if (changes) {
                alert('Demande de modifications envoyée au rédacteur.');
            }
        });
    </script>
</body>
</html>