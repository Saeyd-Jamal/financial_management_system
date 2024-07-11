@include('layouts.partials.head', ['title' => 'نظام الإدارة المالية - تسجيل الدخول'])
    <div class="wrapper vh-100">
        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('login') }}" method="POST">
                @csrf
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" style="max-width: 100%; margin-bottom: 50px">
                </a>
                <h1 class="h3 mb-3">تسجيل الدخول</h1>
                <div class="form-group text-left">
                    <x-form.input name="username" label="اسم المستخدم" placeholder="اسم المستخدم" class="form-control-lg" required  autofocus/>
                </div>
                <div class="form-group text-left">
                    <x-form.input type="password" name="password" label="كلمة المرور" placeholder="****" class="form-control-lg" required />
                </div>

                <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">تسجيل</button>
                <p class="mt-5 mb-3 text-muted font-weight-bold h6">© تم الإنشاء بواسطة <a href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank">م.السيد الأخرس</a></p>
            </form>
        </div>
    </div>
@include('layouts.partials.footer')
