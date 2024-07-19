<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول علاوة طبيعة العمل</h2>
                    <p class="card-text">هنا يتم عرض علاوة طبيعة العمل بناءا على طبيعة العمل والمؤهل العلمي</p>
                </div>
                <div class="col-auto">
                    <a type="button" class="btn btn-success" data-toggle="modal" data-target="#createItem">
                        <i class="fe fe-plus"></i>
                    </a>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#editItem">
                        Launch demo modal
                    </button>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>طبيعة العمل</th>
                                        <th>المؤهل العلمي</th>
                                        <th>النسبة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nature_work_increases as $nature_work_increase)
                                    <tr class="increase_select" data-id="{{$nature_work_increase->id}}">
                                        <td>{{$nature_work_increase->id}}</td>
                                        <td>{{$nature_work_increase->nature_work}}</td>
                                        <td>{{$nature_work_increase->scientific_qualification}}</td>
                                        <td>{{$nature_work_increase->percentage}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    {{-- create model --}}
    <div class="modal fade" id="createItem" tabindex="-1" role="dialog" aria-labelledby="createItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemLabel">إنشاء نسبة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('nature_work_increases.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="row">
                            <div class="form-group p-3 col-4">
                                <x-form.input name="nature_work" placeholder="أدخل طبيعة العمل" label="طبيعة العمل" list="nature_work_list" required />
                                    <datalist id="nature_work_list">
                                        @foreach ($nature_work as $nature_work)
                                            <option value="{{ $nature_work }}">
                                        @endforeach
                                    </datalist>
                            </div>
                            <div class="form-group p-3 col-5">
                                <x-form.input name="scientific_qualification" placeholder="أدخل المؤهل العلمي" label="المؤهل العلمي" list="scientific_qualification_list" required />
                                    <datalist id="scientific_qualification_list">
                                        @foreach ($scientific_qualification as $scientific_qualification)
                                            <option value="{{ $scientific_qualification }}">
                                        @endforeach
                                    </datalist>
                            </div>
                            <div class="form-group p-3 col-3">
                                <x-form.input type="number" min="0" max="100"  label="النسبة" name="percentage" placeholder="25%" required/>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{$btn_label ?? "أضف"}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editItem" tabindex="-2" role="dialog" aria-labelledby="editItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemLabel">تعديل نسبة </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body " id="showIncrease">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{asset('assets/js/ajax.min.js')}}"></script>
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}";
    </script>
    <script src="{{asset('js/getShowNatureIncrease.js')}}"></script>
@endpush
</x-front-layout>
