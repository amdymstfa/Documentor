<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentor - Rédacteur</title>
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
                    <span class="ml-4 px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">Rédacteur</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7H4l5-5v5z"></path>
                        </svg>
                    </button>
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">JD</div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Sidebar -->
            <div class="w-80 bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Mes Documents</h2>
                    <button id="new-doc-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        + Nouveau
                    </button>
                </div>

                <!-- Filtres -->
                <div class="mb-4">
                    <select class="w-full p-2 border border-gray-300 rounded-lg text-sm">
                        <option>Tous les statuts</option>
                        <option>Brouillon</option>
                        <option>En révision</option>
                        <option>Validé</option>
                    </select>
                </div>

                <!-- Liste des documents -->
                <div class="space-y-3">
                    <div class="document-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 active" onclick="selectDocument(this, 'Cahier des charges - Site E-commerce')">
                        <h3 class="font-medium text-gray-900 text-sm">Cahier des charges - Site E-commerce</h3>
                        <p class="text-xs text-gray-500 mt-1">Modifié il y a 2h</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Brouillon</span>
                    </div>
                    <div class="document-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectDocument(this, 'Application Mobile - Gestion RH')">
                        <h3 class="font-medium text-gray-900 text-sm">Application Mobile - Gestion RH</h3>
                        <p class="text-xs text-gray-500 mt-1">Modifié il y a 1 jour</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">En révision</span>
                    </div>
                    <div class="document-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectDocument(this, 'Plateforme IoT - Industrie 4.0')">
                        <h3 class="font-medium text-gray-900 text-sm">Plateforme IoT - Industrie 4.0</h3>
                        <p class="text-xs text-gray-500 mt-1">Modifié il y a 3 jours</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Validé</span>
                    </div>
                </div>
            </div>

            <!-- Zone d'édition principale -->
            <div class="flex-1 bg-white rounded-lg shadow-sm">
                <!-- Toolbar -->
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 id="document-title" class="text-xl font-bold text-gray-900">Cahier des charges - Site E-commerce</h2>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500">Dernière sauvegarde: il y a 2 min</span>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                Soumettre pour validation
                            </button>
                        </div>
                    </div>
                    
                    <!-- Outils d'édition -->
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-gray-600 hover:bg-gray-100 rounded" title="Gras">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 5a1 1 0 011-1h5.5a2.5 2.5 0 010 5H4v2h4.5a2.5 2.5 0 010 5H4a1 1 0 01-1-1V5z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-600 hover:bg-gray-100 rounded" title="Italique">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5a1 1 0 000 2h1.5L7.5 13H6a1 1 0 000 2h4a1 1 0 000-2h-1.5L10.5 7H12a1 1 0 000-2H8z"/>
                            </svg>
                        </button>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <button id="add-section-btn" class="px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded font-medium">
                            + Ajouter une section
                        </button>
                    </div>
                </div>

                <!-- Contenu du document -->
                <div class="p-6">
                    <div id="document-content" class="space-y-6">
                        <!-- Section 1 -->
                        <div class="section-block border-l-4 border-blue-500 pl-4">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">1. Présentation du projet</h3>
                                <div class="flex space-x-2">
                                    <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le haut">↑</button>
                                    <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le bas">↓</button>
                                    <button class="text-red-400 hover:text-red-600" title="Supprimer">×</button>
                                </div>
                            </div>
                            <textarea class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Décrivez la présentation du projet...">Ce projet consiste à développer un site e-commerce moderne et performant pour la vente de produits électroniques. L'objectif est de créer une plateforme intuitive permettant aux utilisateurs de naviguer facilement, rechercher des produits et effectuer leurs achats en toute sécurité.</textarea>
                        </div>

                        <!-- Section 2 -->
                        <div class="section-block border-l-4 border-blue-500 pl-4">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">2. Objectifs fonctionnels</h3>
                                <div class="flex space-x-2">
                                    <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le haut">↑</button>
                                    <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le bas">↓</button>
                                    <button class="text-red-400 hover:text-red-600" title="Supprimer">×</button>
                                </div>
                            </div>
                            <textarea class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="6" placeholder="Listez les objectifs fonctionnels...">- Catalogue produits avec recherche avancée
- Gestion du panier et processus de commande
- Système de paiement sécurisé
- Espace client personnalisé
- Interface d'administration complète
- Gestion des stocks en temps réel</textarea>
                        </div>

                        <!-- Section 3 -->
                        <div class="section-block border-l-4 border-blue-500 pl-4">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">3. Spécifications techniques</h3>
                                <div class="flex space-x-2">
                                    <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le haut">↑</button>
                                    <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le bas">↓</button>
                                    <button class="text-red-400 hover:text-red-600" title="Supprimer">×</button>
                                </div>
                            </div>
                            <textarea class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Détaillez les spécifications techniques..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nouveau Document -->
    <div id="new-doc-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Nouveau Document</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre du document</label>
                    <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Ex: Cahier des charges - Projet XYZ">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template</label>
                    <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Template standard</option>
                        <option>Site web</option>
                        <option>Application mobile</option>
                        <option>Système d'information</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button id="cancel-new-doc" class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                <button id="create-new-doc" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Créer</button>
            </div>
        </div>
    </div>

    <script>
        // Gestion des documents
        function selectDocument(element, title) {
            // Retirer la classe active de tous les éléments
            document.querySelectorAll('.document-item').forEach(item => {
                item.classList.remove('active', 'bg-blue-50', 'border-blue-300');
            });
            
            // Ajouter la classe active à l'élément sélectionné
            element.classList.add('active', 'bg-blue-50', 'border-blue-300');
            
            // Mettre à jour le titre du document
            document.getElementById('document-title').textContent = title;
        }

        // Modal nouveau document
        const newDocBtn = document.getElementById('new-doc-btn');
        const newDocModal = document.getElementById('new-doc-modal');
        const cancelNewDoc = document.getElementById('cancel-new-doc');
        const createNewDoc = document.getElementById('create-new-doc');

        newDocBtn.addEventListener('click', () => {
            newDocModal.classList.remove('hidden');
            newDocModal.classList.add('flex');
        });

        cancelNewDoc.addEventListener('click', () => {
            newDocModal.classList.add('hidden');
            newDocModal.classList.remove('flex');
        });

        createNewDoc.addEventListener('click', () => {
            // Logique de création du document
            newDocModal.classList.add('hidden');
            newDocModal.classList.remove('flex');
        });

        // Ajouter une nouvelle section
        document.getElementById('add-section-btn').addEventListener('click', () => {
            const content = document.getElementById('document-content');
            const sectionCount = content.children.length + 1;
            
            const newSection = document.createElement('div');
            newSection.className = 'section-block border-l-4 border-blue-500 pl-4';
            newSection.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-lg font-semibold text-gray-900">${sectionCount}. Nouvelle section</h3>
                    <div class="flex space-x-2">
                        <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le haut">↑</button>
                        <button class="text-gray-400 hover:text-gray-600" title="Déplacer vers le bas">↓</button>
                        <button class="text-red-400 hover:text-red-600" title="Supprimer">×</button>
                    </div>
                </div>
                <textarea class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Contenu de la section..."></textarea>
            `;
            
            content.appendChild(newSection);
        });

        // Auto-sauvegarde
        let saveTimeout;
        document.addEventListener('input', (e) => {
            if (e.target.tagName === 'TEXTAREA') {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    // Logique de sauvegarde automatique
                    console.log('Document sauvegardé automatiquement');
                }, 2000);
            }
        });
    </script>
</body>
</html>