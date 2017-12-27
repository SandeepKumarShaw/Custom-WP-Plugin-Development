/*
 Plugin Name: WP Full Stripe
 Plugin URI: http://mammothology.com/products/view/wp-full-stripe
 Description: Complete Stripe payments integration for Wordpress
 Author: Mammothology
 Version: 3.3
 Author URI: http://mammothology.com
 */

Stripe.setPublishableKey(stripekey);

function logError(handlerName, jqXHR, textStatus, errorThrown) {
    if (window.console) {
        console.log(handlerName + '.error(): textStatus=' + textStatus);
        console.log(handlerName + '.error(): errorThrown=' + errorThrown);
        if (jqXHR) {
            console.log(handlerName + '.error(): jqXHR.status=' + jqXHR.status);
            console.log(handlerName + '.error(): jqXHR.responseText=' + jqXHR.responseText);
        }
    }
}

function logException(source, response) {
    if (window.console && response) {
        if (response.ex_msg) {
            console.log('ERROR: source=' + source + ', message=' + response.ex_msg);
        }
    }
}

jQuery(document).ready(function ($) {

    function scrollToError($err) {
        if ($err && $err.offset() && $err.offset().top) {
            if (!isInViewport($err)) {
                $('html, body').animate({
                    scrollTop: $err.offset().top - 100
                }, 1000);
            }
        }
        if ($err) {
            $err.fadeIn(500).fadeOut(500).fadeIn(500);
        }
    }

    function isInViewport($elem) {
        var $window = $(window);

        var docViewTop = $window.scrollTop();
        var docViewBottom = docViewTop + $window.height();

        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

    $("#showLoading").hide();
    $("#showLoadingC").hide();
    var $err = $(".payment-errors");

    $('#fullstripe_custom_amount').change(function () {
        var showAmount = $(this).data('show-amount');
        var buttonTitle = $(this).data('button-title');
        var currencySymbol = $(this).data('currency-symbol');
        var amount = parseFloat($(this).val());
        var buttonTitleParams = [];
        buttonTitleParams.push(buttonTitle);
        buttonTitleParams.push(currencySymbol);
        buttonTitleParams.push(amount);
        if (showAmount == '1') {
            $('#payment-form-submit').html(vsprintf("%s %s %0.2f", buttonTitleParams));
        }
    });

    $('#payment-form').submit(function (e) {
        $("#showLoading").show();

        $err.removeClass('alert alert-error');
        $err.html("");

        var $form = $(this);

        // Disable the submit button
        $form.find('button').prop('disabled', true);

        Stripe.createToken($form, stripeResponseHandler);
        return false;
    });

    var stripeResponseHandler = function (status, response) {
        var $form = $('#payment-form');

        if (response.error) {
            // Show the errors
            $err.addClass('alert alert-error');
            if (response.error.code && wpfs_L10n.hasOwnProperty(response.error.code)) {
                $err.html(wpfs_L10n[response.error.code]);
            } else {
                $err.html(response.error.message);
            }
            scrollToError($err);
            $form.find('button').prop('disabled', false);
            $("#showLoading").hide();
        } else {
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
                success: function (data) {
                    if (data.success) {
                        //clear form fields
                        $form.find('input:text, input:password').val('');
                        $('#fullstripe_custom_amount').prop('selectedIndex', 0);
                        $('#fullstripe_plan').prop('selectedIndex', 0);
                        //inform user of success
                        $err.addClass('alert alert-success');
                        $err.html(data.msg);
                        $form.find('button').prop('disabled', false);
                        scrollToError($err);
                        if (data.redirect) {
                            setTimeout(function () {
                                window.location = data.redirectURL;
                            }, 1500);
                        }
                    } else {
                        // show the errors on the form
                        $err.addClass('alert alert-error');
                        $err.html(data.msg);
                        scrollToError($err);
                    }
                    logException('stripeResponseHandler', data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $err.addClass('alert alert-error');
                    $err.html(wpfs_L10n.internal_error);
                    scrollToError($err);
                },
                complete: function () {
                    $form.find('button').prop('disabled', false);
                    $("#showLoading").hide();
                }
            });
        }
    };

    $('#payment-form-style').submit(function (e) {
        $("#showLoading").show();
        var $err = $(".payment-errors");
        $err.removeClass('alert alert-error');
        $err.html("");

        var $form = $(this);

        // Disable the submit button
        $form.find('button').prop('disabled', true);

        Stripe.createToken($form, stripeResponseHandler2);
        return false;
    });

    var stripeResponseHandler2 = function (status, response) {
        var $form = $('#payment-form-style');

        if (response.error) {
            // Show the errors
            $err.addClass('alert alert-error');
            if (response.error.code && wpfs_L10n.hasOwnProperty(response.error.code)) {
                $err.html(wpfs_L10n[response.error.code]);
            } else {
                $err.html(response.error.message);
            }
            scrollToError($err);
            $form.find('button').prop('disabled', false);
            $("#showLoading").hide();
        } else {
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
                success: function (data) {
                    if (data.success) {
                        //clear form fields
                        $form.find('input:text, input:password').val('');
                        $('#fullstripe_custom_amount').prop('selectedIndex', 0);
                        $('#fullstripe_plan').prop('selectedIndex', 0);
                        //inform user of success
                        $err.addClass('alert alert-success');
                        $err.html(data.msg);
                        $form.find('button').prop('disabled', false);
                        scrollToError($err);
                        if (data.redirect) {
                            setTimeout(function () {
                                window.location = data.redirectURL;
                            }, 1500);
                        }
                    } else {
                        // show the errors on the form
                        $err.addClass('alert alert-error');
                        $err.html(data.msg);
                        scrollToError($err);
                        logException('stripeResponseHandler2', data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $err.addClass('alert alert-error');
                    $err.html(wpfs_L10n.internal_error);
                    scrollToError($err);
                },
                complete: function () {
                    $form.find('button').prop('disabled', false);
                    $("#showLoading").hide();
                }
            });
        }
    };

    var coupon = false;
    $('#fullstripe_plan').change(function () {
        var plan = $("#fullstripe_plan").val();
        var planSelector = "option[value='" + plan + "']";
        var setupFee = parseInt($("#fullstripe_setupFee").val());
        var option = $("#fullstripe_plan").find($('<div/>').html(planSelector).text());
        var interval = option.attr('data-interval');
        var intervalCount = parseInt(option.attr("data-interval-count"));
        var amount = parseFloat(option.attr('data-amount') / 100);
        var currencySymbol = option.attr("data-currency");

        var planDetailsPattern = wpfs_L10n.plan_details_with_singular_interval;
        var planDetailsParams = [];
        planDetailsParams.push(currencySymbol);
        planDetailsParams.push(amount);

        if (intervalCount > 1) {
            planDetailsPattern = wpfs_L10n.plan_details_with_plural_interval;
            planDetailsParams.push(intervalCount);
            planDetailsParams.push(interval);
        } else {
            planDetailsParams.push(interval);
        }

        if (coupon != false) {
            planDetailsPattern = intervalCount > 1 ? wpfs_L10n.plan_details_with_plural_interval_with_coupon : wpfs_L10n.plan_details_with_singular_interval_with_coupon;
            var total;
            if (coupon.percent_off != null) {
                total = amount * (1 - ( parseInt(coupon.percent_off) / 100 ));
            } else {
                total = amount - parseFloat(coupon.amount_off) / 100;
            }
            total = total.toFixed(2);
            planDetailsParams.push(total);
            $(this).parents('form:first').append($('<input type="hidden" name="amount_with_coupon_applied">').val(total * 100));
        }

        if (setupFee > 0) {
            planDetailsPattern = intervalCount > 1 ? (coupon != false ? wpfs_L10n.plan_details_with_plural_interval_with_coupon_with_setupfee : wpfs_L10n.plan_details_with_plural_interval_with_setupfee) : (coupon != false ? wpfs_L10n.plan_details_with_singular_interval_with_coupon_with_setupfee : wpfs_L10n.plan_details_with_singular_interval_with_setupfee);
            var sf = (setupFee / 100).toFixed(2);
            planDetailsParams.push(currencySymbol);
            planDetailsParams.push(sf);
        }

        var planDetailsMessage = vsprintf(planDetailsPattern, planDetailsParams);
        $(".fullstripe_plan_details").text(planDetailsMessage);

    }).change();

    $('#fullstripe_check_coupon_code').click(function (e) {
        e.preventDefault();
        var cc = $('#fullstripe_coupon_input').val();
        if (cc.length > 0) {
            $(this).prop('disabled', true);
            $err.removeClass('alert alert-success');
            $err.removeClass('alert alert-error');
            $err.html("");
            $("#showLoadingC").show();

            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action: 'wp_full_stripe_check_coupon', code: cc},
                cache: false,
                dataType: "json",
                success: function (data) {
                    if (data.valid) {
                        coupon = data.coupon;
                        $('#fullstripe_plan').change();
                        $err.addClass('alert alert-success');
                        $err.html(data.msg);
                        scrollToError($err);
                    } else {
                        $err.addClass('alert alert-error');
                        $err.html(data.msg);
                        scrollToError($err);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $err.addClass('alert alert-error');
                    $err.html(wpfs_L10n.internal_error);
                    scrollToError($err);
                },
                complete: function () {
                    $("#fullstripe_check_coupon_code").prop('disabled', false);
                    $("#showLoadingC").hide();
                }
            });
        }
        return false;
    });

});