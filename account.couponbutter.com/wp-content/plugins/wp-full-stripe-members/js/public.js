Stripe.setPublishableKey(stripekey);

jQuery(document).ready(function ($)
{
    var $tips = $('.tips');
    var $loading = $(".showLoading");
    var $del_tips = $('.delete_tips');
    var $del_loading = $(".delete_showLoading");
    var $up_tips = $('.update_tips');
    var $up_loading = $(".update_showLoading");

    $loading.hide();
    $del_loading.hide();
    $up_loading.hide();

    $('#wpfs_members_level').change(function () {
        var plan = $(this).val();
        var option = $("#wpfs_members_level").find("option[value='" + plan + "']");
        var currency = option.attr("data-currency");
        var amount = parseFloat(option.attr('data-amount') / 100);
        var interval = option.attr('data-interval');
        var interval_count = parseInt(option.attr("data-interval-count"));
        var details = null;
        if (interval_count > 1) {
            details = sprintf(wpfsm_L10n.plan_details_with_plural_interval, currency, amount, interval_count, interval);
        } else {
            details = sprintf(wpfsm_L10n.plan_details_with_singular_interval, currency, amount, interval);
        }
        $(".wpfs_members_level_details").text(details);
    }).change();


    $('#wpfs_members_change_level').submit(function()
    {
        $tips.removeClass('alert alert-error');
        $tips.html("");

        $loading.show();
        var $form = $(this);

        // Disable the submit button
        $form.find('button').prop('disabled', true);
        // Attach the selected role to save getting it again later
        var plan = $('#wpfs_members_level').val();
        var option = $("#wpfs_members_level").find("option[value='" + plan + "']");
        var role = option.attr("data-role");
        $form.append("<input type='hidden' name='role' value='" + role + "' />");

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $form.serialize(),
            cache: false,
            dataType: "json",
            success: function (data)
            {
                $loading.hide();

                if (data.success)
                {
                    $tips.addClass('alert alert-success');
                    $tips.html(wpfsm_L10n.changeLevelSuccessMessage);
                    $form.find('button').prop('disabled', false);

                    setTimeout(function ()
                    {
                        document.location.reload(true);
                    }, 1000);
                }
                else
                {
                    // re-enable the submit button
                    $form.find('button').prop('disabled', false);
                    // show the errors on the form
                    $tips.addClass('alert alert-error');
                    $tips.html(data.msg);
                    $tips.fadeIn(500).fadeOut(500).fadeIn(500);
                }
            }
        });

        return false;
    });

    $('#wpfs_members_cancel_membership').click(function(e)
    {
        e.preventDefault();
        $('#wpfs_members_cancel_question').toggle();
        return false;
    });

    $('#wpfs_members_cancel').submit(function(e)
    {
        $del_tips.removeClass('alert alert-error');
        $del_tips.html("");

        $del_loading.show();
        var $form = $(this);

        // Disable the submit button
        $form.find('button').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $form.serialize(),
            cache: false,
            dataType: "json",
            success: function (data)
            {
                $del_loading.hide();

                if (data.success)
                {
                    $del_tips.addClass('alert alert-success');
                    $del_tips.html(wpfsm_L10n.cancelMembershipSuccessMessage);
                    $form.find('button').prop('disabled', false);

                    setTimeout(function ()
                    {
                        document.location.reload(true);
                    }, 1000);
                }
                else
                {
                    // re-enable the submit button
                    $form.find('button').prop('disabled', false);
                    // show the errors on the form
                    $del_tips.addClass('alert alert-error');
                    $del_tips.html(data.msg);
                    $del_tips.fadeIn(500).fadeOut(500).fadeIn(500);
                }
            }
        });

        return false;
    });

    $('#wpfs_members_cancel_membership_no').click(function(e)
    {
        e.preventDefault();
        $('#wpfs_members_cancel_question').hide();
        return false;
    });


    $('#wpfs_members_update_card_button').click(function(e)
    {
        e.preventDefault();
        $('#wpfs_members_update_card_section').toggle();
        return false;
    });

    // update card form
    $('#wpfs_members_update_card').submit(function (e)
    {
        $up_loading.show();

        $up_tips.removeClass('alert alert-error');
        $up_tips.html("");

        var $form = $(this);

        // Disable the submit button
        $form.find('button').prop('disabled', true);

        Stripe.createToken($form, stripeResponseHandler);
        return false;
    });

    var stripeResponseHandler = function (status, response)
    {
        var $form = $('#wpfs_members_update_card');

        if (response.error)
        {
            // Show the errors
            $up_tips.addClass('alert alert-error');
            if (response.error.code && wpfsm_L10n.hasOwnProperty(response.error.code)) {
                $up_tips.html(wpfsm_L10n[response.error.code]);
            } else {
                $up_tips.html(response.error.message);
            }
            $up_tips.fadeIn(500).fadeOut(500).fadeIn(500);
            $form.find('button').prop('disabled', false);
            $up_loading.hide();
        }
        else
        {
            // token contains id, last4, and card type
            var token = response.id;
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "' />");

            //post payment via ajax
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $form.serialize(),
                cache: false,
                dataType: "json",
                success: function (data)
                {
                    $up_loading.hide();

                    if (data.success)
                    {
                        //clear form fields
                        $form.find('input:text, input:password').val('');
                        $('#wpfs_members_update_card_section').hide();
                        //inform user of success
                        $up_tips.addClass('alert alert-success');
                        $up_tips.html(wpfsm_L10n.updateCardSuccessMessage);
                        $form.find('button').prop('disabled', false);
                        setTimeout(function ()
                        {
                            document.location.reload(true);
                        }, 1000);
                    }
                    else
                    {
                        // re-enable the submit button
                        $form.find('button').prop('disabled', false);
                        // show the errors on the form
                        $up_tips.addClass('alert alert-error');
                        $up_tips.html(data.msg);
                        $up_tips.fadeIn(500).fadeOut(500).fadeIn(500);
                    }
                }
            });
        }
    };

});