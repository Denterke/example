<template lang="pug">

    div
        vue-navbar
        .background-image
            .text-container
            img.overlay(src="/images/header_overlay.svg")

</template>

<script>

</script>

<style scoped lang="stylus">
    .background-image
        background url('/images/BackgroundImage.jpg') no-repeat
        background-size cover

        .overlay
            width 100%
            margin-bottom -1px
</style>
