<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$sheet_title ?? 'Вкладка 2'}}</title>
</head>
<body>

<table border="1">
    <thead>
    <tr>
        <td>№</td>
        <td>Тип двери</td>
        <td>Номер заказа</td>
        <td>Кол-во</td>
        <td>Договор</td>
        <td>Номер двери</td>
        <td>Дата сдачи</td>
        <td>Цена за единицу</td>
        <td>Верхняя перемычка</td>
        <td>Профиль</td>
        <td>Расстояние без верхн.перемычки от верха до конца посл петли</td>
        <td>Высота</td>
        <td>Ширина</td>
        <td>Кол-во петель</td>
        <td>Цвет профиля</td>
        <td>Отделка лицо</td>
        <td>Ral</td>
        <td>Отделка зад</td>
        <td>Ral</td>
        <td>Производитель петель</td>
        <td>Отверстий под ручку</td>
        <td>Автоматический порог</td>
        <td>Скрытый стопор</td>
        <td>Скрытый доводчик</td>
        <td>Защелка открывание</td>
        <td>Петли</td>
        <td>Упаковка</td>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $index=>$item)
        @php
        $door = (object)$item->door;
        @endphp
        <tr>
            <td>{{$item->id ?? '-'}}</td>
            <td>{{$door->door_type["title"]?? '-'}}</td>
            <td>{{$item->order_id}}</td>
            <td>{{$item->count ?? 0}}</td>
            <td>{{$item->order->contract_number ?? '-'}}</td>
            <td>{{$item->purpose ?? '-'}}</td>
            <td>{{$item->order->completion_at ?? '-'}}</td>
            <td>{{$item->price ?? 0}} </td>
            <td>{{($door->need_upper_jumper??false)?"Да":"Нет"}} </td>
            <td>-</td>
            <td>-</td>
            <td>{{$door->height ?? 0}}</td>
            <td>{{$door->width ?? 0}}</td>
            <td>{{$door->loops_count ?? 0}}</td>
            <td>{{$door->box_and_frame_color["code"] ?? '-'}}</td>
            <td>{{$door->front_side_finish["title"] ?? '-'}}</td>
            <td>{{$door->front_side_finish_color["code"]?? '-'}}</td>
            <td>{{$door->back_side_finish["title"] ?? '-'}}</td>
            <td>{{$door->back_side_finish_color["code"] ?? '-'}}</td>
            <td>{{$door->hinge_manufacturer["title"] ?? '-'}}</td>
            <td>{{$door->handle_holes["title"] ?? '-'}}</td>
            <td>{{($door->need_automatic_doorstep ?? false)?"Да":"Нет"}}</td>
            <td>{{($door->need_hidden_stopper  ?? false)?"Да":"Нет"}}</td>
            <td>{{($door->need_hidden_door_closer  ?? false)?"Да":"Нет"}}</td>
            <td>-</td>
            <td>{{$door->loops["title"] ?? '-'}}</td>
            <td>{{($door->need_wrapper  ?? false)?"Да":"Нет"}}</td>
        </tr>

    @endforeach
    </tbody>
</table>
</body>
</html>
