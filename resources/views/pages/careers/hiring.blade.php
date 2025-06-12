@extends('_layouts.app')

@section('content')
<div id="contentContainer" class="container mt-5">
    <br>
    <div class="text-center">
        <h1 class="fs-heading2 color-theme">We Are Hiring</h1>
        <p class="lead">We’re looking for passionate individuals to help us grow and make an impact. Check out our open positions and apply now!</p>
    </div>
    <hr>
    <div class="row">
        <!-- Active positions list -->
        <div id="activePosSection" class="col-md-5 col-sm-12 mt-3">
            <div id="activePosContainer" class="specific-pos-card" data-aos="fade-up" data-aos-delay="200">
                @if (count($positions) > 0)
                    @foreach ($positions as $item)
                    <div class="custom-box-shadow position-card p-3 mb-3 rounded bg-white">
                        <div class="pos-card-head">
                            <p class="lead">Position ID: {{ $item['UID'] }}</p>
                            <h5 class="color-indicator">
                                @if($item['pos_quantity'] === 'Multiple')
                                    *Hiring Multiple Candidates*
                                @endif
                            </h5>

                            <h4>{{ $item['pos_name'] }}</h4>
                            <p>Date Posted: {{ \Carbon\Carbon::parse($item['created_at'])->format('Y-m-d') }}</p>
                            <p>Job Type: {{ $item['job_type'] }}</p>
                            <a href="{{ route('pages.careers.form', ['uid' => $item['UID']]) }}" class="fs-small lead text-decoration-none"><i class="fa-regular fa-paper-plane"></i> <i>Apply Now</i></a>
                        </div>

                        <div class="pos-card-body border p-3 bg-white">
                            <h5>Job description:</h5>
                            <p class="text-justify-custom">{{ $item['job_description'] }}</p>
                            <div class="text-center">
                                <button class="btn btn-theme" onclick="getPosition('{{ $item['UID'] }}', true)">See more</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info">No open positions at the moment.</div>
                @endif
            </div>
        </div>

        <!-- Positions section (Detailed view) -->
        <div id="positionsSection" class="col-md-7 col-sm-12 mt-3" data-aos="fade-up">
            @if (!empty($position))
            <div class="custom-box-shadow p-3 rounded bg-white sticky-top" style="top: 125px">
                <div class="activePosHead">
                    <h2>{{ $position['pos_name'] }}</h2>
                    <p class="lead">ID: {{ $position['UID'] }}</p>
                
                    <h5 id="posQuantityIndicator" class="color-indicator" style="{{ $position['pos_quantity'] === 'Multiple' ? '' : 'display: none;' }}">
                        *Hiring Multiple Candidates*
                    </h5>

                    <div class="d-flex justify-content-between w-100 p-0">
                        <p>Date Posted: {{ \Carbon\Carbon::parse($position['created_at'])->format('Y-m-d') }}</p>
                        <p class="m-0">Job Type: {{ $position['job_type'] }}</p>
                    </div>

                    <h5 class="mt-2">Job Description</h5>
                    <div class="px-3">
                        <p class="text-justify-custom">{{ $position['job_description'] }}</p>
                        <div class="text-center">
                            <a id="applyBtn" href="{{ route('pages.careers.form', ['uid' => $position['UID']]) }}" class="btn btn-theme-outline">Apply</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div id="activePosBody">
                    <div class="mt-2 qualifications">
                        <h5>Qualifications:</h5>
                        <ul>
                            @foreach ($position['qualifications'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-2 benefits">
                        <h5>Benefits:</h5>
                        <ul>
                            @foreach ($position['benefits'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @else
            <div class="custom-box-shadow p-3 rounded bg-white text-center py-5">
                <p class="lead text-muted">No position selected.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function getPosition(uid, userClicked = false) {
        if ($(window).width() < 992 && userClicked) {
            // Small device: redirect via form POST
            let form = $('<form>', {
                action: "{{ route('pages.careers.viewSm') }}",
                method: 'POST'
            });

            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}'
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'uid',
                value: uid
            }));

            $('body').append(form);
            form.submit();
        } else {
            // Large device: AJAX
            $.ajax({
                url: `/careers/${uid}`,
                type: 'GET',
                success: function(data) {
                    if (!data || !data.UID) {
                        $('#positionsSection').html(`
                            <div class="text-center py-5">
                                <p class="lead text-muted">No data available for this position.</p>
                            </div>
                        `);
                        return;
                    }

                    $('#positionsSection').html(`
                        <div class="custom-box-shadow p-3 rounded bg-white sticky-top" style="top: 125px">
                            <div class="activePosHead">
                                <h2>${data.pos_name}</h2>
                                <p class="lead">ID: ${data.UID}</p>
                                <h5 id="posQuantityIndicator" class="color-indicator" style="${data.pos_quantity === 'Multiple' ? '' : 'display: none;'}">
                                    *Hiring Multiple Candidates*
                                </h5>
                                <div class="d-flex justify-content-between w-100 p-0">
                                    <p class="m-0">Date Posted: ${data.date_posted}</p>
                                    <p class="m-0">Job Type: ${data.job_type}</p>
                                </div>
                                <h5 class="mt-2">Job Description</h5>
                                <div class="px-3">
                                    <p class="text-justify-custom">${data.job_description}</p>
                                    <div class="text-center">
                                        <a id="applyBtn" href="/careers-form/${data.UID}" class="btn btn-theme-outline">Apply</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div id="activePosBody">
                                <div class="mt-2 qualifications">
                                    <h5>Qualifications:</h5>
                                    <ul>${data.qualifications.map(item => `<li>${item}</li>`).join('')}</ul>
                                </div>
                                <div class="mt-2 benefits">
                                    <h5>Benefits:</h5>
                                    <ul>${data.benefits.map(item => `<li>${item}</li>`).join('')}</ul>
                                </div>
                            </div>
                        </div>
                    `);
                },
                error: function(xhr) {
                    $('#positionsSection').html(`
                        <div class="text-center py-5">
                            <p class="lead text-danger">Failed to fetch job data or no data available.</p>
                        </div>
                    `);
                    console.error(xhr.responseText);
                }
            });
        }
    }

    $(document).ready(function() {
        console.log(@json($position));
    });
</script>
@endsection
