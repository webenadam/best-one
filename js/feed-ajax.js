jQuery(document).ready(function($) {
    // Define the offset variable for scrolling
    var loadMoreScrollOffset = 250; // Adjust this value as needed

    // Initialize Bloodhound for typeahead
    var places = data.places;
    var placesBloodhound = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: places
    });

    // Object to store current filter values
    var currentFilters = {
        place: null,
        expert: null,
        sort_by: null,
        loaded_post_ids: initialLoadedPostIds || [], // Initialize with IDs of initially loaded posts
        initial_load: 9 // Number of posts loaded initially
    };

    // Function to trigger AJAX request
    function triggerAjaxRequest(reset = false, loadMore = false) {
        if (reset) {
            currentFilters.loaded_post_ids = [];
        }

        var place_input = $('.places-typeahead').val().trim();
        var expert_id = currentFilters.expert;
        var sort_by = currentFilters.sort_by;
        var loaded_post_ids = currentFilters.loaded_post_ids;
        var current_post_count = reset ? 0 : $('.main-feed .profile-box').length;

        console.log('Place Input:', place_input);
        console.log('Expert ID:', expert_id);
        console.log('Sort By:', sort_by);
        console.log('Loaded Post IDs:', loaded_post_ids);
        console.log('Current Post Count:', current_post_count);

        // Add ajax-loading class
        $('.main-feed').addClass('ajax-loading');

        $.ajax({
            url: data.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_sort_posts',
                place: place_input,
                expert: expert_id,
                sort_by: sort_by,
                loaded_post_ids: loaded_post_ids,
                current_post_count: current_post_count
            },
            success: function(response) {
                if (response.success) {
                    if (reset) {
                        // Replace the main feed content with new posts
                        $('.main-feed').html(response.data.html);
                    } else {
                        // Append new posts to the main feed
                        $('.main-feed').append(response.data.html);
                    }

                    if (response.data.no_more_posts) {
                        // Remove existing no more posts message and hide load more button
                        $('.no-more-posts-msg').remove();
                        $('.load_more_main_feed').hide();
                        // Show no more posts message
                        $('.load_more_main_feed').after('<h5 class="no-more-posts-msg" style="color: var(--gray); text-align: center;">אלה כל בעלי המקצוע לחיפוש זה.</h5>');
                        if (loadMore) {
                            // Scroll to no more posts message
                            $('html, body').animate({
                                scrollTop: $('.no-more-posts-msg').offset().top - $(window).height() + $('.no-more-posts-msg').height() + loadMoreScrollOffset
                            }, 500);
                        }
                    } else {
                        // Show load more button and remove no more posts message
                        $('.load_more_main_feed').show();
                        $('.no-more-posts-msg').remove();
                        if (loadMore) {
                            // Scroll to load more button
                            $('html, body').animate({
                                scrollTop: $('.load_more_main_feed').offset().top - $(window).height() + $('.load_more_main_feed').height() + loadMoreScrollOffset
                            }, 500);
                        }
                    }

                    // Update the loaded post IDs
                    currentFilters.loaded_post_ids = response.data.loaded_post_ids;
                } else {
                    if (reset) {
                        // Show message if no posts found after resetting
                        $('.main-feed').html('<p>לא נמצאו בעלי מקצוע לחיפוש זה.</p>');
                    } else {
                        // Remove existing no more posts message and hide load more button
                        $('.no-more-posts-msg').remove();
                        $('.load_more_main_feed').hide();
                        // Show no more posts message
                        $('.load_more_main_feed').after('<h5 class="no-more-posts-msg" style="color: var(--gray); text-align: center;">אלה כל בעלי המקצוע לחיפוש זה.</h5>');
                        if (loadMore) {
                            // Scroll to no more posts message
                            $('html, body').animate({
                                scrollTop: $('.no-more-posts-msg').offset().top - $(window).height() + $('.no-more-posts-msg').height() + loadMoreScrollOffset
                            }, 500);
                        }
                    }
                }
            },
            error: function(error) {
                console.log('AJAX request error:', error);
            },
            complete: function() {
                // Remove ajax-loading class
                $('.main-feed').removeClass('ajax-loading');
            }
        });
    }

    // Function to check and trigger AJAX based on typeahead input
    function checkAndTriggerAjax() {
        var inputValue = $('.places-typeahead').val().trim();

        if (inputValue === '') {
            // Clear place filter and show all posts
            currentFilters.place = null;
            triggerAjaxRequest(true);
            console.log('Input cleared. Showing all posts.');
            return;
        }

        // Directly use the input value for filtering
        currentFilters.place = inputValue;
        triggerAjaxRequest(true);
    }

    // Initialize typeahead
    $('.places-typeahead').typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'places',
            display: 'name',
            source: placesBloodhound,
            templates: {
                suggestion: function(data) {
                    return '<div>' + data.name + '</div>';
                }
            }
        }
    ).on('typeahead:autocomplete', function(event, selection) {
        console.log('Typeahead autocomplete:', selection);
    }).on('typeahead:selected', function(event, selection) {
        console.log('Typeahead selected:', selection);
    });

    // Event listeners for filters and load more button
    $('.places-typeahead').on('input', function() {
        checkAndTriggerAjax();
    });

    $('.expert_select').on('change', function() {
        // Set expert filter and trigger AJAX
        currentFilters.expert = $(this).val();
        triggerAjaxRequest(true);
    });

    $('.sort_by').on('change', function() {
        // Set sort by filter and trigger AJAX
        currentFilters.sort_by = $(this).val();
        triggerAjaxRequest(true);
    });

    $('.places-typeahead').on('blur', function() {
        var termId = $(this).data('term-id');
        console.log('Input blurred. Term ID:', termId);
    });

    $('.places-input').on('keypress', function(e) {
        if (e.which == 13) {
            triggerAjaxRequest(true);
        }
    });

    $('.load_more_main_feed').on('click', function() {
        triggerAjaxRequest(false, true);
    });
});
