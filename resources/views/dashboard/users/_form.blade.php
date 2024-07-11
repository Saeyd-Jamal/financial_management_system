<div class="row">
    <div class="form-group p-3 col-4">
        <x-form.input label="الاسم" :value="$user->name"  name="name" placeholder="محمد ...." required autofocus/>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input label="اسم المستخدم" :value="$user->username"  name="username" placeholder="username" required/>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input type="email" label="البريد الالكتروني" :value="$user->email"  name="email" placeholder="example@gmail.com"/>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input type="password" label="كلمة المرور" name="password" placeholder="****" required/>
    </div>

    @if (!isset($btn_label))
    <div class="form-group p-3 col-4">
        <x-form.input type="password" label="تأكيد كلمة المرور"  name="confirm_password" placeholder="****" required/>
    </div>
    @endif

</div>

<div class="row align-items-center mb-2">
    <div class="col">
        <h2 class="h5 page-title"></h2>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            {{$btn_label ?? "أضف"}}
        </button>
    </div>
</div>
