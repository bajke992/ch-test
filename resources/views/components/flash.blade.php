<script>

    function flashMessage(message) {
        toastr.info(message);
    }
    function flashError(message) {
        toastr.error(message);
    }
    function flashWarning(message) {
        toastr.warning(message);
    }

    @if(Session::has('message'))
        flashMessage("{!! Session::get('message') !!}");
    @endif

    @if(Session::has('error'))
        flashError("{!! Session::get('error') !!}");
    @endif

    @if(Session::has('warning'))
        flashWarning("{!! Session::get('warning') !!}");
    @endif
</script>