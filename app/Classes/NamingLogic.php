<?php

namespace App\Classes;

class NamingLogic
{
    protected $product;
    public function query(): static
    {
        return $this;
    }

    public function setProduct($product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getName(): string
    {
        $shorts = ['Комплект двери скрытого монтажа' => 'КДС'];
        $product = $this->product;

        return sprintf(
            'DoDoors: %s %s%dx%d, открывание %s, петли %s. %s %s/%s %s. Цвет короба и полотна: %s. Цвет фурнитуры: %s. Толщина профиля %s мм. %s%s%s%s',
            $shorts[$product->door_type->title ?? null] ?? ($product->door_type->title ?? 'КДС'),
            filter_var($product->need_upper_jumper ?? false, FILTER_VALIDATE_BOOLEAN) ? '' : 'без верх. перемычки ',
            $product->height ?? 0,
            $product->width ?? 0,
            mb_strtolower($product->opening_type->title ?? 'не указано'),
            mb_strtolower($product->loops->title ?? 'не указано'),
            $product->front_side_finish->title ?? 'материал',
            $product->front_side_finish_color->title ?? 'Грунт',
            $product->back_side_finish->title ?? 'материал',
            $product->back_side_finish_color->title ?? 'Грунт',
            $product->box_and_frame_color->title ?? 'не указано',
            $product->fittings_color->title ?? 'не указано',
            $product->depth ?? 'не указано',
            filter_var($product->need_automatic_doorstep ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Автоматический порог ' : '',
            filter_var($product->need_hidden_stopper ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Скрытый стопор ' : '',
            filter_var($product->need_hidden_door_closer ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Скрытый доводчик ' : '',
            filter_var($product->need_hidden_skirting_board ?? false, FILTER_VALIDATE_BOOLEAN) ? 'Скрытый плинтус ' : ''
        );
    }
}
