<form action="" method="post">
    <div class="card shadow border-left-primary">
        <div class="card-body">
            <h5><i class="icon fa fa-info-circle"></i> Платежная система <a href="https://anypay.io/panel/register" target="_blank">ANYPAY</a></h5></br>
            - <b>Банковские карты</b>: <b>Карты РФ</b>, <b>Карты Украины</b> и <b>Карты Казахстана</b></br>
            - <b>Электронные платежи</b>: <b>Сбербанк</b> и <b>СБП</b></br>
            - <b>Электронные кошельки</b>: <b>ЮMoney</b>, <b>Webmoney</b>, <b>Advcash</b> и <b>Perfect Money</b></br>
            - <b>Сотовые операторы</b>: <b>Мегафон</b>, <b>Билайн</b> и <b>Теле2</b></br>
            - <b>Криптовалюты</b>: <b>Bitcoin</b>, <b>Bitcoin Cash</b>, <b>Ethereum</b>, <b>Litecoin</b>, <b>Dash</b>, <b>Zcash</b>, <b>Dogecoin</b>, <b>Tether</b> и <b>Toncoin</b></br></br>
            - Для регистрации в <b>ANYPAY</b> используйте <a href="https://anypay.io/panel/register" target="_blank">эту ссылку</a>.</br>
            - Модуль прошел тесты и работает на версиях магазина 1.7.1 и выше.</br>
            - <b>URL Оповещения:</b> https://<Ваш домен>/store/listener/?gateway=ANYPAY</br>
            - <b>URL успешной оплаты:</b> https://<Ваш домен>/store/checkout/?do=complete</br>
            - <b>URL неудачной оплаты:</b> На ваш выбор :)
        </div>
    </div>

    <br />


<form action="" method="post"><div class="form-group"><label for="inputANYPAYId">ID магазина</label>
<input class="form-control" type="text" id="inputANYPAYShopId" name="shopid_key" value="{$SHOP_ID_VALUE}" placeholder="ID магазина">
</div>

<div class="form-group"><label for="inputANYPAYApiKey">Секретный ключ 1</label>
<input class="form-control" type="text" id="inputANYPAYApiKey" name="secret1_key" value="{$SHOP_API_KEY_VALUE}" placeholder="Секретный ключ">
</div>

<div class="form-group custom-control custom-switch">
<input id="inputEnabled" name="enable" type="checkbox" class="custom-control-input"{if $ENABLE_VALUE eq 1} checked{/if} />
<label class="custom-control-label" for="inputEnabled">Включить способ оплаты</label>
</div>

<div class="form-group"><input type="hidden" name="token" value="{$TOKEN}"><input type="submit" value="{$SUBMIT}" class="btn btn-primary">
</div>
</form>