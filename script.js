const body = document.querySelector("body");
const modeToggle = body.querySelector(".mode-toggle");
const sidebar = body.querySelector("nav");
const sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if (getMode === "dark") {
    body.classList.add("dark");
}

let getStatus = localStorage.getItem("status");
if (getStatus === "close") {
    sidebar.classList.add("close");
}

if (modeToggle) {
    modeToggle.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
            localStorage.setItem("mode", "dark");
        } else {
            localStorage.setItem("mode", "light");
        }
    });
}

// Hamburger / sidebar toggle
function toggleSidebar(){
    sidebar.classList.toggle('close');
    if(sidebar.classList.contains('close')){
        localStorage.setItem('status','close');
        if(sidebarToggle) sidebarToggle.setAttribute('aria-expanded','false');
        // update overlay aria and allow body scroll
        const ov = document.getElementById('sidebar-overlay');
        if(ov) ov.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('no-scroll');
    } else {
        localStorage.setItem('status','open');
        if(sidebarToggle) sidebarToggle.setAttribute('aria-expanded','true');
        // show overlay and prevent body scroll on small screens
        const ov = document.getElementById('sidebar-overlay');
        if(ov) ov.setAttribute('aria-hidden', 'false');
        // prevent page scroll when sidebar overlays content
        document.body.classList.add('no-scroll');
    }
}

if (sidebarToggle) {
    // Make the icon keyboard-accessible
    sidebarToggle.setAttribute('role', 'button');
    sidebarToggle.setAttribute('tabindex', '0');
    // Accessibility: point to the sidebar and reflect expanded state
    sidebarToggle.setAttribute('aria-controls', 'sidebar');
    sidebarToggle.setAttribute('aria-expanded', (!sidebar.classList.contains('close')).toString());
    sidebarToggle.addEventListener('click', toggleSidebar);
    sidebarToggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleSidebar();
        }
    });
}

// Close sidebar with Escape key for accessibility
document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape' && !sidebar.classList.contains('close')){
        toggleSidebar();
    }
});

// (Removed global click-outside handler) overlay click handles closing on all sizes now.

// Overlay click should also close the sidebar
const overlay = document.getElementById('sidebar-overlay');
if(overlay){
    overlay.addEventListener('click', (e) => {
        // close sidebar on overlay click (all screen sizes)
        if(!sidebar.classList.contains('close')){
            toggleSidebar();
        }
    });
}

// Close button inside sidebar (support both spellings just in case)
const closeSidebarBtn = document.getElementById('close-sidebar-btn');
if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (!sidebar.classList.contains('close')) toggleSidebar();
    });
}

// initialize overlay aria-hidden and body scroll state to match initial sidebar state
if(overlay){
    overlay.setAttribute('aria-hidden', sidebar.classList.contains('close') ? 'true' : 'false');
    if(!sidebar.classList.contains('close')){
        document.body.classList.add('no-scroll');
    } else {
        document.body.classList.remove('no-scroll');
    }
}

// --- Filter table by estatus ---
const statusSelect = document.getElementById('filter-status');
const reportTableBody = document.querySelector('.report-table tbody');
if(statusSelect && reportTableBody){
    statusSelect.addEventListener('change', () => {
        const filter = statusSelect.value; // 'all' or status text
        const rows = reportTableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const statusBadge = row.querySelector('td:nth-child(4) .status-badge');
            if(!statusBadge){
                row.style.display = '';
                return;
            }
            const text = statusBadge.textContent.trim().toLowerCase();
            if(filter === 'all' || text === filter.toLowerCase()){
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}