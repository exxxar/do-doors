<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$sheet_title ?? 'Экспорт'}} </title>
</head>

<body>
<h3 style="text-align: center; font-weight: bold;">Спецификация к договору DoDoors</h3>

@if(!empty($items??[]))
    <table>
        <tr>
            <td>#</td>
            <td style="width: 50px;">Номер договора</td>
            <td style="width: 50px;">Ширина</td>
            <td style="width: 50px;">Высота</td>
            <td style="width: 50px;">Глубина</td>
            <td style="width: 150px;">Для каких целей</td>
            <td style="width: 150px;">Комментарий</td>
            <td style="width: 150px;">Отверстие под ручку </td>
            <td style="width: 150px;">Тип отверстия под ручку </td>
            <td style="width: 150px;">Тип открывания двери </td>
            <td style="width: 150px;">Цвет короба</td>
            <td style="width: 150px;">Тип двери</td>
            <td style="width: 150px;">Отделка первой стороны</td>
            <td style="width: 150px;">Цвет отделки первой стороны</td>
            <td style="width: 150px;">Отделка второй стороны</td>
            <td style="width: 150px;">Цвет отделки второй стороны</td>
            <td style="width: 150px;">Цвет уплотнения</td>
            <td style="width: 150px;">Цвет фурнитуры</td>
            <td style="width: 50px;">Дверная ручка</td>
            <td style="width: 50px;">Верхняя перемычка</td>
            <td style="width: 50px;">Автоматический порог</td>
            <td style="width: 50px;">Скрытый стопор</td>
            <td style="width:50px;">Скрытый доводчик</td>
            <td style="width:50px;">Скрытый порожек</td>
            <td style="width:50px;">Установка двери</td>
            <td style="width: 150px;">Расположение петель</td>
            <td style="width: 50px;">Число петель</td>
            <td style="width: 150px;">Производитель петель</td>
            <td style="width: 150px;">Тип цены</td>
            <td style="width: 150px;">Цена, руб</td>
            <td style="width: 150px;">Кол-во</td>
            <td style="width: 150px;">Итог цена, руб</td>

        </tr>

        @foreach($items as $index=>$item)
            <tr>
                <td style="width: 50px;">{{$index+1}}</td>
                <td style="width: 50px;">{{$item->order->contract_number ?? $item->order->id }}</td>
                <td style="width: 50px;">{{$item->width ?? 0}}</td>
                <td style="width: 50px;">{{$item->height ?? 0}}</td>
                <td style="width: 50px;">{{$item->depth ?? 0}}</td>
                <td>{{$item->purpose ?? 'не указано'}}</td>
                <td>{{$item->comment ?? 'не указано'}}</td>
                <td>{{$item->handle_holes->title ?? 'не указано'}}</td>
                <td>{{$item->handle_holes_type->title ?? 'не указано'}}</td>
                <td>{{$item->opening_type->title ?? 'не указано'}}</td>
                <td>{{$item->box_and_frame_color->title ?? 'не указано'}}</td>
                <td>{{$item->door_type->title ?? 'не указано'}}</td>
                <td>{{$item->front_side_finish->title ?? 'не указано'}}</td>
                <td>{{$item->front_side_finish_color->title ?? 'не указано'}}</td>
                <td>{{$item->back_side_finish->title ?? 'не указано'}}</td>
                <td>{{$item->back_side_finish_color->title ?? 'не указано'}}</td>
                <td>{{$item->seal_color->title ?? 'не указано'}}</td>
                <td>{{$item->fittings_color->title ?? 'не указано'}}</td>
                <td style="width: 50px;">
                    {{($item->need_handle_holes ?? false) == "true" ? "Да":"Нет"}}
                </td>
                <td style="width: 50px;">
                    {{($item->need_upper_jumper ?? false) == "true" ? "Да":"Нет"}}
                </td>
                <td style="width: 50px;">
                    {{($item->need_automatic_doorstep ?? false) == "true" ? "Да":"Нет"}}
                </td>
                <td style="width: 50px;">
                    {{($item->need_hidden_stopper ?? false) == "true" ? "Да":"Нет"}}
                </td>
                <td style="width: 50px;">
                    {{($item->need_hidden_door_closer ?? false) == "true" ? "Да":"Нет"}}
                </td>
                <td style="width: 50px;">
                    {{($item->need_hidden_skirting_board ?? false) == "true" ? "Да":"Нет"}}
                </td>
                <td style="width: 50px;">
                    {{($item->need_door_install ?? false) == "true" ? "Да":"Нет"}}
                </td>


                <td>{{$item->loops->title ?? 'не указано'}}</td>
                <td style="width: 50px;">{{$item->loops_count ?? 0}}</td>
                <td>{{$item->hinge_manufacturer->title ?? 'не указано'}}</td>
                <td>{{$item->price_type->title ?? 'не указано'}}</td>
                <td style="width: 150px;">{{$item->price ?? 0}}</td>
                <td style="width: 150px;">{{$item->quantity ?? 0}}</td>
                <td style="width: 150px;">{{($item->price ?? 0)*($item->quantity ?? 0)}}</td>
            </tr>
        @endforeach

    </table>

@endif

</body>
</html>
