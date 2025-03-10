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
<h1 style="text-align: center; font-weight: bold;">Спецификация к договору DoDoors</h1>

@if(!empty($items??[]))
    <table>
        <tr>
            <td>№</td>
            <td>Модель</td>
            <td>Комплектация</td>
            <td>Размер, мм</td>
            <td>Цвет</td>
            <td>Кол-во, шт.</td>
            <td>Стоимость за комплект, руб.</td>
            <td>Стоимость, руб.</td>

        </tr>

        @php
        $summary = 0;
        @endphp
        @foreach($items as $index=>$item)
            <tr>
                <td style="width: 50px;">{{$index+1}}</td>

                <td>
                    DoDoors: {{$item->product->door_type->title ?? 'не указано'}},
                    открывание {{$item->product->opening_type->title ?? 'не указано'}},
                    петли {{$item->product->loops->title ?? 'не указано'}}.
                    Отделка с передней стороны: {{$item->product->front_side_finish->title ?? 'не указано'}}.
                    Отделка с задней стороны: {{$item->product->back_side_finish->title ?? 'не указано'}}.
                    Цвет короба и полотна: {{$item->product->box_and_frame_color->title ?? 'не указано'}}.
                    Цвет фурнитуры: {{$item->product->fittings_color->title ?? 'не указано'}}.
                </td>

                <td>
                    Каркас полотна: алюминий анодированный, отфрезерованный для монтажа петель и защелки. Короб двери: алюминий анодированный отфрезерованный для монтажа петель, с запилами сверху под 45 градусов, снизу под 90 градусов, для последующего, рассчитанного крепления полотна в коробе и монтажа короба в проёме стены. Отверстие под ручку. В комплект входит: короб двери, полотно, скрытые петли, - 4 шт. (Apecs), магнитная защелка (Apecs или аналог), уплотнитель короба, монтажные угловые пластины для сборки короба, монтажные пластины для крепления короба в проёме, метизы, ответная часть под защелку.
                </td>
                <td>{{$item->product->height ?? 0}}x{{$item->product->width ?? 0}}</td>
                <td>{{$item->product->box_and_frame_color->title ?? 'не указано'}}</td>
                <td>{{$item->quantity ?? 0}}</td>
                <td>{{$item->product->price ?? 0}}</td>
                <td>{{($item->product->price ?? 0)*($item->quantity ?? 0)}}</td>

                @php
                    $summary += (($item->product->price ?? 0) *($item->quantity ?? 0));
                @endphp
            </tr>
        @endforeach

        <tr>
            <td></td>
            <td colspan="6">Итого:</td>
            <td>{{$summary}}</td>

        </tr>
    </table>

@endif

</body>
</html>
