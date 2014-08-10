<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('dashboard') }}">SMS Manager</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li {{ $active_menu_item == 'dashboard' ? ' class="active"' : '' }}><a href="{{ URL::route('dashboard') }}">Dashboard</a></li>
                <li {{ $active_menu_item == 'sms' ? ' class="active"' : '' }}><a href="{{ URL::route('new_sms') }}">SMS</a></li>
                <li class="dropdown  {{ $active_menu_item_dropdown == 'dropdown' ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Phonebook <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-header">STUDENTS</li>
                        <li {{ $active_menu_item == 'search_students' ? ' class="active"' : '' }}><a href="{{ URL::route('search_students') }}">Search</a></li>
                        <li {{ $active_menu_item == 'department' ? ' class="active"' : '' }}><a href="{{ URL::route('search_departments') }}">Department &amp; Level</a></li>
                        <li {{ $active_menu_item == 'states' ? ' class="active"' : '' }}><a href="{{ URL::route('search_states') }}">State of Origin</a></li>
                        <li {{ $active_menu_item == 'gender' ? ' class="active"' : '' }}><a href="{{ URL::route('search_genders') }}">Gender</a></li>

                        <li class="divider"></li>

                        <li class="dropdown-header">STAFF</li>
                        <li {{ $active_menu_item == 'new_staff' ? ' class="active"' : '' }}><a href="{{ URL::route('new_staff') }}">New Staff</a></li>
                        <li {{ $active_menu_item == 'search_staff' ? ' class="active"' : '' }}><a href="{{ URL::route('search_staff') }}">Search</a></li>

                        </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <p class="navbar-text visible-lg">Signed in as <span class="text-danger">{{ $user->firstname . ' ' . $user->lastname }}</span></p>
                <li class="active"><a href="{{ URL::route('logout') }}">Logout <span class="glyphicon glyphicon-off"></span></a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>