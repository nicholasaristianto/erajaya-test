@extends('layouts.app')

@section('content')
<div class="container py-1">
    <h2 class="mb-1 text-dark fw-bold">Dashboard Karyawan</h2>
    <p class="text-muted mb-4" style="font-size: 0.95rem;">
        Lihat jumlah karyawan per periode berdasarkan filter yang dipilih.
    </p>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form id="filter-form" class="row g-4 mb-4">
                <div class="col-md-3">
                    <label for="company_id" class="form-label">Perusahaan</label>
                    <select class="form-select filter" id="company_id">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="division_id" class="form-label">Divisi</label>
                    <select class="form-select filter" id="division_id">
                        <option value="">Semua Divisi</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="level_id" class="form-label">Level</label>
                    <select class="form-select filter" id="level_id">
                        <option value="">Semua Level</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="gender_id" class="form-label">Jenis Kelamin</label>
                    <select class="form-select filter" id="gender_id">
                        <option value="">Semua</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->id }}">{{ $gender->gender_name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="border-top pt-4">
                <canvas id="employeeChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart;
    const ctx = document.getElementById('employeeChart').getContext('2d');

    function fetchChartData() {
        const company_id  = $('#company_id').val();
        const division_id = $('#division_id').val();
        const level_id    = $('#level_id').val();
        const gender_id   = $('#gender_id').val();

        $.ajax({
            url: "{{ route('dashboard.data') }}",
            data: { company_id, division_id, level_id, gender_id },
            success: function(response) {
                const labels = response.map(item => item.period);
                const data = response.map(item => item.total);
                const colors = [
                    '#FF6384', 
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF', 
                    '#FF9F40', 
                    '#00A36C', 
                    '#8B0000', 
                    '#4169E1', 
                    '#B8860B', 
                    '#228B22', 
                    '#DA70D6',
                    '#FF1493', 
                    '#20B2AA',
                    '#00008B', 
                ];

                const dynamicColors = labels.map((_, i) => colors[i % colors.length] + '99'); 

                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = data;
                    chart.data.datasets[0].backgroundColor = dynamicColors;
                    chart.update();
                } else {
                    chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Karyawan',
                                data: data,
                                backgroundColor: dynamicColors,
                                borderColor: dynamicColors.map(color => color.replace('99', '')),
                                borderWidth: 1,
                                borderRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#f8f9fa',
                                    titleColor: '#212529',
                                    bodyColor: '#212529',
                                    borderColor: '#dee2e6',
                                    borderWidth: 1,
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                }
            }
        });
    }


    $(document).ready(function() {
        fetchChartData();
        $('.filter').change(fetchChartData);
    });
</script>
@endpush
