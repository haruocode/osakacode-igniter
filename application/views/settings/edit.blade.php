@extends ('front.template')
@section ('main')
    <div class="container">
        <section class="Setting utility-flex-container">
            @include('settings.includes.sidebar')
            <div class="Setting Box Box--Large Box--bright utility-flex">
                <h2 class="Setting__heading">
                    クレジットカード情報を更新する
                </h2>

            {{form_open('/settings/card/edit',["id" => "billing-form", "onsubmit" => "return false;"])}}

            <!-- Credit Card Number -->
                <div class="form-group">
                    <label for="cc-number">
                        クレジットカード情報
                    </label>

                    <div>
                        <input type="text" id="cc-number" class="form-control input-md cc-number" name="cc_number"
                               data-stripe="number" placeholder="**** **** **** ****" required="">
                    </div>
                </div>

                <!-- Expiration Date -->
                <div class="form-group">
                    <label>
                        カードの有効期限
                    </label>

                    <select class="cc-expiration-month" data-stripe="exp-month" name="exp_month">
                        <?php list_month(); ?>
                    </select>

                    <select class="cc-expiration-year" data-stripe="exp-year" name="exp_year">
                        <?php list_year(); ?>
                    </select>
                </div>


                <!-- CVV Number -->
                <div class="form-group">
                    <label for="cvv">
                        セキュリティ番号
                    </label>

                    <input name="ccv_number" type="text" id="cvv" placeholder="カードの裏側に記載されている3～4桁の番号" class="form-control input-md cvc"
                           data-stripe="cvc" required="">
                </div>


                <!-- Errors -->
                <div class="payment-errors col-md-8" style="display:none">
                </div>

                <div class="payment-errors Alert Alert--Inline Alert--Danger" style="display: none;"></div>


                <footer>
                    <button onclick="submitCard()" class="Button Setting__submit Button Button--Callout">

        <span>

        クレジットカードを更新する

        </span>

                        <div class="la-ball-fall" style="display: none;">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </button>
                </footer>

                {{form_close()}}

            </div>

        </section>

    </div>

    @include('front.includes.popup.update_card')

    <script type="text/javascript">
        Payjp.setPublicKey('');

        var payjpResponseHandler = function (status, response) {
            var $form = $("#billing-form");
            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors.Alert').text(response.error.message).removeAttr('style');
                $form.find('button').attr('disabled', true);
                $("#cc-number,#cvv").keyup(function () {
                    $form.find('button').removeAttr('disabled');
                    $form.find('.payment-errors').attr('style', 'display:none');
                });
                $(".cc-expiration-month,.cc-expiration-year").change(function () {
                    $form.find('button').removeAttr('disabled');
                    $form.find('.payment-errors').attr('style', 'display:none');
                });
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;

                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="token" />').val(token));
                $.ajax({
                    type: 'post',
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    success: function () {
                        $('div.sweet-alert').removeClass('hideSweetAlert');
                        $('div.sweet-alert').addClass('showSweetAlert visible');
                        $('div.sweet-alert').attr('style', 'display: block; margin-top: -198px;');
                        $('div.sweet-overlay').attr('style', 'display: block');
                    }
                });
            }
        };

        function submitCard() {
                $("#billing-form button").attr("disabled",true);
                var data = {
                    number: $('#cc-number').val(),
                    cvc: $('#cvv').val(),
                    exp_month: $('.cc-expiration-month').val(),
                    exp_year: $('.cc-expiration-year').val()
                }
                Payjp.createToken(data, payjpResponseHandler);
        }
    </script>

@stop
