/* Custom style for filter buttons and activity badge */
document.addEventListener('DOMContentLoaded', function() {
  const style = document.createElement('style');
  style.textContent = `
    /* Activity badge styled like filter buttons */
    .activity-badge {
      padding: 0.25rem 0.75rem;
      font-size: 0.75rem;
      border-radius: 9999px;
      font-weight: 500;
      background-color: #e9d5ff;
      color: #7c3aed;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      white-space: nowrap;
      line-height: 1.1;
      height: 1.5rem;
    }
    
    /* Dark mode for activity badge */
    .dark-mode .activity-badge {
      background-color: rgba(124, 58, 237, 0.2);
      color: #c4b5fd;
    }
  `;
  document.head.appendChild(style);
  
  // Add click handler for filter buttons
  const filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      // Remove selected class from all filter buttons in this group
      const parentContainer = this.closest('.flex.space-x-2');
      if (parentContainer) {
        parentContainer.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('selected'));
        // Add selected class to clicked button
        this.classList.add('selected');
      }
    });
  });
});
