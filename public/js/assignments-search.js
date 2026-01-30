// ...existing code...
document.addEventListener('DOMContentLoaded', function() {
    console.log('Assignments Search Script: Loaded');
    const searchInput = document.getElementById('assignmentSearchInput');
    if (!searchInput) {
        console.error('Assignments Search Script: Error - Input #assignmentSearchInput not found!');
        return;
    }
    searchInput.addEventListener('input', function() {
        console.log('Input detected: ', this.value); // Debug: Confirm event fires
        filterAssignmentsTable();
    });
});

function filterAssignmentsTable() {
    const input = document.getElementById('assignmentSearchInput');
    const filter = input.value.trim();
    const table = document.getElementById('assignmentsTable');
    if (!table) {
        console.error('Error: Table #assignmentsTable not found');
        return;
    }
    const rows = table.querySelectorAll('tbody tr');
    // Escape special regex characters to prevent crashes
    const escapedFilter = filter.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escapedFilter})`, 'gi');
    let matchFound = false;
    // 1. Reset: Remove existing highlights (revert to plain text)
    table.querySelectorAll('.highlight').forEach(mark => {
        const parent = mark.parentNode;
        parent.replaceChild(document.createTextNode(mark.textContent), mark);
        parent.normalize(); 
    });
    // Remove "No results" message if present
    const noResultsRow = table.querySelector('.no-results');
    if (noResultsRow) noResultsRow.remove();
    // 2. Search Loop
    rows.forEach((row, index) => {
        // Skip the "No Results" row if it somehow persisted
        if (row.classList.contains('no-results')) return;
        if (filter === "") {
            row.style.display = '';
            matchFound = true;
            return;
        }
        let rowHasMatch = false;
        // SELECTOR CHECK: This must match the class in your Blade file
        const targets = row.querySelectorAll('.search-text');
        if (index === 0 && targets.length === 0) {
            console.warn('Debug: First row has 0 elements with class .search-text. Check Blade file.');
        }
        targets.forEach(target => {
            // Only search text nodes to avoid breaking nested HTML
            const text = target.textContent;
            if (regex.test(text)) {
                rowHasMatch = true;
                // Highlight logic
                target.innerHTML = text.replace(regex, '<span class="highlight">$1</span>');
            }
        });
        if (rowHasMatch) {
            row.style.display = '';
            matchFound = true;
        } else {
            row.style.display = 'none';
        }
    });
    // 3. Handle No Results
    if (!matchFound && filter !== "") {
        const tbody = table.querySelector('tbody');
        const noResults = document.createElement('tr');
        noResults.className = 'no-results';
        noResults.innerHTML = `<td colspan="6" style="text-align:center; padding:2rem; color:#64748b;">No matching assignments found</td>`;
        tbody.appendChild(noResults);
    }
}
// ...existing code...