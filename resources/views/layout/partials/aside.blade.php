<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar ps-container ps-theme-default ps-active-y" data-sidebarbg="skin6"
        data-ps-id="b951f9b1-17a5-7a3e-561d-0110467b9ddb">
        <nav class="sidebar-nav pt-0">
            <ul id="sidebarnav" class="in">
                <li class="sidebar-item {{ Request::url() == route('panel.home') ? 'selected' : '' }}">
                    <a class="sidebar-link sidebar-link page-switcher"
                        data-switch-target="{{ route('panel.home') }}" href="#" aria-expanded="false">
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Applications</span></li>
                <li class="sidebar-item {{ Request::url() == route('panel.email.apply') ? 'selected' : '' }}">
                    <a class="sidebar-link page-switcher" data-switch-target="{{ route('panel.email.apply') }}" href="#" aria-expanded="false">
                        <span class="hide-menu">
                            <i class="fas fa-paper-plane"></i> Apply
                        </span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::url() == route('panel.kanban') ? 'selected' : '' }}">
                    <a class="sidebar-link page-switcher" data-switch-target="{{ route('panel.kanban') }}" href="#" aria-expanded="false">
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
                <li class="sidebar-item {{ str_contains(Request::url(), 'generator') ? 'selected' : '' }} multiple">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="hide-menu"><i class="fas fa-cogs"></i> Generators</span>
                    </a>
                    <ul aria-expanded="false"
                        class="collapse first-level base-level-line  {{ str_contains(Request::url(), 'generator') ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a href="#" data-switch-target="{{ route('panel.generator.cover-letter') }}"
                                class="sidebar-link page-switcher {{ Request::url() == route('panel.generator.cover-letter') ? 'active' : '' }}">
                                <span class="hide-menu"><i class="fas fa-paperclip"></i> Cover Letter </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" data-switch-target="{{ route('panel.generator.motivation-message') }}"
                                class="sidebar-link page-switcher {{ Request::url() == route('panel.generator.motivation-message') ? 'active' : '' }}">
                                <span class="hide-menu"><i class="fas fa-envelope-open-text"></i> Motivation Message </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
            </ul>
        </nav>
        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 552px; right: 3px;">
            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 302px;"></div>
        </div>
    </div>
</aside>
