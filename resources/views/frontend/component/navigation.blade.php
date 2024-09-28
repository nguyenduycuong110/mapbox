<div class="navigation">
    <ul class="uk-list uk-clearfix uk-navbar-nav main-menu">
        @if(isset($menu['main-menu']) &&count($menu['main-menu']))
            {!! $menu['main-menu'] !!}
        @endif
    </ul>
</div>