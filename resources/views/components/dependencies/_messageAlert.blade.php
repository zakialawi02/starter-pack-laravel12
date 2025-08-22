@push('javascript')
    @if (session('success'))
        <script>
            MyZkToast.success("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            MyZkToast.error("{{ session('error') }}")
        </script>
    @endif
    @if (session('message'))
        <script>
            MyZkToast.error("{{ session('message') }}")
        </script>
    @endif
@endpush
