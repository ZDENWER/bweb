<?
//подключаем пролог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//устанавливаем заголовок страницы
$APPLICATION->SetTitle("AJAX");

CJSCore::Init(array('ajax'));
// Подключаем метод ajax
$sidAjax = 'testAjax';
//создаем переменную-идетификатор
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
    //если глобальная переменная $_REQUEST содержит данные из формы 'ajax_form' и эти данные совпадают с 'testAjax'
    $GLOBALS['APPLICATION']->RestartBuffer();
    //перезапускаем буфер чтобы элементы страницы не прогрузились дважды и не получился эффект "окна в окне"
    echo CUtil::PhpToJSObject(array(
        //преобразуем php-ответ в js объект
        'RESULT' => 'HELLO',
        'ERROR' => ''
    ));
    die();
    //тут 'умирает' данная условная конструкция
}

?>
<!--Начало html-разметки-->
    <div class="group">
        <div id="block"></div >
        <div id="process">wait ... </div >
    </div>
<!--Конец html-разметки-->
    <script>
        window.BXDEBUG = true;
        //включапем debug, т.е. если есть какие-то ошибки- их нужно выводить
        function DEMOLoad(){
            //запускаем функцию DEMOLoad,
            BX.hide(BX("block"));
            //которая скрывает div с id='block'
            BX.show(BX("process"));
            //выводит на экран div с id='process'
            BX.ajax.loadJSON(
                //и запускает метод библиотеки ajax битрикса, который загрузит JSON (формат обмена данными),
                '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
                // отправили запрос на текущую страницу и передали с помощью GET в ajax_form идентификатор $sidAjax
                DEMOResponse
                //и запускаем функцию DEMOResponse
            );
        }
        function DEMOResponse (data){
            BX.debug('AJAX-DEMOResponse ', data);
            //Включаем вывод ошибок
            BX("block").innerHTML = data.RESULT;
            //если ошибок нет, то в <div id="block"> подставляем данные запроса data.RESULT (то, что в 17 строке)
            BX.show(BX("block"));
            //выводим <div id="block"> (делаем его видемым)
            BX.hide(BX("process"));
            //прячем <div id="process">

            BX.onCustomEvent(  //Какое-то кастомное событие, реагирующее на DEMOUpdate
                BX(BX("block")),
                'DEMOUpdate'
            );
        }

        BX.ready(function(){   //функция, проверяющая готовность страницы (по готовности стрницы производятся действия ниже)
            /*
            BX.addCustomEvent(BX("block"), 'DEMOUpdate', function(){
               window.location.href = window.location.href;
            });
            */
            BX.hide(BX("block")); //Скрывается блок с id = block
            BX.hide(BX("process")); //Скрывается блок с id = process

            BX.bindDelegate( //добавляем событие
                document.body, 'click', {className: 'css_ajax' }, //которое активируется по клику на элемент с классом css_ajax
                function(e){ //в результате которого запускается функция
                    if(!e)
                        e = window.event;

                    DEMOLoad();
                    return BX.PreventDefault(e); // которая возврещает window.event и запускает DEMOLoad
                }
            );

        });

    </script>
    <div class="css_ajax">click Me</div>
<?
//подключаем эпилог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>