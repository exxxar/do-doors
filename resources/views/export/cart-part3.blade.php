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
<h3 style="text-align: center; font-weight: bold;">Коммерческое предложение DoDoors</h3>

@if(!empty($items??[]))
    <table>
        <tr>
            <td style="width: 50px;">№</td>
            <td style="width: 100px;" colspan="2">Модель</td>
            <td style="width: 150px;">Комплектация</td>
            <td style="width: 150px;">Размер, мм</td>
            <td style="width: 150px;">Цвет</td>
            <td style="width: 50px;">Кол-во, шт.</td>
            <td style="width: 150px;">Стоимость за комплект, руб.</td>
            <td style="width: 150px;">Стоимость, руб.</td>

        </tr>

        @php
            $summary = 0;
            $index = 1;
        @endphp

        @foreach($items as $key=>$item)
            <tr>
                <td style="width: 50px;">{{$index}}</td>

                <td style="width: 100px;" colspan="2">
                    DoDoors: {{$item->product->door_type->title ?? 'не указано'}},
                    открывание {{$item->product->opening_type->title ?? 'не указано'}},
                    петли {{$item->product->loops->title ?? 'не указано'}}.
                    Отделка с передней стороны: {{$item->product->front_side_finish->title ?? 'не указано'}} ({{$item->product->front_side_finish_color->title ?? '-'}}).
                    Отделка с задней стороны: {{$item->product->back_side_finish->title ?? 'не указано'}} ({{$item->product->back_side_finish_color->title ?? '-'}}).
                    Цвет короба и полотна: {{$item->product->box_and_frame_color->title ?? 'не указано'}}.
                    Цвет фурнитуры: {{$item->product->fittings_color->title ?? 'не указано'}}.
                </td>

                <td style="width: 150px;">
                    Каркас полотна: алюминий анодированный, отфрезерованный для монтажа петель и защелки. Короб двери:
                    алюминий анодированный отфрезерованный для монтажа петель, с запилами сверху под 45 градусов, снизу
                    под 90 градусов, для последующего, рассчитанного крепления полотна в коробе и монтажа короба в
                    проёме стены. Отверстие под ручку. В комплект входит: короб двери, полотно, скрытые петли,
                    - {{$item->product->loops_count ?? 0}} шт. ({{$item->product->loops->title}}), магнитная защелка
                    (Apecs или аналог), уплотнитель короба, монтажные угловые пластины для сборки короба, монтажные
                    пластины для крепления короба в проёме, метизы, ответная часть под защелку.
                </td>

                <td style="width: 150px;">{{$item->product->height ?? 0}}x{{$item->product->width ?? 0}}</td>
                <td style="width: 150px;">{{$item->product->box_and_frame_color->title ?? 'не указано'}}</td>
                <td style="width: 50px;">{{$item->quantity ?? 0}}</td>
                <td style="width: 150px;">{{$item->product->price ?? 0}}</td>
                <td style="width: 150px;">{{($item->product->price ?? 0)*($item->quantity ?? 0)}}</td>

                @php
                    $summary += (($item->product->price ?? 0) *($item->quantity ?? 0));
                       $index++;
                @endphp
            </tr>
        @endforeach

        @if(!is_null($other_products))
            @foreach($other_products as $index=>$item)
                <tr>
                    <td style="width: 50px;">{{$index}}</td>

                    <td style="width: 100px;" colspan="2">
                        {{$item->title ?? '-'}}
                    </td>


                    <td style="width: 150px;">
                        {{$item->description ?? '-'}}
                    </td>

                    <td style="width: 150px;">-</td>
                    <td style="width: 150px;">-</td>
                    <td style="width: 50px;">1</td>
                    <td style="width: 150px;">{{$item->price ?? 0}}</td>
                    <td style="width: 150px;">{{$item->price ?? 0}}</td>

                    @php
                        $summary += $item->price ?? 0;
                         $index++;
                    @endphp
                </tr>

            @endforeach
        @endif
        <tr>
            <td></td>
            <td colspan="7">Итого:</td>
            <td>{{$summary}}</td>

        </tr>
    </table>

@endif


<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td colspan="2"><strong>Сайт:</strong></td>
        <td colspan="3"><a href="https://do-doors.ru/">https://do-doors.ru/</a></td>
        <td colspan="1"><strong>Почта:</strong></td>
        <td colspan="3"><a href="mailto:dodoors@yandex.ru">dodoors@yandex.ru</a></td>
    </tr>
</table>
</body>
</html>
