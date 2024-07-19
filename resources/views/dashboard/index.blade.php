<x-front-layout>
    <div class="row align-items-center mb-2">
        <div class="col">
            @auth
                <h2 class="h5 page-title">مرحبا : {{auth()->user()->name}}</h2>
            @endauth
        </div>
        <div class="col-auto">
            <form class="form-inline">
                <div class="form-group d-none d-lg-inline">
                    <label for="reportrange" class="sr-only">Date Ranges</label>
                    <div id="reportrange" class="px-2 py-2 text-muted">
                        <span class="small"></span>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-sm"><span
                            class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-sm mr-2"><span
                            class="fe fe-filter fe-16 text-muted"></span></button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="shadow p-3 mb-5 bg-white rounded col-md-6">
            <h3>{{ $chartEmployees->options['chart_title'] }}</h3>
            {!! $chartEmployees->renderHtml() !!}
        </div>
    </div>

    @push('scripts')
    {!! $chartEmployees->renderChartJsLibrary() !!}
    {!! $chartEmployees->renderJs() !!}
    @endpush
</x-front-layout>
