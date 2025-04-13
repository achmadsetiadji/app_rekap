<div class="bottom-nav shadow-lg">
    <div class="container">
        <div class="row gx-0 box-wrapper ms-auto me-auto">
            <div class="col {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-box" href="{{ route('front.index') }}">
                    <div class="nav-box-ico">
                        <span class="icons icon-home"></span>
                    </div>
                    <span class="nav-box-title">Home</span>
                </a>
            </div>
            <div class="col {{ Request::is('category') ? 'active' : '' }}">
                <a class="nav-box" href="{{ route('front.category') }}">
                    <div class="nav-box-ico">
                        <span class="icons icon-category"></span>
                    </div>
                    <span class="nav-box-title">Category</span>
                </a>
            </div>
            <div class="col {{ Request::is('mental_game') ? 'active' : '' }}">
                <a class="nav-box" href="{{ route('front.mental_game') }}">
                    <div class="nav-box-ico">
                        <span class="icons icon-games"></span>
                    </div>
                    <span class="nav-box-title">Games</span>
                </a>
            </div>
            <div class="col {{ Request::is('profile') ? 'active' : '' }}">
                <a class="nav-box" href="{{ route('front.profile') }}">
                    <div class="nav-box-ico">
                        <span class="icons icon-profile"></span>
                    </div>
                    <span class="nav-box-title">Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>
