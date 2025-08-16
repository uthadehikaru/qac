<x-web-layout>
<section id="faq" class="bg-white pt-24 text-gray-700">
    <div class="container px-5 py-6 mx-auto">
        <div class="text-center mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
            Frequently Asked Question
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
            The most common questions about QAC
            </p>
        </div>
        <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
            <div class="w-full px-4 py-2" id="faq-content" data-faq="{{ $faq }}">
                <!-- Markdown content will be rendered here -->
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
// Get FAQ content from data attribute
const container = document.getElementById('faq-content');
const faqMarkdown = container.getAttribute('data-faq');

// Configure marked options
marked.setOptions({
    breaks: true,
    gfm: true
});

// Function to render markdown with custom styling
function renderFAQ() {
    const container = document.getElementById('faq-content');
    
    // Convert markdown to HTML
    const html = marked.parse(faqMarkdown);
    
    // Add custom styling classes
    const styledHtml = html
        .replace(/<h1/g, '<h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 my-4"')
        .replace(/<h2/g, '<h2 class="font-semibold bg-gray-200 rounded-md py-2 px-4 mb-2 cursor-pointer" onclick="toggleSection(this)"')
        .replace(/<p/g, '<p class="py-1"')
        .replace(/<ul/g, '<ul class="list-disc pl-6"')
        .replace(/<ol/g, '<ol class="list-decimal pl-6"')
        .replace(/<li/g, '<li class="py-1"')
        .replace(/<a/g, '<a class="text-blue-600 hover:text-blue-800 underline"');
    
    container.innerHTML = styledHtml;
    
    // Add click handlers for collapsible sections
    addCollapsibleBehavior();
}

// Function to add collapsible behavior
function addCollapsibleBehavior() {
    const headers = document.querySelectorAll('h2');
    headers.forEach(header => {
        const content = header.nextElementSibling;
        if (content && content.tagName !== 'H1' && content.tagName !== 'H2') {
            // Create a wrapper for the content
            const wrapper = document.createElement('div');
            wrapper.className = 'faq-content mb-4';
            wrapper.style.display = 'none';
            
            // Move all content until next h2 or h1 into wrapper
            let nextElement = content;
            while (nextElement && nextElement.tagName !== 'H1' && nextElement.tagName !== 'H2') {
                const temp = nextElement.nextElementSibling;
                wrapper.appendChild(nextElement);
                nextElement = temp;
            }
            
            // Insert wrapper after header
            header.parentNode.insertBefore(wrapper, header.nextSibling);
            
            // Add click handler
            header.addEventListener('click', function() {
                const isOpen = wrapper.style.display !== 'none';
                wrapper.style.display = isOpen ? 'none' : 'block';
                header.classList.toggle('bg-gray-300');
            });
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', renderFAQ);
</script>

<style>
.faq-content {
    transition: all 0.3s ease;
}

h2 {
    transition: background-color 0.3s ease;
}

h2:hover {
    background-color: #e5e7eb !important;
}
</style>
</x-web-layout>