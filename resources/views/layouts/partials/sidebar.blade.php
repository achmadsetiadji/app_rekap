<nav class="sidebar sidebar-offcanvas overflow-auto" id="sidebar">
    <ul class="nav">
        @hasrole('superadmin')
            @include('layouts.partials.menus.superadmin')
        @endhasrole
    </ul>
</nav>
