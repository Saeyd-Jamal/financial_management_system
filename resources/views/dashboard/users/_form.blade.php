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
        @if (isset($btn_label))
        <x-form.input type="password" label="كلمة المرور" name="password" placeholder="****"  />
        @else
        <x-form.input type="password" label="كلمة المرور" name="password" placeholder="****" required />
        @endif
    </div>

    @if (!isset($btn_label))
    <div class="form-group p-3 col-4">
        <x-form.input type="password" label="تأكيد كلمة المرور"  name="confirm_password" placeholder="****" required/>
    </div>
    @endif

</div>
<div class="row ml-3">
    <fieldset>
        <legend>الصلاحيات</legend>
        @foreach (app('abilities') as $ability_name => $ability)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="abilities[]" id="ability-{{$ability_name}}" value="{{$ability_name}}" @checked(in_array($ability_name, $user->roles()->pluck('role_name')->toArray())) >
                <label class="form-check-label" for="ability-{{$ability_name}}">
                    {{$ability}}
                </label>
            </div>
        @endforeach
    </fieldset>
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
