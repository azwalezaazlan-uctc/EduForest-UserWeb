<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleSidebarBtn');
    const sidebar = document.getElementById('mainSidebar');
    const content = document.getElementById('contentWrapper');

    if (!toggleBtn || !sidebar || !content) return;

    let sidebarOpen = true;

    toggleBtn.addEventListener('click', function () {
        if (sidebarOpen) {
            sidebar.style.transform = 'translateX(-400px)';
            content.style.marginLeft = '0px';
            sidebarOpen = false;
        } else {
            sidebar.style.transform = 'translateX(0px)';
            content.style.marginLeft = '400px';
            sidebarOpen = true;
        }
    });
});
</script>