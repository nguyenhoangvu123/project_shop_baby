@include('client/components/script_header')
@include('client/components/svg')
<div id="wrapper">
    @include('client/components/header')
    <main id="main" class="">
        <div class="seo-home" style="display: none;">
            <h1 style="visibility: hidden; height: 0px; margin: 0px; overflow: hidden;">Cửa Hàng Mẹ Và Bé Hằng
                Japan</h1>
            <h2 style="visibility: hidden; height: 0px; margin: 0px; overflow: hidden;">Các Sản Phẩm Mẹ Và Bé Hằng
                Japan</h2>
        </div>
        @include('client/components/menu')
</div>
@yield('content')
</main>
@include('client/components/footer')
@include('client/components/menu-mobile')
@include('client/components/form-login')
@include('client/components/script')