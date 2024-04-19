<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Чек </title>
</head>
<style>
    th:nth-child(1),
    td:nth-child(1) {
        width: 350px;
        text-align: left;
    }

    th:nth-child(2),
    td:nth-child(2) {
        width: 750px;
        text-align: left;
    }


</style>
<body>

<h1>Заказ на двери от {{$current_date}}</h1>
<h6>Уникальный идентификатор заказа #{{$order_id}}</h6>
<hr>
<ul>
    <li>Ф.И.О. клиента <strong>{{$name}}</strong></li>
    <li>Почта клиента <strong>{{$email}}</strong></li>
    <li>Телефон клиента <strong>{{$phone}}</strong></li>
    <li>Дополнительная информация от клиента <strong>{{$info}}</strong></li>

</ul>


@if(!empty($items??[]))
    <hr>
    <h3>Ваш заказ состоит из <strong>{{$total_count}} ед.</strong>:</h3>
    <p>Итого <strong>{{$total_price}} руб.</strong> за <strong>{{$total_count}} ед.</strong></p>
    @foreach($items as $index=>$item)
        <table>
            <thead>
            <tr>
                <th scope="col">Параметр</th>
                <th scope="col">Значение</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <th scope="row">Номер изделия</th>
                <td>{{$index+1}}</td>
            </tr>
            <tr>
                <td><strong>Ширина</strong></td>
                <td>{{$item->product->width ?? 0}} мм</td>
            </tr>

            <tr>
                <td><strong>Высота</strong></td>
                <td>{{$item->product->height ?? 0}}</td>
            </tr>

            <tr>
                <td><strong>Глубина</strong></td>
                <td>{{$item->product->depth ?? 0}}</td>

            </tr>

            <tr>
                <td><strong>Для каких целей</strong></td>
                <td>{{$item->product->purpose ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Комментарий</strong></td>
                <td>{{$item->product->comment ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Отверстие под ручку </strong></td>
                <td>{{$item->product->handle_holes->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Тип отверстия под ручку </strong></td>
                <td>{{$item->product->handle_holes_type->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Тип открывания двери </strong></td>
                <td>{{$item->product->opening_type->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Цвет короба</strong></td>
                <td>{{$item->product->box_and_frame_color->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Тип двери</strong></td>
                <td>{{$item->product->door_type->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Отделка первой стороны</strong></td>
                <td>{{$item->product->front_side_finish->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Цвет отделки первой стороны</strong></td>
                <td>{{$item->product->front_side_finish_color->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Отделка второй стороны</strong></td>
                <td>{{$item->product->back_side_finish->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Цвет отделки второй стороны</strong></td>
                <td>{{$item->product->back_side_finish_color->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Цвет уплотнения</strong></td>
                <td>{{$item->product->seal_color->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Цвет фурнитуры</strong></td>
                <td>{{$item->product->fittings_color->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Дополнительно</strong></td>
                <td>
                    <span>Дверная ручка: {{($item->product->need_handle_holes ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Верхняя перемычка: {{($item->product->need_upper_jumper ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Автоматический порог: {{($item->product->need_automatic_doorstep ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Скрытый стопор: {{($item->product->need_hidden_stopper ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Скрытый доводчик: {{($item->product->need_hidden_door_closer ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Плинтус: {{($item->product->need_hidden_skirting_board ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Установка двери: {{($item->product->need_door_install ?? false) == "true" ? "Да":"Нет"}}</span><br>
                </td>
            </tr>

            <tr>
                <td><strong>Расположение петель</strong></td>
                <td>{{$item->product->loops->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Число петель</strong></td>
                <td>{{$item->product->loops_count ?? 0}}</td>
            </tr>

            <tr>

                <td><strong>Производитель петель</strong></td>
                <td>{{$item->product->hinge_manufacturer->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Тип цены</strong></td>
                <td>{{$item->product->price_type->title ?? 'не указано'}}</td>
            </tr>

            <tr>
                <td><strong>Цена, руб</strong></td>
                <td>{{$item->product->price ?? 0}}</td>
            </tr>

            <tr>
                <td><strong>Кол-во</strong></td>
                <td>{{$item->quantity ?? 0}}</td>
            </tr>

            <tr>

                <td><strong>Итог цена, руб</strong></td>
                <td>{{($item->product->price ?? 0)*($item->quantity ?? 0)}}</td>
            </tr>
            </tbody>


        </table>
        <hr>
    @endforeach

@endif

</body>
</html>
