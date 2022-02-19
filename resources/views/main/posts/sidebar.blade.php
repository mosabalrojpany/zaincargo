

<!--    blog sidebar section start   -->
<div class="sidebar">

    <div class="blog-sidebar-widgets">
        <div class="searchbar-form-section">
            <form action="{{ url('news') }}">
                <div class="searchbar">
                    <input name="search" type="text" value="{{ Request::get('search') }}" placeholder="بحث" maxlength="32" required>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="blog-sidebar-widgets category-widget">
        <div class="category-lists">
            <h4>التصنيفات</h4>
            <ul>
                @foreach($tags as $tag)
                    <li class="single-category">
                        <a href="{{ url("news?tag=$tag->name") }}">
                            {{ $tag->name }}
                        </a> 
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    
    <div class="blog-sidebar-widgets post-widget">
        <div class="popular-posts-lists">
            <h4>أخر الأخبار</h4>

            @foreach($posts as $post)
                <div class="single-popular-post">
                    
                    <div class="popular-post-img-wrapper">
                        <img src="{{ $post->getImageAvatar() }}" alt="{{ $post->title }}">
                    </div>
                    
                    <div class="popular-post-txt">
                        <h5 class="popular-post-title" title="{{ $post->title }}">
                            <a href="{{ url('news',$post->id) }}">{{ $post->getShortTitle() }}</a>
                        </h5>
                        <small class="time mr-1">
                            <i class="far fa-clock" style="vertical-align: middle"></i>
                            <bdi>{{ $post->getDate() }}</bdi>
                        </small>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>
<!--    blog sidebar section end   -->
