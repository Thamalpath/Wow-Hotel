@include('layouts.partials.header')

<!--start navbar-->
<header class="top-header">
    @include('layouts.partials.navbar')
</header>
<!--end top navbar-->

<!--start sidebar-->
@include('layouts.partials.sidebar')
<!--end sidebar-->

<main>
    @yield('content')
</main>

@include('layouts.partials.footer')
