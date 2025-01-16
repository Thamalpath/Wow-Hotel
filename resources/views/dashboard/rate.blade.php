@extends('layouts.app')

@section('content')
    <main class="main-wrapper min-vh-100">
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <form method="POST" action="{{ route('rate.update') }}" class="row g-3">
                                                @csrf
                                                <div class="col-md-6">
                                                    <label for="us_rate" class="form-label fw-bold">US $ Rate</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('us_rate') is-invalid @enderror"
                                                        name="us_rate" value="{{ $rate->us_rate ?? '' }}">
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label for="euro_rate" class="form-label fw-bold">Euro Rate</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('euro_rate') is-invalid @enderror"
                                                        name="euro_rate" value="{{ $rate->euro_rate ?? '' }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="svat" class="form-label fw-bold">SVAT %</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('svat') is-invalid @enderror"
                                                        name="svat" value="{{ $rate->svat ?? '' }}">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="vat1" class="form-label fw-bold">Other VAT %</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('vat1') is-invalid @enderror"
                                                        name="vat1" value="{{ $rate->vat1 ?? '' }}">
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="service_charge" class="form-label fw-bold">Service
                                                        Charge</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('service_charge') is-invalid @enderror"
                                                        name="service_charge" value="{{ $rate->service_charge ?? '' }}">
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                        <button type="submit"
                                                            class="btn btn-grd btn-grd-info px-5 fw-bold">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
