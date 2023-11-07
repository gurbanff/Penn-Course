<div class="app-sidebar">
            <div class="logo">
                <a href="index.html" class="logo-icon"><span class="logo-text">Neptune</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <img src="../assets/images/avatars/avatar.png">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text">Chloe<br><span class="user-state-info">open</span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Apps
                    </li>
                    <li class="active-page">
                        <a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">
                            <i class="material-icons-two-tone">dashboard</i>Dashboard
                        </a>
                    </li>

                    <li class="{{ Route::is("article.index") || Route::is("article.create") ? "open" : "" }}">
                        <a href="#">
                            <i style="color: red;" class="material-icons">tune</i>
                            Makale Yonetimi
                            <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route("article.create") }}" class="{{ Route::is("article.create") ? "active" : "" }}">Makale Ekleme</a>
                            </li>
                            <li>
                                <a href="{{ route("article.index") }}" class="{{ Route::is("article.index") ? "active" : "" }}">Makale Listesi</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Route::is("category.index") || Route::is("category.create") ? "open" : "" }}">
                        <a href="#">
                            <i style="color: red;" class="material-icons">tune</i>
                            Kategori Yonetimi
                            <i class="material-icons has-sub-menu">keyboard_arrow_right</i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route("category.create") }}" class="{{ Route::is("category.create") ? "active" : "" }}">Kategori Ekleme</a>
                            </li>
                            <li>
                                <a href="{{ route("category.index") }}" class="{{ Route::is("category.index") ? "active" : "" }}">Kategori Listesi</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
