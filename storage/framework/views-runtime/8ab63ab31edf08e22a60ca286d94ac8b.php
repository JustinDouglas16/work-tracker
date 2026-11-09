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
<?php /**PATH C:\wamp64\www\work-tracker\resources\views/components/theme-script.blade.php ENDPATH**/ ?>