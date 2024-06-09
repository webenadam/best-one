jQuery(document).ready(function($) {
    $('[lightbox-type]').css('cursor', 'pointer').on('click', function() {
        const type = $(this).attr('lightbox-type');
        const content = $(this).attr('lightbox-content');
        openLightbox(type, content);
    });

    function openLightbox(type, content) {
        let $overlay, $innerContent;

        if (type === 'image') {
            $overlay = $('<div class="lightbox-overlay"></div>').css('display', 'flex').hide();
            $innerContent = $('<img>', { src: content, class: 'lightbox-image shadow-l' });
        } else if (content.startsWith('#')) {
            const $contentDiv = $(content);
            if ($contentDiv.length) {
                $overlay = $contentDiv.css('display', 'flex').hide();
                $innerContent = $contentDiv.children().addClass('radius-m active');
            } else {
                console.error('Element with ID ' + content + ' not found.');
                return;
            }
        } else {
            $overlay = $('<div class="lightbox-overlay"></div>').hide();
            $innerContent = $('<div class="lightbox-content"></div>').text(content);
        }

        const $closeButton = $('<div class="lightbox-close">&times;</div>');
        $closeButton.on('click', closeLightbox);
        $(document).on('keydown.lightbox', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        $overlay.on('click', function(e) {
            if (!$(e.target).closest('.lightbox-image, .lightbox-content, .lightbox-close').length) {
                closeLightbox();
            }
        });

        function closeLightbox() {
            $innerContent.fadeOut(400);
            $overlay.fadeOut(400);
            $(document).off('keydown.lightbox');
        }

        if (!content.startsWith('#')) {
            $overlay.append($innerContent).append($closeButton);
            $('body').append($overlay);
        } else {
            $overlay.append($closeButton);
        }

        $overlay.addClass('active').fadeIn(400, function() {
            $innerContent.fadeIn(400);
        });
    }
});
