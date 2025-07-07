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
            <td style="width: 500px;">Спецификация</td>
        </tr>

        @foreach($items as $index=>$item)
            <tr>
                <td>{{$index+1}}</td>
                <td>
                    {{NamingLogic::query()->setProduct($item->product)->getName()}}
                    {{-- DoDoors:{{$item->product->door_type->title ?? 'КДС'}}
                     {{($item->product->need_upper_jumper ?? false) == "true" ? '' : 'без верх. перемычки'}}
                     {{$item->product->height ?? 0}}х{{$item->product->width ?? 0}},
                     открывание {{$item->product->opening_type->title ?? 'не указано'}},
                     петли {{$item->product->hinge_manufacturer->title  ?? 'не указано'}} ({{$item->product->loops_count ?? 0}})
                     . {{$item->product->front_side_finish->title ?? '-'}}
                     {{$item->product->front_side_finish_color->title ?? 'Грунт'}}
                     / {{$item->product->back_side_finish->title ?? 'Грунт'}}
                     {{$item->product->back_side_finish_color->title ?? 'Грунт'}}.
                     @if (!is_null($item->product->box_and_frame_color->title ?? null))
                         Цвет короба и полотна: {{$item->product->box_and_frame_color->title ?? 'не указано'}}.
                     @endif
                     @if (!is_null($item->product->fittings_color->title ?? null))
                         Цвет фурнитуры: {{$item->product->fittings_color->title ?? 'не указано'}}.
                     @endif
                     Толщина профиля {{$item->product->depth ?? 'не указано'}} мм.
                     {{($item->product->need_automatic_doorstep ?? false) == "true" ? 'Автоматический порог' : ''}}
                     {{($item->product->need_hidden_stopper ?? false) == "true" ? 'Скрытый стопор' : ''}}
                     {{($item->product->need_hidden_door_closer ?? false) == "true" ? 'Скрытый доводчик' : ''}}
                     {{($item->product->need_hidden_skirting_board ?? false) == "true" ? 'Скрытый плинтус' : ''}}
                     {{($item->product->need_door_install ?? false) == "true" ? 'Установка двери' : ''}}--}}
                    {{-- {{($item->product->need_handle_holes ?? false) == "true" ? 'Ручка в комплекте' : ''}--}}}
                </td>
            </tr>
        @endforeach
    </table>
@endif


</body>
</html>
