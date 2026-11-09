<script>
    (() => {
        try {
            if (localStorage.getItem('work-tracker-theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        } catch (error) {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>
