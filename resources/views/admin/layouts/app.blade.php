<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventory System</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item" id="toggleMenuIcon">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ auth()->user()->avatar }}">
                        </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link to="/admin/dashboard" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>

                         <li class="nav-item">
                            <router-link
                                to="/admin/items/list"
                                active-class="active"
                                class="nav-link"
                                :class="$route.path.startsWith('/admin/items/list') ||
                                         $route.path.startsWith('/admin/items/create')  ? 'active' : ''">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Items List
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/items/issue/list" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Issue Items
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/items/history" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    History
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/users" active-class="active" class="nav-link"
                            :class="
                                         $route.path.startsWith('/admin/users/create')  ? 'active' : ''">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    User List
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/users/update" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-user-edit"></i>
                                <p>
                                    Profile
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="nav-link">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" >
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        Log out
                                    </p>
                                </a>
                            </form>
                         </form>
                    
                        </li>
                    </ul>
                </nav>
             </div>
            </aside>

        <div class="content-wrapper">
            <router-view></router-view>
        </div>
    </div>
        <footer class="main-footer text-center">
            <strong class="">Copyright &copy; sample  <a href="#"> {{ auth()->user()->name }}</a>.</strong> All rights reserved.
        </footer>
    </div>
<script>
      document.addEventListener('DOMContentLoaded', () => {
            const toggleMenuIcon = document.getElementById('toggleMenuIcon');
            const body = document.querySelector('body');

            toggleMenuIcon.addEventListener('click', () => {
                if (body.classList.contains('sidebar-collapse')) {
                    localStorage.setItem('sidebarState', 'expanded');
                } else {
                    localStorage.setItem('sidebarState', 'collapsed');
                }
            });

            const sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'collapsed') {
                body.classList.add('sidebar-collapse');
            }
        });
</script>
</body>
</html>
