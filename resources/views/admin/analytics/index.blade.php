@extends('layouts.admin')
@section('title','Analytics')
@section('heading','Analytics')
@push('styles')<link rel="stylesheet" href="{{ asset('admin-assets/analytics/analytics.css') }}">@endpush
@section('content')
<div class="panel"><div class="panel-title"><h2>Performa harian</h2><span>{{ $from->format('d M Y') }} – {{ $to->format('d M Y') }}</span></div><div class="chart"><div class="bars">
@php($max = max(1, (int) $dailyViews->max(), (int) $dailyLeads->max()))
@for($date = $from->copy()->startOfDay(); $date->lte($to); $date->addDay())
    @php($key = $date->format('Y-m-d'))
    @php($views = (int) ($dailyViews[$key] ?? 0))
    @php($leads = (int) ($dailyLeads[$key] ?? 0))
    <div class="bar-col"><div class="bar-wrap"><i style="height:{{ ($views / $max) * 100 }}%" title="Views: {{ $views }}"></i><b style="height:{{ ($leads / $max) * 100 }}%" title="Leads: {{ $leads }}"></b></div><small>{{ $date->format('d/m') }}</small></div>
@endfor
</div></div><div class="legend"><span><i></i> Views</span><span><b></b> Leads</span></div></div>
@endsection
