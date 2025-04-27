<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$sheet_title ?? 'Вкладка 1'}}</title>
</head>
<body>
@php
    $sumPaid = 0;
    $sumDebt = 0;
    $sumProfit = 0;
@endphp
<table border="1">
    <thead>
    <tr>
        <td>№</td>
        <td>Номер договора</td>
        <td>Дата договор</td>
        <td>Предпологаемая дата сдачи</td>
        <td>Заказчик</td>
        <td>Статус</td>
        <td>Дата заявки</td>
        <td>Источник</td>
        <td>Контактное лицо</td>
        <td>Номер телефона</td>
        <td>На ООО или ИП</td>
        <td>Себестоимость</td>
        <td>Тип клиента</td>
        <td>Сумма договора</td>
        <td>Оплачено</td>
        <td>Задолженность</td>
        <td>Прибыль</td>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $index=>$item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->contract_number ?? '-'}}</td>
            <td>{{$item->contract_date}}</td>
            <td>{{$item->completion_at}}</td>
            <td>{{$item->client->title ?? $item->client_id ?? '-'}}</td>
            <td>{{$item->status?? '-'}}</td>
            <td>{{$item->created_at?? '-'}}</td>
            <td>{{$item->source?? '-'}}</td>
            <td>{{$item->contact_person?? '-'}}</td>
            <td>{{$item->phone?? '-'}}</td>
            <td>{{$item->organizational_form?? '-'}}</td>
            <td>{{$item->cost_price?? '-'}} руб.</td>
            <td>{{$item->client->status?? '-'}}</td>
            <td>{{$item->contract_amount?? '-'}} руб.</td>
            <td>{{$item->paid?? '-'}} руб.</td>
            <td>{{$item->debt?? '-'}} руб.</td>
            <td>{{$item->profit?? '-'}} руб.</td>
        </tr>

        @php
            $sumPaid += ($item->paid??0);
            $sumDebt += ($item->debt??0);
            $sumProfit += ($item->profit??0);
        @endphp
    @endforeach
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <td colspan="2">Итого</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Оплачено</td>
        <td>{{$sumPaid}}</td>
    </tr>
    <tr>
        <td>Задолжность</td>
        <td>{{$sumDebt}}</td>
    </tr>
    <tr>
        <td>Общая выгода</td>
        <td>{{$sumProfit}}</td>
    </tr>
    </tbody>

</table>
</body>
</html>
