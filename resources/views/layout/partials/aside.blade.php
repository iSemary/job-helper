<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar ps-container ps-theme-default ps-active-y" data-sidebarbg="skin6"
        data-ps-id="b951f9b1-17a5-7a3e-561d-0110467b9ddb">
        <nav class="sidebar-nav pt-0">
            <ul id="sidebarnav" class="in">
                <li class="sidebar-item {{ Request::url() == route('panel.home') ? 'selected' : '' }}">
                    <a class="sidebar-link sidebar-link page-switcher" data-switch-target="{{ route('panel.home') }}"
                        href="#" aria-expanded="false">
                        <span class="hide-menu"><i class="fas fa-tachometer-alt"></i> Dashboard</span>
                    </a>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Applications</span></li>
                <li class="sidebar-item {{ Request::url() == route('panel.email.apply') ? 'selected' : '' }}">
                    <a class="sidebar-link page-switcher" data-switch-target="{{ route('panel.email.apply') }}"
                        href="#" aria-expanded="false">
                        <span class="hide-menu">
                            <i class="fas fa-paper-plane"></i> Apply
                        </span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::url() == route('panel.kanban') ? 'selected' : '' }}">
                    <a class="sidebar-link page-switcher" data-switch-target="{{ route('panel.kanban') }}"
                        href="#" aria-expanded="false">
                        <span class="hide-menu">
                            <i class="fas fa-columns"></i> Kanban Board
                        </span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::url() == route('panel.companies.index') ? 'selected' : '' }}">
                    <a class="sidebar-link page-switcher" data-switch-target="{{ route('panel.companies.index') }}"
                        href="#" aria-expanded="false">
                        <span class="hide-menu">
                            <i class="fas fa-database"></i> Companies Dataset
                        </span>
                    </a>
                </li>
                <li class="nav-small-cap"><span class="hide-menu">Generators</span></li>
                <li class="sidebar-item {{ Request::url() == route('panel.generator.cover-letter') ? 'selected' : '' }}">
                    <a href="#" data-switch-target="{{ route('panel.generator.cover-letter') }}"
                        class="sidebar-link page-switcher">
                        <span class="hide-menu"><i class="fas fa-paperclip"></i> Cover Letter </span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::url() == route('panel.generator.motivation-message') ? 'selected' : '' }}">
                    <a href="#" data-switch-target="{{ route('panel.generator.motivation-message') }}"
                        class="sidebar-link page-switcher">
                        <span class="hide-menu"><i class="fas fa-envelope-open-text"></i> Motivation Message </span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::url() == route('panel.generator.reminder-message') ? 'selected' : '' }}">
                    <a href="#" data-switch-target="{{ route('panel.generator.reminder-message') }}"
                        class="sidebar-link page-switcher">
                        <span class="hide-menu"><i class="fas fa-bell"></i> Reminder Message </span>
                    </a>
                </li>
                <li class="nav-small-cap"><span class="hide-menu">Configuration</span></li>
                <li class="sidebar-item {{ Request::url() == route('panel.user.profile.edit') ? 'selected' : '' }}">
                    <a href="#" data-switch-target="{{ route('panel.user.profile.edit') }}"
                        class="sidebar-link page-switcher">
                        <span class="hide-menu">
                            <i class="fas fa-user-cog"></i> Profile
                        </span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::url() == route('panel.user.email-credentials.edit') ? 'selected' : '' }}">
                    <a href="#" data-switch-target="{{ route('panel.user.email-credentials.edit') }}"
                        class="sidebar-link page-switcher">
                        <span class="hide-menu">
                            <i class="fas fa-fingerprint"></i> Email Credentials
                        </span>
                    </a>
                </li>
                <li class="list-divider"></li>
            </ul>
        </nav>
    </div>
</aside>
