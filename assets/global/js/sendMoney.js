(function ($) {
    "use strict";
    //don't change any global declared variable position, it will result invalid information
    let senderInput = false;
    let recipientInput = false;

    let charge = 0;
    var finalAmount = 0;
    let conversionRate = 0;
    let baseCurrencyAmount = 0;

    let sender = $('[name=sending_country]');
    let receiver = $('[name=recipient_country]');
    let deliveryMethod = $('#deliveryMethod');
    let sendBtn = $('.sendBtn');
    let reverseCountryBtn = $('.reverseCountryBtn');

    if (sendingCountryId) {
        sender.val(sendingCountryId).select2();
    }

    if (recipientCountryId) {
        receiver.val(recipientCountryId).select2();
    } else {
        let senderCountry = sender.find(':selected').val();
        let receiverCountryId = receiver.find(`option[value != ${senderCountry}]`).first().val();
        receiver.val(receiverCountryId).select2();
    }

    var sendingCountry = sender.find(":selected");
    var recipientCountry = receiver.find(":selected");

    setDialCode();
    setDeliveryMethods();
    setConversionRate();
    resetValues();
    setReverseAbility();

    function setDialCode() {
        $('.sender-dial-code').text('+' + sender.find(':selected').data('dial_code'));
        $('.recipient-dial-code').text('+' + receiver.find(':selected').data('dial_code'));
    }

    function setReverseAbility() {
        let sendingCountryId = sender.find(':selected').val();
        let receivingCountryId = receiver.find(':selected').val();
        let sendingCountryOptions = $('[name=sending_country] option').map(function () {
            return $(this).val();
        }).get();
        let receivingCountryOptions = $('[name=recipient_country] option').map(function () {
            return $(this).val();
        }).get();

        if (receivingCountryOptions.includes(sendingCountryId) && sendingCountryOptions.includes(receivingCountryId)) {
            reverseCountryBtn.removeClass('d-none');
        } else {
            reverseCountryBtn.addClass('d-none');
        }
    }

    function setDeliveryMethods() {
        let receiverCountry = receiver.find(':selected');
        let hasAgent = parseInt(receiverCountry.data('has_agent'));
        let countryDeliveryMethods = receiverCountry.data('delivery_methods');
        let options = `<option value="" selected>${defaultSelectOption}</option>`;

        if (agentStatus && hasAgent) {
            options += `<option value="0" data-fixed_charge="${agentFixedCharge}" data-percent_charge="${agentPercentCharge}" ${deliveryMethodId === 0 ? 'selected' : ''}>${agent}</option>`;
        }
        if (countryDeliveryMethods) {

            countryDeliveryMethods.forEach(countryDeliveryMethod => {
                if (countryDeliveryMethod.delivery_method) {
                    let fixedCharge = countryDeliveryMethod.charge ? countryDeliveryMethod.charge.fixed_charge : 0;
                    let percentCharge = countryDeliveryMethod.charge ? countryDeliveryMethod.charge.percent_charge : 0;
                    options += `<option value="${countryDeliveryMethod.delivery_method.id}" data-fixed_charge="${fixedCharge}" data-percent_charge="${percentCharge}" ${deliveryMethodId == countryDeliveryMethod.delivery_method.id ? 'selected' : ''}>${countryDeliveryMethod.delivery_method.name}</option>`;
                }
            });
        }

        deliveryMethod.html(options);
        if (serviceStatus) {
            setServices();
        }
    }

    function setConversionRate() {
        let senderCountry = sender.find(':selected');
        let senderConversionRates = senderCountry.data('conversion_rates');
        let receivingCountryId = receiver.val();

        if (senderConversionRates) {
            let senderConversionRate = senderConversionRates.filter(conversionRate => conversionRate.to_country == receivingCountryId);
            if (senderConversionRate.length) {
                conversionRate = showAmount(senderConversionRate[0].rate);
            } else {
                let senderToBaseCurrencyRate = parseFloat(senderCountry.data('rate'));
                let receiverToBaseCurrencyRate = parseFloat(receiver.find(':selected').data('rate'));

                if (receiverToBaseCurrencyRate > 0) {
                    conversionRate = parseFloat(receiverToBaseCurrencyRate / senderToBaseCurrencyRate).toFixed(3);
                } else {
                    conversionRate = 0;
                }
            }
            $('.exchange-rate').text(conversionRate);
        }
    }

    function setServices() {
        let serviceDiv = $('.services-div');
        let deliveryMethodId = deliveryMethod.val();
        // let deliveryMethodId = $('#deliveryMethod').val();
        let receivingCountryId = receiver.val();

        if (deliveryMethodId != 0 && deliveryMethodId) {
            $.ajax({
                type: "GET",
                url: serviceURL,
                data: {
                    'country_id': receivingCountryId,
                    'delivery_method_id': deliveryMethodId
                },
                success: function (response) {
                    if (response.status) {
                        let services = response.data.services;
                        let options = `<option value="" selected>${defaultSelectOption}</option>`;

                        $.each(services, function (index, element) {
                            options += `<option value="${element.id}">${element.name}</option>`;
                        });

                        if (services.length) {
                            if (isAgent) {
                                $('.countryServices').html(options);
                                $('.service-div').removeClass('d-none');
                            } else {
                                // let html = `                           
                                // <label class="text--accent sm-text d-block fw-md mb-2">${serviceLabel}</label>
                                // <div class="form--select-light">
                                //     <select class="form-select form--select select2-basic countryServices" data-minimum-results-for-search="-1" name="service" required>
                                //         ${options}
                                //     </select>
                                // </div>`;
                                $('.countryServices').html(options);
                                serviceDiv.removeClass('d-none');
                                $('select[name=service]').attr('required', true);
                            }
                            $('.countryServices').trigger('change');
                        }
                    }
                }
            });
        } else {
            if (isAgent) {
                $('countryServices').html(`<option value="" selected disabled>${defaultSelectOption}</option>`);
                $('.service-div').addClass('d-none');
            } else {
                serviceDiv.addClass('d-none');
                $('select[name=service]').attr('required', false);
                // serviceDiv.empty();
            }
            $('.formData').empty();
        }
    }

    deliveryMethod.on('change', function () {
        let deliveryMethodId = $(this).val();
        if (deliveryMethodId) {
            checkDeliveryMethod();
            sendingAmount = $(".sending-amount").val() != '' ? $(".sending-amount").val() : 0;
            recipientAmount = $(".recipient-amount").val() != '' ? $(".recipient-amount").val() : 0;
            senderInput = sendingAmount ? true : false;
            recipientInput = recipientAmount ? true : false;
        }

        resetValues();
        if (serviceStatus) {
            setServices();
        }
    }).change();

    sender.on('change', function () {
        sendingCountry = $(this).find(":selected");
        setAmountVariables();
        setConversionRate();
        setReverseAbility();
        resetValues();
        setDialCode();
    });

    receiver.on('change', function () {
        recipientCountry = $(this).find(":selected");
        setAmountVariables();
        setConversionRate();
        setReverseAbility();
        resetValues();
        setDialCode();
        setDeliveryMethods();
    });

    $(".sending-amount").on('input', function () {
        sendingAmount = $(this).val();
        recipientAmount = 0;
        senderInput = true;
        recipientInput = false;
        resetValues();
        enableDisableSendMoneyBtn();
    });

    $(".recipient-amount").on('input', function () {
        recipientAmount = $(this).val();
        sendingAmount = 0;
        senderInput = false;
        recipientInput = true;
        resetValues();
        enableDisableSendMoneyBtn();
    });

    reverseCountryBtn.on('click', function () {
        let sendingCountryId = sender.val();
        let receivingCountryId = receiver.val();
        sender.val(receivingCountryId).trigger('change');
        receiver.val(sendingCountryId).trigger('change');
        sendBtn.attr('disabled', false);
        sendingAmount = $(".sending-amount").val();
        recipientAmount = 0;
        resetValues();
    });

    function setAmountVariables() {
        sendingAmount = $(".sending-amount").val();
        recipientAmount = $(".recipient-amount").val();

        if (sendingAmount) {
            recipientAmount = 0;
            senderInput = true;
            recipientInput = false;
        } else if (recipientAmount) {
            sendingAmount = 0;
            senderInput = false;
            recipientInput = true;
        }
    }

    function enableDisableSendMoneyBtn() {
        if (!conversionRate) {
            sendBtn.attr('disabled', true);
        } else {
            sendBtn.attr('disabled', false);
        }
    }

    function checkDeliveryMethod() {
        let deliveryMethodId = deliveryMethod.val();

        if (!deliveryMethodId) {
            sendBtn.attr('disabled', true);
            return false;
        } else {
            sendBtn.attr('disabled', false);
            return true;
        }
    }

    function getCharge() {
        let fixedCharge = 0;
        let percentCharge = 0;

        if (deliveryMethod.val()) {
            let selectedDeliveryMethodData = deliveryMethod.find(':selected').data();
            fixedCharge = selectedDeliveryMethodData.fixed_charge * 1;
            percentCharge = selectedDeliveryMethodData.percent_charge * 1;
            $('.chargeInfo').attr('data-bs-original-title', `${fixedCharge} ${recipientCountry.data('currency')} + ${percentCharge}% of total recipient amount. It will be converted to sending currency.`);
        }
        if (sendingAmount) {
            recipientAmount = (conversionRate * sendingAmount).toFixed(2);
        } else if (recipientAmount) {
            if (conversionRate) {
                sendingAmount = (recipientAmount / conversionRate).toFixed(2);
            } else {
                sendingAmount = 0;
            }
        } else {
            sendingAmount = 0;
            recipientAmount = 0;
            return 0
        }

        let totalCharge = (fixedCharge * conversionRate) + ((recipientAmount * percentCharge) / 100);

        if (conversionRate) {
            return (totalCharge / conversionRate).toFixed(2);
        } else {
            return 0;
        }
    }

    function resetValues() {
        charge = getCharge() * 1;
        finalAmount = charge + parseFloat(sendingAmount);
        baseCurrencyAmount = finalAmount / sendingCountry.data('rate');
        updateDom();

        if (!sendingAmount && !recipientAmount) {
            $('.sending-amount').val('');
            $('.recipient-amount').val('');
            sendingAmount = 0;
        }
    }

    function updateDom() {
        $('.error-section').addClass('d-none');

        if (recipientInput) {
            $('.sending-amount').val(sendingAmount ?? '');
        }
        if (senderInput) {
            $('.recipient-amount').val(recipientAmount ?? '');
        }
        $('.sending-amount-total').text(sendingAmount ?? '');
        $('.sending-currency').text(sendingCountry.data('currency'));
        $('.recipient-currency').text(recipientCountry.data('currency'));
        $('.charge-amount-text').text(Number(charge).toFixed(2));
        $('.base-amount-text').text(baseCurrencyAmount.toFixed(2));
        $('.final-amount-text').text(finalAmount.toFixed(2));

        let sendingAmountInBaseCurrency = sendingAmount / sendingCountry.data('rate');
        if (sendingAmountInBaseCurrency > sendLimit) {
            $('.formSubmitButton').attr('disabled', true);
            $('.limitMessage').removeClass('d-none');
        } else {
            $('.formSubmitButton').attr('disabled', false);
            $('.limitMessage').addClass('d-none');
        }
    }

    disableSelectedCountry();

    $('.sending-currency').text(sender.find(":selected").data('currency'));
    $('.recipient-currency').text(receiver.find(":selected").data('currency'));

    function disableSelectedCountry() {
        sender.find(':disabled').removeAttr('disabled')
        receiver.find(':disabled').removeAttr('disabled')
        let selectedSenderID = sender.find(':selected').data('id');
        let selectedReceiverID = receiver.find(':selected').data('id');
        sender.find(`[data-id=${selectedReceiverID}]`).attr('disabled', 'disabled');
        receiver.find(`[data-id=${selectedSenderID}]`).attr('disabled', 'disabled');
    }

    // Change Flags on load
    function formatState(state) {
        if (!state.id) return state.text;
        return $('<img  src="' + $(state.element).data('image') + '"/> <span >' + state.text + '</span>');
    }

    $('.country-picker').select2({
        templateResult: formatState
    });

    $('.country-picker').on('change', function () {
        disableSelectedCountry();
        changeSelectedCountryFlag();
    });

    // Change Flags on load
    changeSelectedCountryFlag();

    function changeSelectedCountryFlag() {
        $('.sending-parent .select2-selection__rendered').html(flagImageHtml(sender.find(':selected')));
        $('.recipient-parent .select2-selection__rendered').html(flagImageHtml(receiver.find(':selected')));
    }

    function flagImageHtml(data) {
        if (data.length) {
            return `<img class="exchange-form__flags" src="${data.data('image')}" alt="image"/> ${data.text()}`
        }
    }
})(jQuery);
