<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <style>
        hr{
            position: absolute;
            top: 50px;
            right: 15px;
            width: 35%;
            height: 5px;
            border-radius: 10px;
            background: linear-gradient(to right, rgba(210, 255, 82, 1) 0%, rgba(40, 64, 18, 1) 100%);
            margin: 0;
        }
    </style>
    @endpush
    <div class="row align-items-center mb-2">
        <div class="col" style="position: relative">
            <h1 class="mb-2 page-title">إنشاء موظف جديد</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <form action="{{ route('employees.store', $employee->id) }}" method="post" class="col-12 mt-3">
            @csrf
            @include('dashboard.employees._form')
        </form>
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>إستيراد ملف إكسيل</strong>
                </div>
                <div class="card-body">
                    <form action="{{route('employees.importExcel')}}" class="dropzone bg-light rounded-lg" id="tinydash-dropzone" enctype="multipart/form-data">
                        <div class="dz-message needsclick  d-flex align-items-center flex-column">
                        <label for="fileUplode">
                            <div class="circle circle-lg bg-primary">
                                <i class="fe fe-upload fe-24 text-white"></i>
                            </div>
                        </label>
                        <input style="display: none" type="file" name="fileUplode" id="fileUplode" required accept=".xlsx, .xls" >
                        <h5 class="text-muted mt-4">إختار الملف الذي سترفعه للقاعدة</h5>
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                    </form>
                </div> <!-- .card-body -->
            </div> <!-- .card -->
        </div> <!-- .col -->
    </div>

</x-front-layout>
