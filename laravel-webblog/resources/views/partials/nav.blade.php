<nav>
    <a href="{{ route('articles.index') }}" class="nav-button {{request()->routeIs('articles.index') ? 'active-nav' : 'inactive-nav' }}">
        Artikelen
    </a>
    <a href="{{ route('categories.index') }}" class="nav-button {{request()->routeIs('categories.index') ? 'active-nav' : 'inactive-nav' }}">
        Categorieën
    </a>
    <a href="{{ route('account.account') }}" class="nav-button {{request()->routeIs('account.*') ? 'active-nav' : 'inactive-nav' }}">
        {{Auth::user()->name ?? "Account"}}
    </a>
    @if(Auth::check())
        <form action="{{ route('login.logout') }}" id="logout-form" method="POST">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    @else
        <a href="{{ route('account.account') }}" class="nav-button {{request()->routeIs('login*') ? 'active-nav' : 'inactive-nav' }}">
            Login
        </a>
    @endif
</nav>
