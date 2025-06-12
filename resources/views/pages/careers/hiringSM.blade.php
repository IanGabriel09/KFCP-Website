@extends('_layouts.app')

@section('content')
<br>
<div id="contentContainer" class="container mt-5">
    <div class="d-block mb-3">
        <a href="{{ route('pages.careers') }}" class="btn btn-theme-outline">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
    
    <div id="posContent" class="col-12 p-3 custom-box-shadow rounded bg-white">
        <div class="posHead">
            <h2>{{ $activeJobSM->pos_name }}</h2>
            <p class="lead">ID: {{ $activeJobSM->UID }}</p>
            <h5 class="color-indicator">
                @if($activeJobSM->pos_quantity === 'Multiple')
                    *Hiring Multiple Candidates*
                @endif
            </h5>
            <div class="d-flex justify-content-between w-100 p-0">
                <p class="m-0">Date Posted: {{ \Carbon\Carbon::parse($activeJobSM->created_at)->format('Y-m-d') }}</p>
                <p class="m-0">Job Type: {{ $activeJobSM->job_type }}</p>
            </div>

            <h5 class="mt-2">Job Description</h5>
            <div class="px-3">
                <p class="text-justify-custom">{{ $activeJobSM->job_description }}</p>
                <div class="text-center">
                    <a href="{{ route('pages.careers.form', ['uid' => $activeJobSM->UID]) }}" class="btn btn-theme">Apply now</a>
                </div>
            </div>
        </div>

        <hr>

        <div id="posBody">
            <div class="mt-2 qualifications">
                <h5>Qualifications:</h5>
                @foreach ($qualifications as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </div>

            <div class="mt-2 benefits">
                <h5>Benefits:</h5>
                @foreach ($benefits as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        console.log(@json($activeJobSM));
    })
</script>
@endsection

