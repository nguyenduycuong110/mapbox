<div class="notification">
    <div class="panel-head">
        <h2 class="heading-1">
            <span>Thông báo bài viết mới</span>
        </h2>
    </div>
    <div class="panel-body">
        <p>Xin chào</p>
        <p>Bài viết {{ $post->name }} vừa được đăng</p>
        <p>
            Đường link bài viết :
            <a href="http://127.0.0.1:8000/{{ $post->canonical }}.html">{{ $post->name }}</a> 
        </p>
    </div>
</div>
