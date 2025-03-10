<template>
    <ul class="list-group">
        <li class="list-group-item">
            <strong>Название:</strong> {{ selectedHandle.title || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Позиция в порядке:</strong> {{ selectedHandle.order_position || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Цвет:</strong> {{ selectedHandle.color || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Цена,₽:</strong>

            <table class="w-100">

                <thead>
                <th style="width: 100px;text-align: center;">опт</th>
                <th style="width: 100px;text-align: center;">дилер</th>
                <th style="width: 100px;text-align: center;">розница</th>
                <th style="width: 100px;text-align: center;">себестоимость</th>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 100px; text-align: center;">
                        {{ selectedHandle.price?.wholesale || 0 }}
                    </td>
                    <td style="width: 100px; text-align: center;">
                        {{ selectedHandle.price?.dealer || 0 }}
                    </td>
                    <td style="width: 100px; text-align: center;">
                        {{ selectedHandle.price?.retail || 0 }}
                    </td>
                    <td style="width: 100px; text-align: center;">{{
                            selectedHandle.price?.cost || 0
                        }}
                    </td>
                </tr>
                </tbody>
            </table>
        </li>
        <li class="list-group-item">
            <strong>Варианты ({{ selectedHandle.variants?.length || 0 }}):</strong>
            <div class="row">
                <div class="col-md-4 mb-2 d-flex align-items-start"
                     v-for="(variant, index) in selectedHandle.variants">

                    <img

                        style="min-height: 200px;border:1px black solid;"
                        v-lazy="prepareImage(variant.image)"
                        class="card-img-top uploaded-image-mini object-fit-contain"
                        alt="">


                </div>
            </div>
        </li>
        <li class="list-group-item">
            <strong>Артикул (SKU):</strong> {{ selectedHandle.sku || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Описание:</strong> {{ selectedHandle.comment || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Бренд:</strong> {{ selectedHandle.brand || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Вес:</strong> {{ selectedHandle.weight || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Материал:</strong> {{ selectedHandle.material || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Описание материала:</strong> {{ selectedHandle.material_description || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Покрытие:</strong> {{ selectedHandle.coverage || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Серийный номер:</strong> {{ selectedHandle.serial || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Модель:</strong> {{ selectedHandle.model || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Характеристики:</strong> {{ selectedHandle.characteristics || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Форма основания:</strong> {{ selectedHandle.base_shape || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Диаметр патрона:</strong> {{ selectedHandle.socket_diameter || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Длина квадрата:</strong> {{ selectedHandle.square_length || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Гарантия:</strong> {{ selectedHandle.guarantee || '-' }}
        </li>
        <li class="list-group-item">
            <strong>Габариты:</strong> {{ selectedHandle.dimensions || '-' }}
        </li>
    </ul>
</template>
<script>
export default{
    props:["selectedHandle"],
    methods:{
        prepareImage(image) {
            if (typeof image !== "string" || !image.trim()) return "/images/default.png"; // Защита от пустых и некорректных данных
            return image.startsWith("http://") || image.startsWith("https://") ? image : `/images/${image}`;
        },
    }
}
</script>
