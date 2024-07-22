jQuery(document).ready(function($) {

    $('[lightbox-type]').css('cursor', 'pointer').on('click', function() {
        const type = $(this).attr('lightbox-type');
        const content = $(this).attr('lightbox-content');
        const title = $(this).attr('lightbox-title');
        const width = $(this).attr('lightbox-width') || '400px';
        const height = $(this).attr('lightbox-height') || '600px';
        openLightbox(type, content, title, width, height);
    });

    function openLightbox(type, content, title, width, height) {
        let $overlay, $innerContent;
        // close mobile menu to pravent conflict

        $('#header-nav').removeClass('active');
            $('.menu-toggle').removeClass('active');

            
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
        } else if (type === 'iframe') {
            $overlay = $('<div class="lightbox-overlay"></div>').hide();
            $innerContent = $('<div class="lightbox-content"><iframe src="' + content + '" title="' + title + '" width="' + width + '" height="' + height + '"></iframe></div>');
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
            $('.lightbox-content').fadeIn(400).addClass('radius-m active');
        });
    }
});
