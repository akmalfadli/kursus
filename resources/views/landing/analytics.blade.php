<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Track Page View on Load
    trackEvent('page_view', {
        url: window.location.href,
        title: document.title,
        referrer: document.referrer
    });

    // 2. Track Section Visibility (Benefits & Pricing)
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5 // Trigger when 50% of section is visible
    };

    const sectionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const sectionId = entry.target.id;
                if (sectionId) {
                    trackEvent('section_view', { section: sectionId });
                    observer.unobserve(entry.target); // Track only once per session/page load
                }
            }
        });
    }, observerOptions);

    const benefitsSection = document.getElementById('benefits');
    const pricingSection = document.getElementById('pricing');
    const blogSection = document.getElementById('blog');

    if (benefitsSection) sectionObserver.observe(benefitsSection);
    if (pricingSection) sectionObserver.observe(pricingSection);
    if (blogSection) sectionObserver.observe(blogSection);

    // 3. Track Article Clicks (from landing list or sidebar)
    document.querySelectorAll('a[href*="/blog/"]').forEach(link => {
        link.addEventListener('click', function() {
            trackEvent('article_click', {
                url: this.href,
                text: this.innerText.trim()
            });
        });
    });

    // Helper function to send data
    function trackEvent(eventType, eventData) {
        fetch('{{ route("api.analytics.track") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                event_type: eventType,
                event_data: eventData
            })
        }).catch(err => console.error('Analytics Error:', err));
    }
});
</script>
