
@if (session()->has('success'))
<script>
$(document).ready(function() {
    $.toast({
        heading: 'Success',
        text: '{{ session()->get('success') }}',
        showHideTransition: 'fade',
        icon: 'success',
        position : 'top-right'
    });
});
</script>
@endif
@if (session()->has('message'))
<script>
$(document).ready(function() {
    $.toast({
        heading: 'Success',
        text: '{{ session()->get('message') }}',
        showHideTransition: 'fade',
        icon: 'success',
        position : 'top-right'
    });
});
</script>
@endif
@if (session()->has('warning'))
<script>
$(document).ready(function() {
    $.toast({
        heading: 'Message',
        text: '{{ session()->get('warning') }}',
        showHideTransition: 'fade',
        icon: 'warning',
        position : 'top-right'
    });
});
</script>
@endif
@if (session()->has('error'))
<script>
$(document).ready(function() {
    $.toast({
        heading: 'Error',
        text: '{{ session()->get('error') }}',
        showHideTransition: 'fade',
        icon: 'error',
        position : 'top-right'
    });
});
</script>
@endif

@if($errors->any())
@foreach ($errors->all() as $error)

@endforeach
@php
    $data = 'Error Accurs';
@endphp
<script>
$(document).ready(function() {
    $.toast({
        heading: 'Error',
        text:'{{ $error }}' ,
        showHideTransition: 'fade',
        icon: 'error',
        position : 'top-right',
        hideAfter: 5000,
    });
});
</script>
@endif
<script>
    $(document).ready(function() {
        $("form").submit(function(event) {
            $(this).find("button[type=submit]").prop("disabled", true);
        });
 });
</script>


