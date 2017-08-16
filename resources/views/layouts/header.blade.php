<header>
    <div class="container">
        <div class="navbar row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('frontend.index') }}"><img src="{!! Image::url(((isset($banner) && $banner)?'uploads/'.$banner:''), 235, 75, array('crop')) !!}" alt="{{ $company['title'] }}" /></a>
            </div>
            <div class="navbar-collapse collapse">
                {!! create_list($categorys) !!}
                <form class="navbar-form navbar-right">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm bài viết ...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>