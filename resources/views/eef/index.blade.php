@extends("app")

@section("page")


<vue-header></vue-header>
<partners></partners>
{{--  кожемыка  --}}
{{--  Онлайн сссесия  --}}
{{--  Спикеры --}}
    <div class="container">
        <div class="row">
            <div class="col-12">
                <H2>Спикеры <small>Москва</small></H2>
            </div>
        </div>

        <div class="row">
            <speaker></speaker>
            <speaker></speaker>
            <speaker></speaker>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <H2>Спикеры <small>Владивосток</small></H2>
            </div>
        </div>

        <div class="row">
            <speaker></speaker>
            <speaker></speaker>
            <speaker></speaker>
        </div>
    </div>
{{--  Спикеры 2 --}}
{{--  прямая трансляция --}}
{{--  footer --}}

@endsection
<script>
    import Partners from "../../js/components/Partners";
    export default {
        components: {Partners}
    }
</script>
