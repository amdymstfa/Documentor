<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentor - Client</title>
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
                    <span class="ml-4 px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">Client</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">AC</div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Sidebar -->
            <div class="w-80 bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Mes Projets</h2>

                <!-- Filtres -->
                <div class="mb-4 space-y-3">
                    <select class="w-full p-2 border border-gray-300 rounded-lg text-sm">
                        <option>Tous les statuts</option>
                        <option>En cours</option>
                        <option>En validation</option>
                        <option>Terminé</option>
                    </select>
                    <div class="relative">
                        <input type="text" placeholder="Rechercher un projet..." class="w-full p-2 pl-8 border border-gray-300 rounded-lg text-sm">
                        <svg class="w-4 h-4 absolute left-2.5 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Liste des projets -->
                <div class="space-y-3">
                    <div class="project-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 active bg-blue-50 border-blue-300" onclick="selectProject(this, 'Site E-commerce Électronique', 'Jean Dupont')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Site E-commerce Électronique</h3>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Validé</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Rédacteur: Jean Dupont</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Mis à jour il y a 2h</span>
                            <div class="flex items-center text-xs text-green-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Prêt pour consultation
                            </div>
                        </div>
                    </div>

                    <div class="project-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectProject(this, 'Application Mobile RH', 'Marie Martin')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Application Mobile RH</h3>
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En cours</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Rédacteur: Marie Martin</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Mis à jour il y a 1 jour</span>
                            <div class="flex items-center text-xs text-yellow-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                En validation
                            </div>
                        </div>
                    </div>

                    <div class="project-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectProject(this, 'Plateforme IoT Industrie', 'Pierre Durand')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Plateforme IoT Industrie</h3>
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Archivé</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Rédacteur: Pierre Durand</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Terminé il y a 1 semaine</span>
                            <div class="flex items-center text-xs text-blue-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Téléchargeable
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone de consultation principale -->
            <div class="flex-1 bg-white rounded-lg shadow-sm">
                <!-- Header du document -->
                <div class="border-b border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 id="project-title" class="text-xl font-bold text-gray-900">Site E-commerce Électronique</h2>
                            <p class="text-sm text-gray-500 mt-1">Rédacteur: <span id="project-author">Jean Dupont</span> • Version 2.1 • Validé le 15 janvier 2024</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">✓ Validé</span>
                        </div>
                    </div>
                    
                    <!-- Actions client -->
                    <div class="flex items-center space-x-3">
                        <button id="download-pdf-btn" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                            📄 Télécharger PDF
                        </button>
                        <button id="download-word-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            📝 Télécharger Word
                        </button>
                        <button id="share-btn" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                            🔗 Partager
                        </button>
                        <button id="feedback-btn" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                            💬 Donner mon avis
                        </button>
                    </div>
                </div>

                <!-- Contenu du document -->
                <div class="flex">
                    <!-- Contenu principal -->
                    <div class="flex-1 p-6">
                        <!-- Résumé exécutif -->
                        <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">📋 Résumé Exécutif</h3>
                            <p class="text-blue-800 text-sm">Développement d'une plateforme e-commerce moderne pour la vente de produits électroniques avec fonctionnalités avancées de recherche, paiement sécurisé et gestion des stocks.</p>
                            <div class="mt-3 grid grid-cols-3 gap-4 text-xs">
                                <div>
                                    <span class="font-medium text-blue-900">Budget:</span>
                                    <span class="text-blue-700">150 000€</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-900">Durée:</span>
                                    <span class="text-blue-700">6 mois</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-900">Équipe:</span>
                                    <span class="text-blue-700">8 personnes</span>
                                </div>
                            </div>
                        </div>

                        <div id="document-content" class="space-y-8">
                            <!-- Section 1 -->
                            <div class="section-block">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                                    Présentation du projet
                                </h3>
                                <div class="ml-11 prose max-w-none">
                                    <p class="text-gray-700 leading-relaxed mb-4">Ce projet consiste à développer un site e-commerce moderne et performant pour la vente de produits électroniques. L'objectif est de créer une plateforme intuitive permettant aux utilisateurs de naviguer facilement, rechercher des produits et effectuer leurs achats en toute sécurité.</p>
                                    
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="font-medium text-gray-900 mb-2">Objectifs principaux:</h4>
                                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                                            <li>Augmenter les ventes en ligne de 40%</li>
                                            <li>Améliorer l'expérience utilisateur</li>
                                            <li>Optimiser la gestion des stocks</li>
                                            <li>Intégrer des solutions de paiement modernes</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="section-block">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                                    Fonctionnalités principales
                                </h3>
                                <div class="ml-11">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <h4 class="font-medium text-gray-900 mb-2">🛍️ Catalogue & Recherche</h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Catalogue produits hiérarchisé</li>
                                                <li>• Recherche avancée avec filtres</li>
                                                <li>• Comparateur de produits</li>
                                                <li>• Recommandations personnalisées</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <h4 class="font-medium text-gray-900 mb-2">💳 Commande & Paiement</h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Panier intelligent</li>
                                                <li>• Processus de commande simplifié</li>
                                                <li>• Paiements sécurisés multiples</li>
                                                <li>• Suivi des commandes en temps réel</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <h4 class="font-medium text-gray-900 mb-2">👤 Espace Client</h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Profil utilisateur personnalisé</li>
                                                <li>• Historique des commandes</li>
                                                <li>• Liste de souhaits</li>
                                                <li>• Programme de fidélité</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <h4 class="font-medium text-gray-900 mb-2">⚙️ Administration</h4>
                                            <ul class="text-sm text-gray-700 space-y-1">
                                                <li>• Gestion des produits</li>
                                                <li>• Suivi des stocks</li>
                                                <li>• Analytics et rapports</li>
                                                <li>• Gestion des utilisateurs</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="section-block">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                                    Spécifications techniques
                                </h3>
                                <div class="ml-11">
                                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                        <h4 class="font-medium text-gray-900 mb-3">Architecture technique</h4>
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="font-medium text-gray-700">Frontend:</span>
                                                <span class="text-gray-600">React.js, Tailwind CSS</span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">Backend:</span>
                                                <span class="text-gray-600">Node.js, Express</span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">Base de données:</span>
                                                <span class="text-gray-600">PostgreSQL</span>
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-700">Hébergement:</span>
                                                <span class="text-gray-600">AWS Cloud</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4 -->
                            <div class="section-block">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                                    Planning et livrables
                                </h3>
                                <div class="ml-11">
                                    <div class="space-y-3">
                                        <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                            <div class="flex-1">
                                                <span class="font-medium text-green-900">Phase 1 - Analyse et conception</span>
                                                <span class="text-sm text-green-700 ml-2">(Terminée)</span>
                                            </div>
                                            <span class="text-sm text-green-600">4 semaines</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                            <div class="flex-1">
                                                <span class="font-medium text-blue-900">Phase 2 - Développement frontend</span>
                                                <span class="text-sm text-blue-700 ml-2">(En cours)</span>
                                            </div>
                                            <span class="text-sm text-blue-600">8 semaines</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                                            <div class="flex-1">
                                                <span class="font-medium text-gray-900">Phase 3 - Développement backend</span>
                                            </div>
                                            <span class="text-sm text-gray-600">6 semaines</span>
                                        </div>
                                        <div class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                                            <div class="flex-1">
                                                <span class="font-medium text-gray-900">Phase 4 - Tests et déploiement</span>
                                            </div>
                                            <span class="text-sm text-gray-600">4 semaines</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panneau des commentaires client -->
                    <div class="w-80 border-l border-gray-200 p-6 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes commentaires</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="p-3 bg-white rounded-lg border">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium text-purple-900">Vous</span>
                                    <span class="text-xs text-gray-500">Il y a 2h</span>
                                </div>
                                <p class="text-sm text-gray-700">Excellent travail sur la présentation ! J'aimerais voir plus de détails sur l'intégration avec nos systèmes existants.</p>
                            </div>
                            
                            <div class="p-3 bg-white rounded-lg border">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium text-purple-900">Vous</span>
                                    <span class="text-xs text-gray-500">Il y a 1 jour</span>
                                </div>
                                <p class="text-sm text-gray-700">Le budget semble cohérent. Pouvons-nous prévoir une phase pilote avant le déploiement complet ?</p>
                            </div>
                        </div>

                        <!-- Formulaire nouveau commentaire -->
                        <div class="space-y-3">
                            <textarea id="client-comment" class="w-full p-3 border border-gray-300 rounded-lg text-sm resize-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" rows="4" placeholder="Partagez votre avis sur ce projet..."></textarea>
                            <button id="submit-feedback" class="w-full bg-purple-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                                Publier mon commentaire
                            </button>
                        </div>

                        <!-- Historique des versions -->
                        <div class="mt-8">
                            <h4 class="text-md font-semibold text-gray-900 mb-3">Historique des versions</h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 bg-white rounded border">
                                    <div>
                                        <span class="text-sm font-medium text-gray-900">Version 2.1</span>
                                        <span class="text-xs text-green-600 ml-2">• Actuelle</span>
                                    </div>
                                    <button class="text-xs text-blue-600 hover:text-blue-800">Voir</button>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border">
                                    <div>
                                        <span class="text-sm text-gray-700">Version 2.0</span>
                                        <span class="text-xs text-gray-500 ml-2">• 3 jours</span>
                                    </div>
                                    <button class="text-xs text-blue-600 hover:text-blue-800">Voir</button>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded border">
                                    <div>
                                        <span class="text-sm text-gray-700">Version 1.0</span>
                                        <span class="text-xs text-gray-500 ml-2">• 1 semaine</span>
                                    </div>
                                    <button class="text-xs text-blue-600 hover:text-blue-800">Voir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de feedback -->
    <div id="feedback-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg">
            <h3 class="text-lg font-semibold mb-4">Donner mon avis sur le projet</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Note globale</label>
                    <div class="flex space-x-2">
                        <button class="star-rating w-8 h-8 text-gray-300 hover:text-yellow-400" data-rating="1">★</button>
                        <button class="star-rating w-8 h-8 text-gray-300 hover:text-yellow-400" data-rating="2">★</button>
                        <button class="star-rating w-8 h-8 text-gray-300 hover:text-yellow-400" data-rating="3">★</button>
                        <button class="star-rating w-8 h-8 text-gray-300 hover:text-yellow-400" data-rating="4">★</button>
                        <button class="star-rating w-8 h-8 text-gray-300 hover:text-yellow-400" data-rating="5">★</button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire détaillé</label>
                    <textarea class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" rows="4" placeholder="Partagez votre avis détaillé..."></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button id="cancel-feedback" class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                <button id="submit-detailed-feedback" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Envoyer</button>
            </div>
        </div>
    </div>

    <script>
        // Gestion des projets
        function selectProject(element, title, author) {
            document.querySelectorAll('.project-item').forEach(item => {
                item.classList.remove('active', 'bg-blue-50', 'border-blue-300');
            });
            
            element.classList.add('active', 'bg-blue-50', 'border-blue-300');
            document.getElementById('project-title').textContent = title;
            document.getElementById('project-author').textContent = author;
        }

        // Téléchargements
        document.getElementById('download-pdf-btn').addEventListener('click', () => {
            alert('Téléchargement du PDF en cours...');
        });

        document.getElementById('download-word-btn').addEventListener('click', () => {
            alert('Téléchargement du fichier Word en cours...');
        });

        // Partage
        document.getElementById('share-btn').addEventListener('click', () => {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Lien copié dans le presse-papiers !');
            });
        });

        // Modal de feedback
        const feedbackBtn = document.getElementById('feedback-btn');
        const feedbackModal = document.getElementById('feedback-modal');
        const cancelFeedback = document.getElementById('cancel-feedback');
        const submitDetailedFeedback = document.getElementById('submit-detailed-feedback');

        feedbackBtn.addEventListener('click', () => {
            feedbackModal.classList.remove('hidden');
            feedbackModal.classList.add('flex');
        });

        cancelFeedback.addEventListener('click', () => {
            feedbackModal.classList.add('hidden');
            feedbackModal.classList.remove('flex');
        });

        submitDetailedFeedback.addEventListener('click', () => {
            alert('Votre avis a été envoyé avec succès !');
            feedbackModal.classList.add('hidden');
            feedbackModal.classList.remove('flex');
        });

        // Système de notation par étoiles
        const starRatings = document.querySelectorAll('.star-rating');
        let currentRating = 0;

        starRatings.forEach(star => {
            star.addEventListener('click', (e) => {
                currentRating = parseInt(e.target.dataset.rating);
                updateStarDisplay();
            });

            star.addEventListener('mouseover', (e) => {
                const hoverRating = parseInt(e.target.dataset.rating);
                highlightStars(hoverRating);
            });
        });

        function updateStarDisplay() {
            starRatings.forEach((star, index) => {
                if (index < currentRating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        function highlightStars(rating) {
            starRatings.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Commentaire rapide
        document.getElementById('submit-feedback').addEventListener('click', () => {
            const comment = document.getElementById('client-comment').value.trim();
            if (comment) {
                alert('Commentaire publié avec succès !');
                document.getElementById('client-comment').value = '';
            }
        });
    </script>
</body>
</html>