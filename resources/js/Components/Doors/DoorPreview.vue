<template>
    <div class="stage" >
        <div class="door">
            <img :src="doorImage?doorImage:'/images/door-1.jpg'"
                 class="w-100 h-100" style="object-fit: cover;"
                 alt="">
            <div class="door-color" v-bind:style="{'background-color':doorColor}"></div>
        </div>
    </div>
</template>
<script>
export default {
    props:["door"]
}
</script>
<style lang="scss">
.stage {
    width: 300px;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: end;
    position: relative;
    background-color: white;

    border: 1px dashed black;

    .door {
        width: 100px;
        height: 200px;
      //  background: url('/images/door-1.jpg');
        background-size: cover;
        position: relative;
        .door-color {
            position: absolute;
            z-index: 1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 50%;
        }
    }
}

.door-image {
    max-width: 200px;

    img {
        object-fit: cover;
    }
}

.door-wrapper {
    width: 500px;
    min-height: 589px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: end;
    background: #f1e1df;

    .back-image {
        top: 0px;
        left: 0px;
        position: absolute;
        object-fit: cover;
        z-index: 0;
    }

    .front-image {
        position: absolute;
        object-fit: cover;
        z-index: 1;
    }
}

</style>
