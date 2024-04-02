<template>
    <div class="card mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="/images/logo.jpg" alt="" class="w-100 object-fit-cover" >
                </div>
                <div class="col-md-8">Комплект {{item.product.height}}х800х57 (черный) лицо зеркало /зеркало петли L стандарт 5 шт (черный), НА СЕБЯ , отв. под ручку</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:["item"]
}
</script>
