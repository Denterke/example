<template lang="pug">
    .skew
        .unskew
            slot
</template>

<script>

</script>

<style scoped lang="stylus">
.skew
    transform skewY(-17.5deg)
    overflow hidden

    .unskew
        transform skewY(17.5deg)
        background lightgray
        margin-top -16%
        margin-bottom -16%
</style>
