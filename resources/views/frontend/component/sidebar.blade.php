<div class="sidebar">
    <div class="wrapper">
        <div class="info">
            @if(isset($userAuth))
                @php 
                    $image = $userAuth->image;
                @endphp
                <a href="" class="image img-cover">
                    <img src="{{ $userAuth->image }}" alt="">
                </a>
                <div class="text">
                    <p class="name">{{ $userAuth->name }}</p>
                    <a href="" class="update-profile">Cập nhật Profile</a>
                    <a href="{{ route('user.logout')  }}" class="logout">
                        <img src="/userfiles/image/Sign_out_circle_light.png" alt="">
                        Đăng xuất
                    </a>
                </div>
            @endif
        </div>
        <div class="location">
            <div class="wrapper">
                @if(isset($cities))
                    <ul class="list-location">
                        @foreach($cities as $item)
                            <li>
                                @php
                                    $canonical = 'location/'.Str::slug($item['name']) . '/' . (int)$item['id'];
                                @endphp
                                <a href="{{ write_url($canonical) }}" class="location-item">
                                    <img src="/userfiles/image/573fa3aec6e9f7e3de0a2d48bd51a349.png" alt="">
                                    {{ $item['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="copyright">
            <div class="wrapper">
                <p>{{ $system['homepage_copyright'] }}</p>
            </div>
        </div>
    </div>
</div>