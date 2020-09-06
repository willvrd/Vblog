@can("vblog.posts.index")
<li class="nav-item dropdown">

    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ __('vblog::common.module') }}
    </a>

    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

        @can("vblog.posts.index")
        <a class="dropdown-item" href="{{route(app()->getLocale().'.admin.vblog.posts.index')}}">
            {{ __('vblog::posts.title.posts') }}
        </a>
        @endcan

        @can("vblog.categories.index")
        <a class="dropdown-item" href="{{route(app()->getLocale().'.admin.vblog.categories.index')}}">
            {{ __('vblog::categories.title.categories') }}
        </a>
        @endcan

    </div>

</li>
@endcan
