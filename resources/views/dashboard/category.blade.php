@extends('layouts.app')

@section('content')
    <main class="main-wrapper min-vh-100">
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                @foreach (['MP' => 'Meal Plan', 'RT' => 'Room Types', 'RC' => 'Room Category', 'GF' => 'Guest From', 'EX' => 'Expenses List', 'DEP' => 'Department List'] as $code => $title)
                                    <div class="col-xl-4">
                                        <h6 class="mb-0 text-uppercase">{{ $title }}</h6>
                                        <hr>
                                        <div class="card">
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('categories.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="cat_code" value="{{ $code }}">
                                                    <div class="col-md-12 mb-3">
                                                        <input type="text" class="form-control" name="input_name"
                                                            placeholder="{{ $title }}"
                                                            oninput="this.value = this.value.toUpperCase()">
                                                    </div>

                                                    <table class="table mt-4 mb-0 table-striped">
                                                        <tbody style="display: block; max-height: 320px; overflow-y: auto;">
                                                            @forelse($categories[$code] as $category)
                                                                <tr
                                                                    style="display: table; width: 100%; table-layout: fixed;">
                                                                    <td>{{ $category->cat_name }}</td>
                                                                    <td>
                                                                        <div class="d-flex justify-content-end me-4">
                                                                            <form
                                                                                action="{{ route('categories.destroy', $category->id) }}"
                                                                                method="POST" class="delete-form">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-danger delete-btn">X</button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr
                                                                    style="display: table; width: 100%; table-layout: fixed;">
                                                                    <td colspan="2">No data found.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle enter key press for all category input fields
                const categoryInputs = document.querySelectorAll('input[name="input_name"]');

                categoryInputs.forEach(input => {
                    input.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.closest('form').submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
