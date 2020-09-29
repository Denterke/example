<template lang="pug">
    .col-md-4
        .speaker
            .photo-container
                skew-container
                    img.photo(src="/images/speaker-photo.jpg")
            .name Догузова Зарина Валерьевна
            .post Вице-президент по вопросам сотрудничества с международными организациями и гастро-туризму
</template>

<script>

</script>

<style scoped lang="stylus">
    .speaker
        background white
        box-shadow 0 4px 30px rgba(0, 0, 0, 0.1)
        padding 40px
        text-align right
        margin-top 50%

        .photo-container
            width 100%
            margin-bottom 22%
            margin-top -55%
            position relative

            .photo
                width 100%
                max-height 117%
                min-height 117%

        .name
            font-weight 500
            font-size 22px
            line-height 26px
            text-align right
            color #333333

        .post
            margin-top 20px
            font-size 16px
            line-height 26px
            text-align right
</style>
