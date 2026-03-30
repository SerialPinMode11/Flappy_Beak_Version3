<script>
function toggleFAQ(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('i');
    const toggle = button.querySelector('div');
    const section = button.closest('[data-category]');
    if (!section) return;

    section.querySelectorAll('.faq-answer').forEach(function (item) {
        if (item !== answer) item.classList.remove('active');
    });

    section.querySelectorAll('.faq-item button i').forEach(function (item) {
        if (item !== icon) item.className = 'fas fa-plus text-gray-600 text-sm';
    });

    section.querySelectorAll('.faq-item button div').forEach(function (item) {
        if (item !== toggle) {
            item.className = 'w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200';
        }
    });

    answer.classList.toggle('active');

    if (answer.classList.contains('active')) {
        icon.className = 'fas fa-minus text-white text-sm';
        toggle.className = 'w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200 transform rotate-180';
    } else {
        icon.className = 'fas fa-plus text-gray-600 text-sm';
        toggle.className = 'w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center ml-4 flex-shrink-0 transition-all duration-200';
    }
}

function searchFAQ() {
    const input = document.getElementById('faqSearch');
    if (!input) return;
    const searchTerm = input.value.toLowerCase();
    const faqItems = document.querySelectorAll('.faq-item');
    const sections = document.querySelectorAll('[data-category]');

    if (searchTerm === '') {
        faqItems.forEach(function (item) { item.style.display = 'block'; });
        sections.forEach(function (section) { section.style.display = 'block'; });
        return;
    }

    sections.forEach(function (section) {
        let hasVisibleItems = false;
        const items = section.querySelectorAll('.faq-item');

        items.forEach(function (item) {
            const keywords = item.getAttribute('data-keywords') || '';
            const span = item.querySelector('span');
            const answerEl = item.querySelector('.faq-answer');
            const questionText = span ? span.textContent.toLowerCase() : '';
            const answerText = answerEl ? answerEl.textContent.toLowerCase() : '';

            if (keywords.includes(searchTerm) || questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                item.style.display = 'block';
                hasVisibleItems = true;
            } else {
                item.style.display = 'none';
            }
        });

        section.style.display = hasVisibleItems ? 'block' : 'none';
    });
}
</script>
