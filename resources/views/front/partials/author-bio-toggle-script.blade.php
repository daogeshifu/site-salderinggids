@once
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.js-author-bio-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const bioCard = this.closest('.author-card, .bio-card');
                const shortBio = bioCard.querySelector('.author-bio-short');
                const fullBio = bioCard.querySelector('.author-bio-full');
                const label = this.querySelector('.js-author-bio-toggle-label');
                const icon = this.querySelector('.js-author-bio-toggle-icon');
                const isExpanded = this.dataset.expanded === 'true';

                shortBio.classList.toggle('hidden', !isExpanded);
                fullBio.classList.toggle('hidden', isExpanded);
                label.textContent = isExpanded ? this.dataset.showMore : this.dataset.showLess;
                icon.textContent = isExpanded ? 'expand_more' : 'expand_less';
                this.dataset.expanded = isExpanded ? 'false' : 'true';
            });
        });
    });
</script>
@endonce
