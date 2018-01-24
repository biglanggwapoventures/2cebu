<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>2Cebu</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.growl.css') }}">
        @stack('css')
    </head>
    <body>
        @yield('content')
        @stack('modals')
        <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.growl.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.like').click(function (e) {
                    e.preventDefault();
                    var $this  = $(this),
                        url = "{{ route('user.attraction.like') }}"
                    $.post(url, {
                        attraction_id: $this.data('pk'),
                    })
                    .done(function (res) {
                        if(res['result']){
                            var countEl = $this.find('.count'),
                             currentCount = parseInt(countEl.text());
                            res['change'] === '+' ? currentCount++ : currentCount--;

                            $('.count[data-pk='+$this.data('pk')+']').text(currentCount)
                                .closest('.like')
                                .toggleClass('text-dark');
                        }else{

                        }
                    })
                })
            });
        </script>
        @if(session('growl'))
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $.growl.notice({ message: "{{ session('growl') }}", location: 'br', 'title': '', size: 'large' });
                });
            </script>
        @endif
        @stack('js')
    </body>
</html>
