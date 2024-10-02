(function ($) {

    $(function () {

        var $document = $(document),
            $deactivationPopUp = $('.pb-deactivation-popup');

        if ($deactivationPopUp.length < 1)
            return;
        console.log('lkjlkjlkj')
        $(document).on('click', 'tr[data-slug="premium-blocks-for-gutenberg"] .deactivate a', function (event) {
            event.preventDefault();

            $deactivationPopUp.removeClass('hidden');
            console.log('yes')
        });

        $document.on('click', '.pb-deactivation-popup .close, .pb-deactivation-popup .dashicons,  .pb-deactivation-popup', function (event) {

            if (this === event.target) {
                $deactivationPopUp.addClass('hidden');
            }

        });

        $document.on('change', '.pb-deactivation-popup input[name][type="radio"]', function () {
            var $this = $(this);

            var value = $this.val(),
                name = $this.attr('name');

            value = typeof value === 'string' && value !== '' ? value : undefined;
            name = typeof name === 'string' && name !== '' ? name : undefined;

            if (value === undefined || name === undefined) {
                return;
            }

            var $targetedMessage = $('p[data-' + name + '="' + value + '"]'),
                $relatedSections = $this.parents('.body').find('section[data-' + name + ']'),
                $relatedMessages = $this.parents('.body').find('p[data-' + name + ']:not(p[data-' + name + '="' + value + '"])');

            $relatedMessages.addClass('hidden');
            $targetedMessage.removeClass('hidden');
            $relatedSections.removeClass('hidden');

        });

        $document.on('keyup', '.pb-deactivation-popup input[name], .pb-deactivation-popup textarea[name]', function (event) {

            var allowed = ['Enter', 'Escape'];

            if (!allowed.includes(event.key)) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            if (event.key === allowed[0]) {
                $('.pb-deactivation-popup [data-action="deactivation"]').click();
            } else if (event.key === allowed[1]) {
                $('.pb-deactivation-popup .close').click();
            }
        });

        $document.on('click', '.pb-deactivation-popup button[data-action]', function (event) {

            var $this = $(this),
                $optionsWrappers = $this.parents('.body').find('.options-wrap'),
                $toggle = $optionsWrappers.find('input[name][type="checkbox"]:checked, input[name][type="radio"]:checked'),
                $fields = $optionsWrappers.find('input[name], textarea[name]').not('input[type="checkbox"], input[type="radio"]');

            var data = {
                action: $this.data('action')
            };

            data.action = typeof data.action === 'string' && data.action !== '' ? data.action : undefined;

            if ($toggle.length > 0) {
                $toggle.each(function () {
                    var $this = $(this),
                        value = $this.val(),
                        key = $this.attr('name');

                    if (typeof value === 'string' && value !== '' && typeof key === 'string' && key !== '') {
                        data[key] = value;
                    }
                });
            }

            if ($fields.length > 0) {
                $fields.each(function () {
                    var $this = $(this),
                        value = $this.val(),
                        key = $this.attr('name');

                    if (typeof value === 'string' && value !== '' && typeof key === 'string' && key !== '') {
                        data[key] = value;
                    }
                })
            }

            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'pb_handle_feedback_action',
                    data: data
                },
                beforeSend: function () {
                    $this.prop('disabled', true);
                },
                error: function (error) {
                    console.log(error);
                },
                complete: function (res) {

                    $deactivationPopUp.addClass('hidden');
                    $this.prop('disabled', false);

                    console.log(res);

                    var $deactivateLink = $('tr[data-slug="premium-blocks-for-gutenberg"] .deactivate a');

                    if ($deactivateLink.length > 0) {
                        var deactivateUrl = $deactivateLink.attr('href');

                        if (typeof deactivateUrl === 'string' && deactivateUrl !== '') {
                            window.location.href = deactivateUrl;
                        } else {
                            window.location.reload();
                        }
                    }
                }
            });
        });

    });


})(jQuery);
