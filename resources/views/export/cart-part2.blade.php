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
        @endphp

        @foreach($items as $index=>$item)
            <tr>
                <td style="width: 50px;">{{$index+1}}</td>

                <td style="width: 100px;" colspan="2">
                    DoDoors: {{$item->product->door_type->title ?? 'не указано'}},
                    открывание {{$item->product->opening_type->title ?? 'не указано'}},
                    петли {{$item->product->loops->title ?? 'не указано'}}.
                    Отделка с передней стороны: {{$item->product->front_side_finish->title ?? 'не указано'}}.
                    Отделка с задней стороны: {{$item->product->back_side_finish->title ?? 'не указано'}}.
                    Цвет короба и полотна: {{$item->product->box_and_frame_color->title ?? 'не указано'}}.
                    Цвет фурнитуры: {{$item->product->fittings_color->title ?? 'не указано'}}.
                </td>

                @if($index==0)
                <td style="width: 150px;" rowspan="{{count($items)}}">
                    Каркас полотна: алюминий анодированный, отфрезерованный для монтажа петель и защелки. Короб двери: алюминий анодированный отфрезерованный для монтажа петель, с запилами сверху под 45 градусов, снизу под 90 градусов, для последующего, рассчитанного крепления полотна в коробе и монтажа короба в проёме стены. Отверстие под ручку. В комплект входит: короб двери, полотно, скрытые петли, - 4 шт. (Apecs), магнитная защелка (Apecs или аналог), уплотнитель короба, монтажные угловые пластины для сборки короба, монтажные пластины для крепления короба в проёме, метизы, ответная часть под защелку.
                </td>
                @endif
                <td style="width: 150px;">{{$item->product->height ?? 0}}x{{$item->product->width ?? 0}}</td>
                <td style="width: 150px;">{{$item->product->box_and_frame_color->title ?? 'не указано'}}</td>
                <td style="width: 50px;">{{$item->quantity ?? 0}}</td>
                <td style="width: 150px;">{{$item->product->price ?? 0}}</td>
                <td style="width: 150px;">{{($item->product->price ?? 0)*($item->quantity ?? 0)}}</td>

                @php
                    $summary += (($item->product->price ?? 0) *($item->quantity ?? 0));
                @endphp
            </tr>
        @endforeach

        <tr>
            <td></td>
            <td colspan="7">Итого:</td>
            <td>{{$summary}}</td>

        </tr>
    </table>

@endif

<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th colspan="5" style="text-align: left;font-weight: bold;"><h3>ПРОДАВЕЦ:</h3></th>
        <th colspan="4" style="text-align: left;font-weight: bold;"><h3>ПОКУПАТЕЛЬ:</h3></th>
    </tr>

, , , ,
    <tr>
        <td colspan="2" ><strong>Имя:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_title"]}}</td>
        <td colspan="1"><strong>Имя:</strong> </td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_title"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>ИНН:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$seller["seller_inn"]}}</td>
        <td colspan="1"><strong>ИНН:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$buyer["buyer_inn"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>КПП:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$seller["seller_kpp"]}}</td>
        <td colspan="1"><strong>КПП:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$buyer["buyer_kpp"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>ОГРНИП:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$seller["seller_ogrn"]}}</td>
        <td colspan="1"><strong>ОГРН:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$buyer["buyer_ogrn"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Юр. адрес:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_legal_address"]}}</td>
        <td colspan="1"><strong>Юр. адрес:</strong></td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_legal_address"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Банк:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_bank_name"]}}</td>
        <td colspan="1"><strong>Банк:</strong></td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_bank_name"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>БИК:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$seller["seller_bank_bic"]}}</td>
        <td colspan="1"><strong>БИК:</strong></td>
        <td colspan="3" style="text-align: right;">&#8203;{{$buyer["buyer_bank_bic"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>к/сч:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_correspondent_account"]}}</td>
        <td colspan="1"><strong>к/сч:</strong></td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_correspondent_account"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>р/сч:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_checking_account"]}}</td>
        <td colspan="1"><strong>р/сч:</strong></td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_checking_account"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Телефон:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_phone"]}}</td>
        <td colspan="1"><strong>Телефон:</strong></td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_phone"]}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Email:</strong></td>
        <td colspan="3" style="text-align: right;">{{$seller["seller_email"]}}</td>
        <td colspan="1"><strong>Email:</strong></td>
        <td colspan="3" style="text-align: right;">{{$buyer["buyer_email"]}}</td>
    </tr>
</table>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td colspan="2"><strong>Подпись:</strong></td>
        <td colspan="3"></td>
        <td colspan="1"><strong>Подпись:</strong></td>
        <td colspan="3"></td>
    </tr>
</table>
</body>
</html>
