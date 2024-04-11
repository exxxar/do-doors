<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$sheet_title ?? 'Цена'}}</title>
</head>
<body>
@php
    $tmpHeight = 0;
    $bg = "white";
@endphp
<table border="1">
    <thead>
    <tr>
        <td rowspan="2" style="font-weight: bold;border:1px solid #111;">Высота</td>
        <td rowspan="2" style="font-weight: bold;border:1px solid #111;">Ширина</td>
        <td rowspan="2" style="font-weight: bold;border:1px solid #111;width: 100px;text-align: center;">Число петель</td>
        @foreach($materials as $item)
            @php
                $item = (object)$item;
            @endphp
            <td colspan="5" width="200px"
                style="font-weight: bold;text-align: center;border:1px solid #111;"> {{ $item->title }}</td>
    @endforeach
    <tr>
        @foreach($materials as $item)
            <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #111;">Опт</td>
            <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #111;">Дилер</td>
            <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #111;">Розница</td>
            <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #111;">Себестоимость</td>
            <td width="100px" style="font-weight: bold;text-align: center;border:1px solid #111;">Коэффициент</td>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($prices as $index=>$item)
        @php
            $item = (object)$item;
            if ($item->height != $tmpHeight)
                {
                    $tmpHeight = $item->height;
                    $bg = $bg=="white"?"lightgray":"white";
                }

        @endphp
        <tr style="background: red;">
            <td style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{$item->height}}</td>
            <td style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{$item->width}}</td>
            <td style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{$item->loops_count}}</td>
            @foreach ($item->prices  as $price)
                @php
                    $price = (object)$price;
                @endphp
                <td width="100px"
                    style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{ $price->price["wholesale"] ?? 0 }}</td>
                <td width="100px"
                    style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{ $price->price["dealer"]?? 0 }}</td>
                <td width="100px"
                    style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{ $price->price["retail"]?? 0 }}</td>
                <td width="100px"
                    style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{ $price->price["cost"]?? 0 }}</td>
                <td width="100px"
                    style="text-align: center;border:1px solid #111;background-color: {{$bg}};">{{ $price->price_koef ?? 0 }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
