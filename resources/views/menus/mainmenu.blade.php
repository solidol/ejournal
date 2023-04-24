@if (Auth::user())

@if (Auth::user()->isTeacher())
@include('menus.main_teacher')
@endif
@if (Auth::user()->isStudent())
@include('menus.main_student')
@endif

@else
@include('menus.main_guest')
@endif