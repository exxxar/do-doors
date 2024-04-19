<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Чек </title>
</head>

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
    <h3>Ваш заказ состоит из следующих позиций:</h3>
    <table>

        <tr>
            <td><strong>#</strong></td>
            <td style="width: 50px;"><strong>Ширина</strong></td>
            <td style="width: 50px;"><strong>Высота</strong></td>
            <td style="width: 50px;"><strong>Глубина</strong></td>
            <td><strong>Для каких целей</strong></td>
            <td><strong>Комментарий</strong></td>
            <td><strong>Отверстие под ручку </strong></td>
            <td><strong>Тип отверстия под ручку </strong></td>
            <td><strong>Тип открывания двери </strong></td>
            <td><strong>Цвет короба</strong></td>
            <td><strong>Тип двери</strong></td>
            <td><strong>Отделка первой стороны</strong></td>
            <td><strong>Цвет отделки первой стороны</strong></td>
            <td><strong>Отделка второй стороны</strong></td>
            <td><strong>Цвет отделки второй стороны</strong></td>
            <td><strong>Цвет уплотнения</strong></td>
            <td><strong>Цвет фурнитуры</strong></td>
            <td style="width: 150px;"><strong>Дополнительно</strong></td>
            <td><strong>Расположение петель</strong></td>
            <td style="width: 50px;"><strong>Число петель</strong></td>
            <td><strong>Производитель петель</strong></td>
            <td><strong>Тип цены</strong></td>
            <td style="width: 50px;"><strong>Цена, руб</strong></td>
            <td style="width: 50px;"><strong>Кол-во</strong></td>
            <td style="width: 50px;"><strong>Итог цена, руб</strong></td>

        </tr>

        @foreach($items as $index=>$item)
            <tr>
                <td style="width: 50px;">{{$index+1}}</td>
                <td style="width: 50px;">{{$item->product->width ?? 0}}</td>
                <td style="width: 50px;">{{$item->product->height ?? 0}}</td>
                <td style="width: 50px;">{{$item->product->depth ?? 0}}</td>
                <td>{{$item->product->purpose ?? 'не указано'}}</td>
                <td>{{$item->product->comment ?? 'не указано'}}</td>
                <td>{{$item->product->handle_holes->title ?? 'не указано'}}</td>
                <td>{{$item->product->handle_holes_type->title ?? 'не указано'}}</td>
                <td>{{$item->product->opening_type->title ?? 'не указано'}}</td>
                <td>{{$item->product->box_and_frame_color->title ?? 'не указано'}}</td>
                <td>{{$item->product->door_type->title ?? 'не указано'}}</td>
                <td>{{$item->product->front_side_finish->title ?? 'не указано'}}</td>
                <td>{{$item->product->front_side_finish_color->title ?? 'не указано'}}</td>
                <td>{{$item->product->back_side_finish->title ?? 'не указано'}}</td>
                <td>{{$item->product->back_side_finish_color->title ?? 'не указано'}}</td>
                <td>{{$item->product->seal_color->title ?? 'не указано'}}</td>
                <td>{{$item->product->fittings_color->title ?? 'не указано'}}</td>
                <td style="width: 150px;">
                    <span>Дверная ручка: {{($item->product->need_handle_holes ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Верхняя перемычка: {{($item->product->need_upper_jumper ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Автоматический порог: {{($item->product->need_automatic_doorstep ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Скрытый стопор: {{($item->product->need_hidden_stopper ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Скрытый доводчик: {{($item->product->need_hidden_door_closer ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Плинтус: {{($item->product->need_hidden_skirting_board ?? false) == "true" ? "Да":"Нет"}}</span><br>
                    <span>Установка двери: {{($item->product->need_door_install ?? false) == "true" ? "Да":"Нет"}}</span><br>
                </td>


                <td>{{$item->product->loops->title ?? 'не указано'}}</td>
                <td style="width: 50px;">{{$item->product->loops_count ?? 0}}</td>
                <td>{{$item->product->hinge_manufacturer->title ?? 'не указано'}}</td>
                <td>{{$item->product->price_type->title ?? 'не указано'}}</td>
                <td style="width: 50px;">{{$item->product->price ?? 0}}</td>
                <td style="width: 50px;">{{$item->quantity ?? 0}}</td>
                <td style="width: 50px;">{{($item->product->price ?? 0)*($item->quantity ?? 0)}}</td>
            </tr>
        @endforeach

    </table>

    <p>Число изделий <strong>{{$total_count}} ед.</strong></p>
    <p>Итого <strong>{{$total_price}} руб.</strong></p>
@endif

</body>
</html>
