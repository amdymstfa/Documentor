<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentor - Générateur</title>
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
                    <span class="ml-4 px-3 py-1 bg-orange-100 text-orange-800 text-sm font-medium rounded-full">Générateur</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </button>
                        <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">5</span>
                    </div>
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-medium">EG</div>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Sidebar -->
            <div class="w-80 bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Documents à exporter</h2>

                <!-- Filtres -->
                <div class="mb-4 space-y-3">
                    <select class="w-full p-2 border border-gray-300 rounded-lg text-sm">
                        <option>Tous les statuts</option>
                        <option>Prêt à exporter</option>
                        <option>En cours d'export</option>
                        <option>Exporté</option>
                    </select>
                    <select class="w-full p-2 border border-gray-300 rounded-lg text-sm">
                        <option>Tous les formats</option>
                        <option>PDF</option>
                        <option>Word</option>
                        <option>HTML</option>
                    </select>
                </div>

                <!-- Liste des documents -->
                <div class="space-y-3">
                    <div class="document-item p-4 border border-green-200 bg-green-50 rounded-lg cursor-pointer hover:bg-green-100 active" onclick="selectDocument(this, 'Site E-commerce Électronique', 'Jean Dupont')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Site E-commerce Électronique</h3>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Prêt</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Par Jean Dupont • Validé il y a 2h</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Version 2.1</span>
                            <div class="flex items-center text-xs text-green-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Prêt à exporter
                            </div>
                        </div>
                    </div>

                    <div class="document-item p-4 border border-blue-200 bg-blue-50 rounded-lg cursor-pointer hover:bg-blue-100" onclick="selectDocument(this, 'Application Mobile RH', 'Marie Martin')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Application Mobile RH</h3>
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">En cours</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Par Marie Martin • Export en cours</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Version 1.3</span>
                            <div class="flex items-center text-xs text-blue-600">
                                <svg class="w-3 h-3 mr-1 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                Export PDF 75%
                            </div>
                        </div>
                    </div>

                    <div class="document-item p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50" onclick="selectDocument(this, 'Plateforme IoT Industrie', 'Pierre Durand')">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900 text-sm">Plateforme IoT Industrie</h3>
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Exporté</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Par Pierre Durand • Exporté il y a 1 jour</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">Version 3.0</span>
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                3 formats disponibles
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone d'export principale -->
            <div class="flex-1 bg-white rounded-lg shadow-sm">
                <!-- Header du document -->
                <div class="border-b border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 id="document-title" class="text-xl font-bold text-gray-900">Site E-commerce Électronique</h2>
                            <p class="text-sm text-gray-500 mt-1">Par <span id="document-author">Jean Dupont</span> • Version 2.1 • Validé le 15 janvier 2024</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">✓ Prêt à exporter</span>
                        </div>
                    </div>
                </div>

                <!-- Options d'export -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Options d'exportation</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Export PDF -->
                        <div class="export-option border-2 border-red-200 rounded-lg p-4 cursor-pointer hover:border-red-400 transition-colors" onclick="selectExportType('pdf')">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">PDF</h4>
                                    <p class="text-sm text-gray-500">Format professionnel</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2" checked> Page de garde
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2" checked> Table des matières
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Numérotation des pages
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Filigrane
                                </label>
                            </div>
                        </div>

                        <!-- Export Word -->
                        <div class="export-option border-2 border-blue-200 rounded-lg p-4 cursor-pointer hover:border-blue-400 transition-colors" onclick="selectExportType('word')">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Word</h4>
                                    <p class="text-sm text-gray-500">Format éditable</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2" checked> Styles automatiques
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2" checked> Commentaires
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Mode révision
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Protection du document
                                </label>
                            </div>
                        </div>

                        <!-- Export HTML -->
                        <div class="export-option border-2 border-green-200 rounded-lg p-4 cursor-pointer hover:border-green-400 transition-colors" onclick="selectExportType('html')">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">HTML</h4>
                                    <p class="text-sm text-gray-500">Format web</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2" checked> CSS intégré
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Navigation interactive
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Responsive design
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-2"> Mode sombre
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Template selection -->
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-900 mb-3">Template de mise en page</h4>
                        <div class="grid grid-cols-4 gap-3">
                            <div class="template-option border-2 border-blue-500 rounded-lg p-3 cursor-pointer bg-blue-50" onclick="selectTemplate('corporate')">
                                <div class="w-full h-16 bg-blue-200 rounded mb-2"></div>
                                <p class="text-xs font-medium text-center">Corporate</p>
                            </div>
                            <div class="template-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-gray-400" onclick="selectTemplate('modern')">
                                <div class="w-full h-16 bg-gray-200 rounded mb-2"></div>
                                <p class="text-xs font-medium text-center">Modern</p>
                            </div>
                            <div class="template-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-gray-400" onclick="selectTemplate('minimal')">
                                <div class="w-full h-16 bg-gray-200 rounded mb-2"></div>
                                <p class="text-xs font-medium text-center">Minimal</p>
                            </div>
                            <div class="template-option border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-gray-400" onclick="selectTemplate('technical')">
                                <div class="w-full h-16 bg-gray-200 rounded mb-2"></div>
                                <p class="text-xs font-medium text-center">Technical</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions d'export -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button id="preview-btn" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                                👁️ Aperçu
                            </button>
                            <button id="batch-export-btn" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                                📦 Export groupé
                            </button>
                        </div>
                        <button id="export-btn" class="bg-orange-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-orange-700 transition-colors">
                            🚀 Lancer l'export
                        </button>
                    </div>
                </div>

                <!-- Historique des exports -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique des exports</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Site E-commerce - v2.0.pdf</h4>
                                    <p class="text-sm text-gray-500">Exporté il y a 2 jours • 2.4 MB</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-green-600 font-medium">✓ Terminé</span>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Télécharger</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Application RH - v1.3.docx</h4>
                                    <p class="text-sm text-gray-500">En cours d'export • 75% terminé</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <span class="text-sm text-blue-600 font-medium">75%</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Plateforme IoT - v3.0.html</h4>
                                    <p class="text-sm text-gray-500">Exporté il y a 1 semaine • 1.8 MB</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600 font-medium">✓ Archivé</span>
                                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Télécharger</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'aperçu -->
    <div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-full max-w-4xl h-5/6 flex flex-col">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Aperçu du document</h3>
                <button id="close-preview" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4 overflow-auto">
                <div class="bg-white shadow-lg rounded-lg p-8 max-w-3xl mx-auto">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Site E-commerce Électronique</h1>
                        <p class="text-gray-600">Cahier des charges technique</p>
                        <div class="mt-4 text-sm text-gray-500">
                            <p>Version 2.1 • 15 janvier 2024</p>
                            <p>Rédigé par Jean Dupont</p>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <h2>1. Présentation du projet</h2>
                        <p>Ce projet consiste à développer un site e-commerce moderne...</p>
                        <h2>2. Objectifs fonctionnels</h2>
                        <p>Les objectifs principaux de cette plateforme...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedExportType = 'pdf';
        let selectedTemplate = 'corporate';

        // Gestion des documents
        function selectDocument(element, title, author) {
            document.querySelectorAll('.document-item').forEach(item => {
                item.classList.remove('active', 'ring-2', 'ring-orange-500');
            });
            
            element.classList.add('active', 'ring-2', 'ring-orange-500');
            document.getElementById('document-title').textContent = title;
            document.getElementById('document-author').textContent = author;
        }

        // Sélection du type d'export
        function selectExportType(type) {
            selectedExportType = type;
            document.querySelectorAll('.export-option').forEach(option => {
                option.classList.remove('border-red-400', 'border-blue-400', 'border-green-400');
                option.classList.add('border-gray-200');
            });
            
            const selectedOption = document.querySelector(`[onclick="selectExportType('${type}')"]`);
            selectedOption.classList.remove('border-gray-200');
            
            if (type === 'pdf') {
                selectedOption.classList.add('border-red-400');
            } else if (type === 'word') {
                selectedOption.classList.add('border-blue-400');
            } else if (type === 'html') {
                selectedOption.classList.add('border-green-400');
            }
        }

        // Sélection du template
        function selectTemplate(template) {
            selectedTemplate = template;
            document.querySelectorAll('.template-option').forEach(option => {
                option.classList.remove('border-blue-500', 'bg-blue-50');
                option.classList.add('border-gray-200');
            });
            
            const selectedOption = document.querySelector(`[onclick="selectTemplate('${template}')"]`);
            selectedOption.classList.remove('border-gray-200');
            selectedOption.classList.add('border-blue-500', 'bg-blue-50');
        }

        // Aperçu du document
        document.getElementById('preview-btn').addEventListener('click', () => {
            document.getElementById('preview-modal').classList.remove('hidden');
            document.getElementById('preview-modal').classList.add('flex');
        });

        document.getElementById('close-preview').addEventListener('click', () => {
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('preview-modal').classList.remove('flex');
        });

        // Export du document
        document.getElementById('export-btn').addEventListener('click', () => {
            const exportType = selectedExportType.toUpperCase();
            const template = selectedTemplate;
            
            // Simulation de l'export
            alert(`Export ${exportType} lancé avec le template ${template} !`);
            
            // Simulation de progression
            simulateExportProgress();
        });

        function simulateExportProgress() {
            // Ajouter une nouvelle entrée dans l'historique
            const historyContainer = document.querySelector('.space-y-3');
            const newExport = document.createElement('div');
            newExport.className = 'flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg';
            newExport.innerHTML = `
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-orange-600 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Site E-commerce - v2.1.${selectedExportType}</h4>
                        <p class="text-sm text-gray-500">Export en cours...</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-16 bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-600 h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                    <span class="text-sm text-orange-600 font-medium">0%</span>
                </div>
            `;
            
            historyContainer.insertBefore(newExport, historyContainer.firstChild);
            
            // Simulation de progression
            let progress = 0;
            const progressBar = newExport.querySelector('.bg-orange-600');
            const progressText = newExport.querySelector('.text-orange-600');
            
            const interval = setInterval(() => {
                progress += Math.random() * 20;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    
                    // Marquer comme terminé
                    newExport.className = 'flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg';
                    newExport.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Site E-commerce - v2.1.${selectedExportType}</h4>
                                <p class="text-sm text-gray-500">Exporté à l'instant • 2.1 MB</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-green-600 font-medium">✓ Terminé</span>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Télécharger</button>
                        </div>
                    `;
                }
                
                progressBar.style.width = progress + '%';
                progressText.textContent = Math.round(progress) + '%';
            }, 500);
        }

        // Export groupé
        document.getElementById('batch-export-btn').addEventListener('click', () => {
            const formats = ['PDF', 'Word', 'HTML'];
            const confirmation = confirm(`Exporter le document dans tous les formats (${formats.join(', ')}) ?`);
            
            if (confirmation) {
                alert('Export groupé lancé pour tous les formats !');
            }
        });
    </script>
</body>
</html>