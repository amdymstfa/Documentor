<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Rédacteur - Documentor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Documentor</h1>
                    <span class="ml-4 px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">Rédacteur</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span id="userName" class="text-gray-700 font-medium">Chargement...</span>
                    <button id="newDocBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        + Nouveau Document
                    </button>
                    <button id="logoutBtn" class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-lg transition-colors">
                        Déconnexion
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div id="loadingScreen" class="fixed inset-0 bg-white flex items-center justify-center z-50">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600">Chargement...</p>
        </div>
    </div>

    <div id="mainContent" class="hidden max-w-7xl mx-auto px-4 py-8">
        
        <div id="documentsView">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Mes Cahiers des Charges</h2>
                <div class="text-sm text-gray-500">
                    <span id="documentsCount">0</span> document(s)
                </div>
            </div>
            
            <div id="documentsList" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                 Documents seront chargés ici 
            </div>
        </div>

        <div id="editView" class="hidden">
            <div class="mb-6">
                <button id="backBtn" class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                    ← Retour aux documents
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-sm border">
                 En-tête du document 
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between mb-4">
                        <input id="docTitle" type="text" class="text-2xl font-bold text-gray-900 border-none outline-none bg-transparent flex-1 mr-4" placeholder="Titre du cahier des charges">
                        <div class="flex items-center space-x-3">
                            <span id="docStatus" class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">Brouillon</span>
                            <button id="saveDocBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                💾 Sauvegarder
                            </button>
                            <button id="submitDocBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                📤 Soumettre
                            </button>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        Document ID: <span id="docId" class="font-medium"></span> | 
                        Créé le: <span id="docCreated" class="font-medium"></span>
                    </div>
                </div>

                 Sections du document 
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Sections du Cahier des Charges</h3>
                        <button id="addSectionBtn" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            + Ajouter Section
                        </button>
                    </div>
                    
                    <div id="sectionsList" class="space-y-6">
                         Sections seront chargées ici 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="newDocModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Nouveau Cahier des Charges</h3>
            <form id="newDocForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                    <input id="newDocTitle" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Ex: Cahier des charges site e-commerce" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de projet</label>
                    <select id="newDocTemplate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="standard">Standard</option>
                        <option value="site-web">Site Web</option>
                        <option value="application-mobile">Application Mobile</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelNewDoc" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="newSectionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Nouvelle Section</h3>
            <form id="newSectionForm">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre de la section</label>
                    <input id="newSectionTitle" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Ex: Spécifications fonctionnelles" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelNewSection" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Configuration
        const API_BASE = '/api';
        
        // État global
        let currentUser = null;
        let currentDocument = null;
        let documents = [];

        // Éléments DOM
        const loadingScreen = document.getElementById('loadingScreen');
        const mainContent = document.getElementById('mainContent');
        const documentsView = document.getElementById('documentsView');
        const editView = document.getElementById('editView');
        const documentsList = document.getElementById('documentsList');
        const sectionsList = document.getElementById('sectionsList');
        const newDocModal = document.getElementById('newDocModal');
        const newSectionModal = document.getElementById('newSectionModal');

        // Utilitaires API
        async function apiCall(endpoint, options = {}) {
            try {
                const config = {
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                    ...options
                };
                
                const response = await fetch(API_BASE + endpoint, config);
                const contentType = response.headers.get('content-type');
                
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Réponse non-JSON du serveur');
                }
                
                const data = await response.json();
                
                if (!data.success) {
                    if (response.status === 401) {
                        window.location.href = '/';
                        return;
                    }
                    throw new Error(data.error || 'Erreur API');
                }
                
                return data;
            } catch (error) {
                console.error('Erreur API:', error);
                throw error;
            }
        }

        // Initialisation
        async function initializeApp() {
            try {
                const userResult = await apiCall('/user');
                currentUser = userResult.data;
                
                if (currentUser.role_id !== 1) {
                    throw new Error('Accès non autorisé - Rôle rédacteur requis');
                }
                
                document.getElementById('userName').textContent = currentUser.nom;
                await loadDocuments();
                showMainContent();
                
            } catch (error) {
                console.error('Erreur d\'initialisation:', error);
                alert('Erreur de connexion. Redirection vers la page de connexion...');
                window.location.href = '/';
            }
        }

        function showMainContent() {
            loadingScreen.classList.add('hidden');
            mainContent.classList.remove('hidden');
        }

        // Gestion des documents
        async function loadDocuments() {
            try {
                // ✅ CORRECTION : Utiliser le vrai endpoint
                const result = await apiCall('/documents');
                documents = result.data || [];
                renderDocuments();
            } catch (error) {
                console.error('Erreur chargement documents:', error);
                documents = [];
                renderDocuments();
            }
        }

        function renderDocuments() {
            document.getElementById('documentsCount').textContent = documents.length;
            
            if (documents.length === 0) {
                documentsList.innerHTML = `
                    <div class="col-span-full text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
                        <div class="text-gray-400 text-6xl mb-4">📄</div>
                        <div class="text-gray-600 text-lg mb-2">Aucun cahier des charges</div>
                        <div class="text-gray-500 mb-4">Créez votre premier document pour commencer</div>
                        <button onclick="showModal(newDocModal)" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            + Créer mon premier document
                        </button>
                    </div>
                `;
                return;
            }

            documentsList.innerHTML = documents.map(doc => `
                <div class="bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="editDocument(${doc.id})">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-semibold text-gray-900 text-lg">${escapeHtml(doc.titre)}</h3>
                            <span class="px-2 py-1 bg-${getStatusColor(doc.statut || 'Brouillon')}-100 text-${getStatusColor(doc.statut || 'Brouillon')}-800 text-xs font-medium rounded-full">
                                ${doc.statut || 'Brouillon'}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500 mb-4">
                            <div>📋 ${doc.sections ? doc.sections.length : 0} section(s)</div>
                            <div>👤 Rédacteur ID: ${doc.redacteur_id}</div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">ID: ${doc.id}</span>
                            <span class="text-blue-600 hover:text-blue-800">Ouvrir →</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getStatusColor(status) {
            const colors = {
                'Brouillon': 'yellow',
                'En cours': 'blue', 
                'Soumis': 'purple',
                'Validé': 'green',
                'Rejeté': 'red'
            };
            return colors[status] || 'gray';
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Création de document
        async function createDocument(titre, template) {
            try {
                const result = await apiCall('/documents', {
                    method: 'POST',
                    body: JSON.stringify({ titre, template })
                });
                
                // Recharger la liste des documents
                await loadDocuments();
                
                // Ouvrir directement le document créé
                editDocument(result.data.id);
                
                return result.data;
            } catch (error) {
                alert('Erreur lors de la création: ' + error.message);
            }
        }

        // Édition de document
        async function editDocument(documentId) {
            try {
                // ✅ CORRECTION : Utiliser le vrai endpoint
                const result = await apiCall(`/documents/${documentId}`);
                currentDocument = result.data;
                
                showEditView();
                renderDocument();
            } catch (error) {
                alert('Erreur lors du chargement: ' + error.message);
            }
        }

        function showEditView() {
            documentsView.classList.add('hidden');
            editView.classList.remove('hidden');
        }

        function showDocumentsView() {
            editView.classList.add('hidden');
            documentsView.classList.remove('hidden');
        }

        function renderDocument() {
            if (!currentDocument) return;

            // ✅ CORRECTION : Adapter à la structure de données du backend
            const doc = currentDocument.document || currentDocument;
            const sections = currentDocument.sections || [];

            document.getElementById('docTitle').value = doc.titre;
            document.getElementById('docId').textContent = doc.id;
            document.getElementById('docCreated').textContent = doc.created_at ? new Date(doc.created_at).toLocaleDateString('fr-FR') : 'N/A';
            document.getElementById('docStatus').textContent = doc.statut_nom || doc.statut || 'Brouillon';
            document.getElementById('docStatus').className = `px-3 py-1 bg-${getStatusColor(doc.statut_nom || doc.statut || 'Brouillon')}-100 text-${getStatusColor(doc.statut_nom || doc.statut || 'Brouillon')}-800 text-sm font-medium rounded-full`;

            renderSections(sections);
        }

        function renderSections(sections = []) {
            if (sections.length === 0) {
                sectionsList.innerHTML = `
                    <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <div class="text-gray-400 text-4xl mb-3">📝</div>
                        <div class="text-gray-600 mb-2">Aucune section</div>
                        <div class="text-gray-500 mb-4">Ajoutez des sections pour structurer votre cahier des charges</div>
                        <button onclick="showModal(newSectionModal)" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            + Ajouter la première section
                        </button>
                    </div>
                `;
                return;
            }

            sectionsList.innerHTML = sections.map((section, index) => `
                <div class="border rounded-lg p-6 bg-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <input type="text" value="${escapeHtml(section.titre)}" 
                               class="font-semibold text-gray-900 text-lg bg-transparent border-none outline-none flex-1" 
                               onchange="updateSectionTitle(${section.id}, this.value)">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500">Ordre: ${section.ordre || index + 1}</span>
                            <button onclick="deleteSection(${section.id})" class="text-red-600 hover:text-red-800 text-sm">
                                🗑️ Supprimer
                            </button>
                        </div>
                    </div>
                    <textarea 
                        class="w-full p-4 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        rows="6" 
                        placeholder="Rédigez le contenu de cette section..."
                        onchange="updateSectionContent(${section.id}, this.value)"
                    >${escapeHtml(section.contenu || '')}</textarea>
                </div>
            `).join('');
        }

        // Actions sur les sections
        async function updateSectionTitle(sectionId, newTitle) {
            try {
                await apiCall(`/sections/${sectionId}`, {
                    method: 'PATCH',
                    body: JSON.stringify({ titre: newTitle })
                });
                
                // Mettre à jour localement
                const sections = currentDocument.sections || [];
                const section = sections.find(s => s.id === sectionId);
                if (section) section.titre = newTitle;
            } catch (error) {
                alert('Erreur lors de la mise à jour: ' + error.message);
            }
        }

        async function updateSectionContent(sectionId, newContent) {
            try {
                await apiCall(`/sections/${sectionId}`, {
                    method: 'PATCH',
                    body: JSON.stringify({ contenu: newContent })
                });
                
                // Mettre à jour localement
                const sections = currentDocument.sections || [];
                const section = sections.find(s => s.id === sectionId);
                if (section) section.contenu = newContent;
            } catch (error) {
                alert('Erreur lors de la mise à jour: ' + error.message);
            }
        }

        async function addSection(titre) {
            try {
                // ✅ CORRECTION : Utiliser le vrai endpoint avec type_id
                const result = await apiCall(`/documents/${currentDocument.document.id}/sections`, {
                    method: 'POST',
                    body: JSON.stringify({ titre, type_id: 1 })
                });
                
                // Recharger le document
                await editDocument(currentDocument.document.id);
            } catch (error) {
                alert('Erreur lors de l\'ajout: ' + error.message);
            }
        }

        async function deleteSection(sectionId) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette section ?')) return;
            
            try {
                await apiCall(`/sections/${sectionId}`, {
                    method: 'DELETE'
                });
                
                // Supprimer localement
                const sections = currentDocument.sections || [];
                currentDocument.sections = sections.filter(s => s.id !== sectionId);
                renderSections(currentDocument.sections);
            } catch (error) {
                alert('Erreur lors de la suppression: ' + error.message);
            }
        }

        // Actions sur le document
        async function saveDocument() {
            if (!currentDocument) return;
            
            try {
                const titre = document.getElementById('docTitle').value;
                const docId = currentDocument.document ? currentDocument.document.id : currentDocument.id;
                
                // ✅ CORRECTION : Utiliser le vrai endpoint
                await apiCall(`/documents/${docId}`, {
                    method: 'PATCH',
                    body: JSON.stringify({ titre })
                });
                
                if (currentDocument.document) {
                    currentDocument.document.titre = titre;
                } else {
                    currentDocument.titre = titre;
                }
                alert('✅ Document sauvegardé avec succès !');
            } catch (error) {
                alert('❌ Erreur lors de la sauvegarde: ' + error.message);
            }
        }

        async function submitDocument() {
            if (!confirm('Êtes-vous sûr de vouloir soumettre ce document pour validation ?')) return;
            
            try {
                const docId = currentDocument.document ? currentDocument.document.id : currentDocument.id;
                
                // ✅ CORRECTION : Utiliser le vrai endpoint
                await apiCall(`/documents/${docId}/submit`, {
                    method: 'POST'
                });
                
                if (currentDocument.document) {
                    currentDocument.document.statut = 'Soumis';
                } else {
                    currentDocument.statut = 'Soumis';
                }
                renderDocument();
                alert('📤 Document soumis pour validation !');
            } catch (error) {
                alert('❌ Erreur lors de la soumission: ' + error.message);
            }
        }

        // Gestion des modals
        function showModal(modal) {
            modal.classList.remove('hidden');
        }

        function hideModal(modal) {
            modal.classList.add('hidden');
        }

        // Event Listeners
        document.getElementById('newDocBtn').addEventListener('click', () => showModal(newDocModal));
        document.getElementById('logoutBtn').addEventListener('click', async () => {
            if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                try {
                    await fetch('/logout', { method: 'POST' });
                } catch (e) {}
                window.location.href = '/';
            }
        });
        document.getElementById('backBtn').addEventListener('click', showDocumentsView);
        document.getElementById('saveDocBtn').addEventListener('click', saveDocument);
        document.getElementById('submitDocBtn').addEventListener('click', submitDocument);
        document.getElementById('addSectionBtn').addEventListener('click', () => showModal(newSectionModal));

        // Modal nouveau document
        document.getElementById('newDocForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const titre = document.getElementById('newDocTitle').value.trim();
            const template = document.getElementById('newDocTemplate').value;
            
            if (!titre) {
                alert('Veuillez saisir un titre');
                return;
            }
            
            await createDocument(titre, template);
            hideModal(newDocModal);
            document.getElementById('newDocForm').reset();
        });

        document.getElementById('cancelNewDoc').addEventListener('click', () => {
            hideModal(newDocModal);
            document.getElementById('newDocForm').reset();
        });

        // Modal nouvelle section
        document.getElementById('newSectionForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const titre = document.getElementById('newSectionTitle').value.trim();
            
            if (!titre) {
                alert('Veuillez saisir un titre');
                return;
            }
            
            await addSection(titre);
            hideModal(newSectionModal);
            document.getElementById('newSectionForm').reset();
        });

        document.getElementById('cancelNewSection').addEventListener('click', () => {
            hideModal(newSectionModal);
            document.getElementById('newSectionForm').reset();
        });

        // Fermer modals en cliquant à l'extérieur
        [newDocModal, newSectionModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) hideModal(modal);
            });
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', initializeApp);
    </script>
</body>
</html>