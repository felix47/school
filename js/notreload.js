jQuery(function(){
    jQuery("#form").submit(function() { //устанавливаем событие отправки для формы с id=form
        var form_data = jQuery(this).serialize(); //собераем все данные из формы
        jQuery.ajax({
            type: "POST", //Метод отправки
            url: "/libs/send.php", //путь до php фаила отправителя
            data: form_data,
            success: function() {
                //код в этом блоке выполняется при успешной отправке сообщения
                jQuery('.lt-xbutton').removeClass('lt-xbutton-active');
                alert('Резерв отправлен!');
                // location.replace("http://shtaken.ru");
                return false;
            }
        });
        return false;
    });
});
