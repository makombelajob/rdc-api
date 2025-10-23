// ===== PROFESSIONAL DASHBOARD JAVASCRIPT =====

// Configuration
const CONFIG = {
    animationDuration: 300,
    loadingTimeout: 10000,
    maxRetries: 3
};

// Fonction pour charger et afficher les données d'une API avec améliorations
async function loadData(url, containerId) {
    const dataPreview = document.getElementById('data-preview');
    const apiName = document.getElementById('api-name');
    const apiData = document.getElementById('api-data');
    
    // Afficher la section de prévisualisation
    dataPreview.style.display = 'block';
    apiName.textContent = containerId.replace(/_/g, ' ');
    
    // Animation d'apparition
    dataPreview.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    // Afficher le spinner de chargement
    apiData.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <h5 class="text-muted">Chargement des données...</h5>
            <p class="text-muted small">Récupération des informations depuis l'API</p>
        </div>
    `;
    
    try {
        const response = await fetchWithRetry(url, CONFIG.maxRetries);
        
        if (!response.ok) {
            let errorMessage = `Erreur HTTP ${response.status}: ${response.statusText}`;
            
            // Messages spécifiques selon le code d'erreur
            switch(response.status) {
                case 406:
                    errorMessage = 'Erreur 406: Le serveur ne peut pas produire une réponse correspondant aux en-têtes Accept. Vérifiez que l\'API retourne du JSON.';
                    break;
                case 404:
                    errorMessage = 'Erreur 404: L\'API n\'a pas été trouvée. Vérifiez l\'URL.';
                    break;
                case 500:
                    errorMessage = 'Erreur 500: Erreur interne du serveur.';
                    break;
                case 401:
                    errorMessage = 'Erreur 401: Authentification requise.';
                    break;
                case 403:
                    errorMessage = 'Erreur 403: Accès interdit.';
                    break;
            }
            
            throw new Error(errorMessage);
        }
        
        const data = await response.json();
            displayData(data, containerId);
        
        // Animation de succès
        showSuccessMessage();
        
    } catch (error) {
        console.error('Erreur lors du chargement:', error);
        displayError(error.message);
    }
}

// Fonction pour réessayer les requêtes en cas d'échec
async function fetchWithRetry(url, maxRetries) {
    let lastError;
    
    // Différentes configurations d'en-têtes à essayer
    const headerConfigs = [
        { 'Accept': 'application/json' },
        { 'Accept': 'application/json, text/plain, */*' },
        { 'Accept': '*/*' },
        {} // Pas d'en-têtes du tout
    ];
    
    for (let i = 0; i < maxRetries; i++) {
        for (let configIndex = 0; configIndex < headerConfigs.length; configIndex++) {
            try {
                const response = await fetch(url, {
                    headers: headerConfigs[configIndex],
                    method: 'GET'
                });
                
                if (response.ok) {
                    return response;
                }
                
                // Si c'est une erreur 406, essayer la configuration suivante
                if (response.status === 406 && configIndex < headerConfigs.length - 1) {
                    continue;
                }
                
                lastError = new Error(`HTTP ${response.status}`);
                
            } catch (error) {
                lastError = error;
            }
        }
        
        // Attendre avant de réessayer (backoff exponentiel)
        if (i < maxRetries - 1) {
            await new Promise(resolve => setTimeout(resolve, Math.pow(2, i) * 1000));
        }
    }
    
    throw lastError;
}

// Fonction pour afficher les données avec un design moderne
function displayData(data, containerId) {
    const apiData = document.getElementById('api-data');
    
    // Effacer le contenu précédent
    apiData.innerHTML = '';
    
    // Créer le conteneur principal
    const container = document.createElement('div');
    container.className = 'data-container';
    
    // En-tête avec informations sur l'API
    const header = document.createElement('div');
    header.className = 'data-header mb-4';
    header.innerHTML = `
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="mb-0">
                <i class="bi bi-database-fill text-primary me-2"></i>
                Données de l'API
            </h4>
            <span class="badge bg-success">
                <i class="bi bi-check-circle me-1"></i>
                Connecté
            </span>
        </div>
        <p class="text-muted mt-2 mb-0">
            Dernière mise à jour: ${new Date().toLocaleString('fr-FR')}
        </p>
    `;
    
    container.appendChild(header);
    
    // Traiter les données selon leur structure
    const items = data['hydra:member'] || data;
    
    if (Array.isArray(items)) {
        if (items.length === 0) {
            container.appendChild(createEmptyState());
        } else {
            container.appendChild(createDataTable(items));
        }
    } else if (typeof items === 'object') {
        container.appendChild(createObjectDisplay(items));
    } else {
        container.appendChild(createSimpleDisplay(items));
    }
    
    // Ajouter les statistiques
    container.appendChild(createStats(items));
    
    // Animation d'apparition
    apiData.appendChild(container);
    container.style.opacity = '0';
    container.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        container.style.transition = 'all 0.5s ease-out';
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
    }, 100);
}

// Créer un tableau de données moderne
function createDataTable(items) {
    const tableContainer = document.createElement('div');
    tableContainer.className = 'table-responsive';
    
    const table = document.createElement('table');
    table.className = 'table table-hover table-striped';
    
    // En-tête du tableau
    const thead = document.createElement('thead');
    thead.className = 'table-dark';
    
    if (items.length > 0) {
        const firstItem = items[0];
        const headers = Object.keys(firstItem).filter(key => !key.startsWith('@'));
        
        const headerRow = document.createElement('tr');
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = formatHeader(header);
            th.scope = 'col';
            headerRow.appendChild(th);
        });
        
        thead.appendChild(headerRow);
    }
    
    // Corps du tableau
    const tbody = document.createElement('tbody');
    items.slice(0, 50).forEach((item, index) => { // Limiter à 50 éléments pour les performances
        const row = document.createElement('tr');
        row.className = index % 2 === 0 ? 'table-light' : '';
        
        // Ajouter un ID de ligne pour le style
        row.setAttribute('data-index', index);
        
        Object.entries(item)
            .filter(([key]) => !key.startsWith('@'))
            .forEach(([key, value]) => {
                const cell = document.createElement('td');
                cell.className = 'align-middle';
                
                // Si c'est un objet ou un tableau, utiliser un affichage compact
                if (typeof value === 'object' && value !== null) {
                    if (Array.isArray(value)) {
                        cell.innerHTML = `
                            <div class="compact-display">
                                <span class="badge bg-info me-1">${value.length}</span>
                                <small class="text-muted">éléments</small>
                            </div>
                        `;
                    } else {
                        const keys = Object.keys(value);
                        cell.innerHTML = `
                            <div class="compact-display">
                                <span class="badge bg-secondary me-1">${keys.length}</span>
                                <small class="text-muted">propriétés</small>
                            </div>
                        `;
                    }
                } else {
                    cell.innerHTML = formatValue(value);
                }
                
                row.appendChild(cell);
            });
        
        tbody.appendChild(row);
    });
    
    table.appendChild(thead);
    table.appendChild(tbody);
    tableContainer.appendChild(table);
    
    // Message si plus de 50 éléments
    if (items.length > 50) {
        const info = document.createElement('div');
        info.className = 'alert alert-info mt-3';
        info.innerHTML = `
            <i class="bi bi-info-circle me-2"></i>
            Affichage des 50 premiers éléments sur ${items.length} au total.
        `;
        tableContainer.appendChild(info);
    }
    
    return tableContainer;
}

// Créer l'affichage d'un objet
function createObjectDisplay(obj) {
    const container = document.createElement('div');
    container.className = 'object-display';
    
    const card = document.createElement('div');
    card.className = 'card';
    
    const cardBody = document.createElement('div');
    cardBody.className = 'card-body';
    
    Object.entries(obj).forEach(([key, value]) => {
        if (!key.startsWith('@')) {
            const row = document.createElement('div');
            row.className = 'row mb-2';
            
            const labelCol = document.createElement('div');
            labelCol.className = 'col-md-3';
            labelCol.innerHTML = `<strong>${formatHeader(key)}:</strong>`;
            
            const valueCol = document.createElement('div');
            valueCol.className = 'col-md-9';
            valueCol.innerHTML = formatValue(value);
            
            row.appendChild(labelCol);
            row.appendChild(valueCol);
            cardBody.appendChild(row);
        }
    });
    
    card.appendChild(cardBody);
    container.appendChild(card);
    
    return container;
}

// Créer l'affichage simple
function createSimpleDisplay(value) {
    const container = document.createElement('div');
    container.className = 'simple-display text-center py-4';
    container.innerHTML = `
        <div class="display-value h4 text-primary">${formatValue(value)}</div>
    `;
    return container;
}

// Créer l'état vide
function createEmptyState() {
    const container = document.createElement('div');
    container.className = 'empty-state text-center py-5';
    container.innerHTML = `
        <div class="empty-icon mb-3">
            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
        </div>
        <h5 class="text-muted">Aucune donnée disponible</h5>
        <p class="text-muted">Cette API ne contient actuellement aucune donnée.</p>
    `;
    return container;
}

// Créer les statistiques
function createStats(items) {
    const container = document.createElement('div');
    container.className = 'stats-container mt-4';
    
    const statsRow = document.createElement('div');
    statsRow.className = 'row g-3';
    
    const stats = [
        { label: 'Total d\'éléments', value: Array.isArray(items) ? items.length : 1, icon: 'bi-list-ul', color: 'primary' },
        { label: 'Type de données', value: Array.isArray(items) ? 'Array' : 'Object', icon: 'bi-type', color: 'info' },
        { label: 'Taille', value: formatSize(JSON.stringify(items)), icon: 'bi-hdd', color: 'success' },
        { label: 'Statut', value: 'Actif', icon: 'bi-check-circle', color: 'success' }
    ];
    
    stats.forEach(stat => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3';
        
        col.innerHTML = `
            <div class="stat-card text-center p-3 bg-light rounded">
                <i class="bi ${stat.icon} text-${stat.color} fs-4 mb-2"></i>
                <div class="stat-value h5 mb-1">${stat.value}</div>
                <div class="stat-label small text-muted">${stat.label}</div>
            </div>
        `;
        
        statsRow.appendChild(col);
    });
    
    container.appendChild(statsRow);
    return container;
}

// Fonctions utilitaires
function formatHeader(header) {
    return header
        .replace(/([A-Z])/g, ' $1')
        .replace(/^./, str => str.toUpperCase())
        .trim();
}

function formatValue(value) {
    if (value === null) return '<span class="text-muted fst-italic">null</span>';
    if (value === undefined) return '<span class="text-muted fst-italic">undefined</span>';
    
    if (typeof value === 'boolean') {
        return `<span class="badge bg-${value ? 'success' : 'danger'}">
                    <i class="bi bi-${value ? 'check' : 'x'}-circle me-1"></i>
                    ${value ? 'Vrai' : 'Faux'}
                </span>`;
    }
    
    if (typeof value === 'number') {
        const formatted = value.toLocaleString('fr-FR');
        return `<span class="text-primary fw-bold">${formatted}</span>`;
    }
    
    if (typeof value === 'string') {
        // URLs
        if (value.startsWith('http')) {
            return `<a href="${value}" target="_blank" class="text-decoration-none text-info">
                        <i class="bi bi-link-45deg me-1"></i>
                        ${value}
                    </a>`;
        }
        
        // Dates
        if (value.match(/^\d{4}-\d{2}-\d{2}/)) {
            try {
                const date = new Date(value);
                return `<span class="text-info">
                            <i class="bi bi-calendar3 me-1"></i>
                            ${date.toLocaleString('fr-FR')}
                        </span>`;
            } catch (e) {
                return value;
            }
        }
        
        // Emails
        if (value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            return `<a href="mailto:${value}" class="text-decoration-none text-warning">
                        <i class="bi bi-envelope me-1"></i>
                        ${value}
                    </a>`;
        }
        
        // Texte long (plus de 100 caractères)
        if (value.length > 100) {
            return `<div class="text-truncate" title="${value}">
                        <i class="bi bi-file-text me-1"></i>
                        ${value.substring(0, 100)}...
                    </div>`;
        }
        
        return `<span class="text-dark">${value}</span>`;
    }
    
    if (typeof value === 'object') {
        if (Array.isArray(value)) {
            if (value.length === 0) {
                return '<span class="text-muted fst-italic">Tableau vide</span>';
            }
            
            return `<div class="array-display">
                        <span class="badge bg-info me-2">${value.length} éléments</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleArray(this)">
                            <i class="bi bi-eye me-1"></i>
                            Voir le contenu
                        </button>
                        <div class="array-content mt-2" style="display: none;">
                            ${value.map((item, index) => `
                                <div class="array-item border-start border-3 border-info ps-2 mb-1">
                                    <strong class="text-info">[${index}]:</strong> ${formatValue(item)}
                                </div>
                            `).join('')}
                        </div>
                    </div>`;
        }
        
        // Objet
        const keys = Object.keys(value);
        if (keys.length === 0) {
            return '<span class="text-muted fst-italic">Objet vide</span>';
        }
        
        return `<div class="object-display">
                    <span class="badge bg-secondary me-2">${keys.length} propriétés</span>
                    <button class="btn btn-sm btn-outline-secondary" onclick="toggleObject(this)">
                        <i class="bi bi-eye me-1"></i>
                        Voir le contenu
                    </button>
                    <div class="object-content mt-2" style="display: none;">
                        ${keys.map(key => `
                            <div class="object-item border-start border-3 border-secondary ps-2 mb-1">
                                <strong class="text-secondary">${formatHeader(key)}:</strong> ${formatValue(value[key])}
                            </div>
                        `).join('')}
                    </div>
                </div>`;
    }
    
    return `<code class="text-muted">${value}</code>`;
}

function formatSize(str) {
    const bytes = new Blob([str]).size;
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
}

function displayError(message) {
    const apiData = document.getElementById('api-data');
    apiData.innerHTML = `
        <div class="error-state text-center py-5">
            <div class="error-icon mb-3">
                <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-danger">Erreur de chargement</h5>
            <p class="text-muted mb-3">${message}</p>
            
            <div class="debug-info bg-light p-3 rounded mb-3 text-start">
                <h6 class="text-info mb-2">
                    <i class="bi bi-bug me-1"></i>
                    Informations de débogage :
                </h6>
                <ul class="small text-muted mb-0">
                    <li>Vérifiez que l'URL de l'API est correcte</li>
                    <li>Assurez-vous que l'API retourne du JSON</li>
                    <li>Vérifiez les CORS si l'API est sur un autre domaine</li>
                    <li>Consultez la console du navigateur pour plus de détails</li>
                </ul>
            </div>
            
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-outline-primary" onclick="retryLastRequest()">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Réessayer
                </button>
                <button class="btn btn-outline-secondary" onclick="openInNewTab()">
                    <i class="bi bi-box-arrow-up-right me-1"></i>
                    Ouvrir l'API
                </button>
            </div>
        </div>
    `;
}

function showSuccessMessage() {
    // Créer une notification de succès temporaire
    const notification = document.createElement('div');
    notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="bi bi-check-circle me-2"></i>
        Données chargées avec succès !
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Supprimer automatiquement après 3 secondes
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Variables globales pour le retry
let lastRequest = null;

function retryLastRequest() {
    if (lastRequest) {
        loadData(lastRequest.url, lastRequest.containerId);
    }
}

function openInNewTab() {
    if (lastRequest) {
        window.open(lastRequest.url, '_blank');
    }
}

// Fonctions pour afficher/masquer le contenu des objets et tableaux
function toggleArray(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.className = 'bi bi-eye-slash me-1';
        button.innerHTML = '<i class="bi bi-eye-slash me-1"></i>Masquer le contenu';
    } else {
        content.style.display = 'none';
        icon.className = 'bi bi-eye me-1';
        button.innerHTML = '<i class="bi bi-eye me-1"></i>Voir le contenu';
    }
}

function toggleObject(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.className = 'bi bi-eye-slash me-1';
        button.innerHTML = '<i class="bi bi-eye-slash me-1"></i>Masquer le contenu';
    } else {
        content.style.display = 'none';
        icon.className = 'bi bi-eye me-1';
        button.innerHTML = '<i class="bi bi-eye me-1"></i>Voir le contenu';
    }
}

// Fonction pour initialiser les boutons avec améliorations
function initButtons() {
    const buttons = document.querySelectorAll('.load-data-btn');
    
    buttons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            
            const url = btn.dataset.url;
            const containerId = btn.dataset.name;
            
            // Sauvegarder pour le retry
            lastRequest = { url, containerId };
            
            // Ajouter un état de chargement au bouton
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Chargement...';
            btn.disabled = true;
            
            loadData(url, containerId).finally(() => {
                // Restaurer le bouton
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    });
}

// Fonction pour fermer la prévisualisation des données
function closeDataPreview() {
    const dataPreview = document.getElementById('data-preview');
    dataPreview.style.transition = 'all 0.3s ease-out';
    dataPreview.style.opacity = '0';
    dataPreview.style.transform = 'translateY(-20px)';
    
    setTimeout(() => {
        dataPreview.style.display = 'none';
        dataPreview.style.opacity = '1';
        dataPreview.style.transform = 'translateY(0)';
    }, 300);
}

// Fonction pour ajouter des animations au scroll
function initScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observer les cartes d'API et les fonctionnalités
    document.querySelectorAll('.api-card, .feature-card').forEach(card => {
        observer.observe(card);
    });
}

// Fonction pour améliorer l'accessibilité
function initAccessibility() {
    // Ajouter des attributs ARIA
    document.querySelectorAll('.load-data-btn').forEach(btn => {
        btn.setAttribute('aria-label', `Charger les données pour ${btn.dataset.name}`);
    });
    
    // Gestion du focus pour les modales
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const dataPreview = document.getElementById('data-preview');
            if (dataPreview.style.display !== 'none') {
                closeDataPreview();
            }
        }
    });
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
initButtons();
    initScrollAnimations();
    initAccessibility();
    
    // Ajouter un effet de parallaxe subtil au hero
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        if (heroSection) {
            heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
});

// Fonction pour gérer les erreurs globales
window.addEventListener('error', (e) => {
    console.error('Erreur JavaScript:', e.error);
});

// Fonction pour gérer les promesses rejetées
window.addEventListener('unhandledrejection', (e) => {
    console.error('Promesse rejetée:', e.reason);
});