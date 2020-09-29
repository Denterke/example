<template>
    <div class="navbar-container">
        <div class="container">
            <div class="row">
                <div class="col-6 d-flex logo-container">
                    <div class="logo-item">
                        <img src="/images/ptf_logo.svg" alt="PTF logo">
                    </div>
                    <div class="logo-item">
                        <img src="/images/eef_logo.svg" alt="EEF logo">
                    </div>
                </div>
                <div class="col-6 d-none d-md-flex justify-content-between navigation-container">
                    <a href="#"><div class="navigation-item">Главная</div></a>
                    <a href="#"><div class="navigation-item">Контакты</div></a>

                    <a href="#">
                        <div class="login-box">
                            <div>
                            <svg
                                width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.655 12.7539C12.628 11.0256 12.0896 9.45401 11.1322 8.31618C10.1805 7.18529 8.89059 6.5625 7.4998 6.5625C6.10902 6.5625 4.81914 7.18529 3.86737 8.31618C2.91095 9.45281 2.37285 11.0222 2.34473 12.7484C2.88555 13.0193 5.12353 14.0625 7.4998 14.0625C10.0694 14.0625 12.1535 13.0254 12.655 12.7539Z" fill="white"/>
                                <path d="M7.5 6.09375C8.92386 6.09375 10.0781 4.93948 10.0781 3.51562C10.0781 2.09177 8.92386 0.9375 7.5 0.9375C6.07614 0.9375 4.92188 2.09177 4.92188 3.51562C4.92188 4.93948 6.07614 6.09375 7.5 6.09375Z" fill="white"/>
                            </svg>
                        <div  class="login">Вход / Регистрация</div>
                        </div>
                        </div>
                    </a>
                </div>


                <div class="col-6 d-md-none">
                    <div class="burger-menu">
                        <div class="menu-icon-wrapper" @click="menuIconSwitch">
                            <div class="menu-icon"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "VueNavbar",
        methods: {
            menuIconSwitch() {
                document.querySelector('.menu-icon').classList.toggle('menu-icon-active');
            }
        },
    }
</script>

<style scoped lang="stylus">
    @import "../../sass/colors";

    .navbar-container
        position absolute
        padding 30px 0 0 0
        top 0
        left 0
        width 100vw
        max-width 100%
        z-index 2

        .container
            .row
                .logo-container
                    .logo-item
                        margin-right 70px
                        display flex
                        flex-direction column
                        justify-content center
                        height 100%

                        @media screen and (max-width: 576px)
                            margin-right 10px


                .navigation-container
                    font-size 0.75rem
                    bottom 20px


                    .navigation-item
                        text-transform uppercase
                        letter-spacing: 0.2em;

                    .navigation-item, .login
                        color white
                        line-height 0.875rem

                    .navigation-item, .login-box
                        display flex
                        flex-direction column
                        justify-content center
                        height 100%

                    .login
                        font-weight bold
                        display: inline-block


    .burger-menu {
        position: absolute;
        top: 16px;
        right: 18px;
        z-index: 2;


        .menu-icon-wrapper {
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .menu-icon {
            position: relative;
            top: 10px;
            width: 30px;
            height: 3px;
            background-color: #fff;
        }

        .menu-icon::before {
            position: absolute;
            left: 0;
            top: -10px;
            content: '';
            width: 30px;
            height: 3px;
            background-color: #fff;
            transition: transform 0.2s ease-in, top 0.2s linear 0.2s;

        }

        .menu-icon::after {
            position: absolute;
            left: 0;
            top: 10px;
            content: '';
            width: 30px;
            height: 3px;
            background-color: #fff;
            transition: transform 0.2s ease-in, top 0.2s linear 0.2s;

        }

        .menu-icon.menu-icon-active {
            background-color: transparent;
        }

        .menu-icon.menu-icon-active::before {
            transform: rotate(45deg);
            top: 0;
            transition: top 0.2s linear, transform 0.2s ease-in 0.2s;
        }

        .menu-icon.menu-icon-active::after {
            transform: rotate(-45deg);
            top: 0;
            transition: top 0.2s linear, transform 0.2s ease-in 0.2s;
        }
    }
</style>
