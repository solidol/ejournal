@if (Auth::user())

    @if (Auth::user()->isTeacher())
        @if (Session::get('localrole')=='curator')
            @include('menus.main_curator')
        @elseif (Session::get('localrole')=='admin')
            @include('menus.main_admin')
        @else
            @include('menus.main_teacher')
        @endif
    @endif

    @if (Auth::user()->isStudent())
        @include('menus.main_student')
    @endif

@else
    @include('menus.main_guest')
@endif