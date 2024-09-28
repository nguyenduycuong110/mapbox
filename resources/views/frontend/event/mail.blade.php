<div class="notification">
    <div class="panel-head">
        <h2 class="heading-1">
            <span>Thông báo sự kiện</span>
        </h2>
    </div>
    <div class="panel-body">
        <p>Xin chào</p>
        <p>Sự kiện {{ $event->name }} đã được diễn ra</p>
        <p>
            Đường link sự kiện :
            <a href="http://127.0.0.1:8000/event/{{ $event->id }}/canonical.html">{{ $event->name }}</a> 
        </p>
    </div>
</div>