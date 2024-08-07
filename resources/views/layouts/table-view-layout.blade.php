@include('layouts.partials.head')
<div class="wrapper">
    @include('layouts.partials.nav')
    {{-- @include('layouts.partials.aside') --}}
        <main role="main" class="main-content ">
            <div class="container-fluid">
                <div class="col-12 {{$classC}}">
                    {{ $breadcrumbs ?? ''}}
                    <x-alart type="success"/>
                    <x-alart type="info"/>
                    <x-alart type="danger"/>
                    {{ $slot }}
                </div> <!-- .col-12 -->
            </div> <!-- .container-fluid -->
        </main> <!-- main -->
</div> <!-- .wrapper -->
@include('layouts.partials.footer')
