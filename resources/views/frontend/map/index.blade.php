@extends('frontend.homepage.layout')
@section('content')
    <div class="location-container">
        @include('frontend.component.sidebar',['cities' => $list_city])
        <div 
            id="mapLocation"
            data-zoom = "{{ $system['location_zoom'] }}"
            data-lat = "{{ $city->lat }}"
            data-long = "{{ $city->long }}"
        >
        </div>
        <div class="contact-fixed">
            <a href="">
                <svg width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.76716 3.67539C9.59001 2.58352 11.6749 2.00652 13.7997 2.00586C15.5676 2.00482 17.3129 2.40282 18.9056 3.17019C20.4982 3.93757 21.8972 5.05453 22.998 6.43781C24.0989 7.82109 24.8734 9.43501 25.2637 11.1593C25.654 12.8835 25.6501 14.6736 25.2523 16.3962C24.8544 18.1187 24.073 19.7292 22.966 21.1077C21.8591 22.4862 20.4554 23.597 18.8594 24.3574C17.2634 25.1179 15.5164 25.5083 13.7485 25.4995C12.273 25.4922 10.8148 25.207 9.44931 24.6616L2.26689 25.8576C1.89492 25.9195 1.59087 25.5631 1.71066 25.2055L3.59851 19.5708C2.6836 17.9661 2.1581 16.1645 2.06982 14.3118C1.96869 12.1894 2.44515 10.0793 3.44845 8.20619C4.45175 6.33312 5.94431 4.76726 7.76716 3.67539Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.8182 15.4293L19.5343 17.1454C19.7915 17.4026 19.7915 17.8196 19.5343 18.0768C18.1439 19.4672 15.9426 19.6237 14.3696 18.4438L13.5695 17.8438C12.0863 16.7314 10.7686 15.4137 9.65619 13.9305L9.05617 13.1305C7.87635 11.5574 8.03279 9.3561 9.42322 7.96567C9.6804 7.70849 10.0974 7.70849 10.3546 7.96567L12.0707 9.68178C12.4612 10.0723 12.4612 10.7055 12.0707 11.096L11.5296 11.6371C11.4124 11.7543 11.3833 11.9333 11.4575 12.0816C12.3145 13.7957 13.7043 15.1855 15.4184 16.0425C15.5667 16.1167 15.7457 16.0876 15.8629 15.9704L16.404 15.4293C16.7945 15.0388 17.4277 15.0388 17.8182 15.4293Z" stroke="white"/>
                </svg>
                @if(isset($city->name))
                    <p class="phone">Đặt phòng : {{ $city->phone }}</p>
                @endif
            </a>
        </div>
        @can('modules', 'fast.update')
            <div class="button-premission active">
                <button class="btn-per">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5 7.5L5.92819 14.0718C5.71566 14.2843 5.60939 14.3906 5.53953 14.5212C5.46966 14.6517 5.44019 14.7991 5.38124 15.0938L4.64709 18.7646C4.58057 19.0972 4.5473 19.2635 4.64191 19.3581C4.73652 19.4527 4.90283 19.4194 5.23544 19.3529L8.90621 18.6188C9.20093 18.5598 9.3483 18.5303 9.47885 18.4605C9.60939 18.3906 9.71566 18.2843 9.92819 18.0718L16.5 11.5L12.5 7.5Z" fill="#7E869E" fill-opacity="0.25"/>
                        <path d="M5.95396 19.38L5.95397 19.38L5.9801 19.3734L5.98012 19.3734L8.60809 18.7164C8.62428 18.7124 8.64043 18.7084 8.65654 18.7044C8.87531 18.65 9.08562 18.5978 9.27707 18.4894C9.46852 18.381 9.62153 18.2275 9.7807 18.0679C9.79242 18.0561 9.80418 18.0444 9.81598 18.0325L17.0101 10.8385L17.0101 10.8385L17.0369 10.8117C17.3472 10.5014 17.6215 10.2272 17.8128 9.97638C18.0202 9.70457 18.1858 9.39104 18.1858 9C18.1858 8.60896 18.0202 8.29543 17.8128 8.02361C17.6215 7.77285 17.3472 7.49863 17.0369 7.18835L17.01 7.16152L16.8385 6.98995L16.8117 6.96314C16.5014 6.6528 16.2272 6.37853 15.9764 6.1872C15.7046 5.97981 15.391 5.81421 15 5.81421C14.609 5.81421 14.2954 5.97981 14.0236 6.1872C13.7729 6.37853 13.4986 6.65278 13.1884 6.96311L13.1615 6.98995L5.96745 14.184C5.95565 14.1958 5.94386 14.2076 5.93211 14.2193C5.77249 14.3785 5.61904 14.5315 5.51064 14.7229C5.40225 14.9144 5.34999 15.1247 5.29562 15.3435C5.29162 15.3596 5.28761 15.3757 5.28356 15.3919L4.62003 18.046C4.61762 18.0557 4.61518 18.0654 4.61272 18.0752C4.57411 18.2293 4.53044 18.4035 4.51593 18.5518C4.49978 18.7169 4.50127 19.0162 4.74255 19.2574C4.98383 19.4987 5.28307 19.5002 5.44819 19.4841C5.59646 19.4696 5.77072 19.4259 5.92479 19.3873C5.9346 19.3848 5.94433 19.3824 5.95396 19.38Z" stroke="white" stroke-width="1.2"/>
                        <path d="M12.5 7.5L16.5 11.5" stroke="white" stroke-width="1.2"/>
                    </svg>
                </button>
            </div>
        @endcan
        <div class="popup-content">
            <div class="filter-close">
                <i class="fi fi-rs-cross"></i>
            </div>
            <div class="wrapper">
                @if(isset($homeStay))
                <ul class="list-homestay">
                        @foreach ($homeStay as $item)
                            <li class="homestay-item">
                                <div class="thumb">
                                    <a href="" class="image img-cover mb10">
                                            <img src="{{ $item['image'] }}" alt="">
                                    </a>
                                    <p class="status">
                                        <span style="border: 2px solid {{ $item['code'] }}; color:{{ $item['code'] }};">{{ $item['description'] }}</span>
                                    </p>
                                </div>
                                <div class="info">
                                    <div class="upper">
                                        <div class="text">
                                            <div class="bt-room">
                                                <p class="name">{{ $item['name'] }}</p>
                                                <div class="form-ip">
                                                    <div class="ip-guest">
                                                        <label for="">Số khách</label>
                                                        <div class="quantitybox uk-flex uk-flex-middle">
                                                            <div class="minus quantity-button">-</div>
                                                            <input type="text" name="" value="1" class="quantity-text">
                                                            <div class="plus quantity-button">+</div>
                                                        </div>
                                                    </div>
                                                    <div class="ip-price">
                                                        <label for="">Giá</label>
                                                        <input type="number" id="quantity_price" value="1" min="0" max="5000000" step="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="crm">
                                            <div class="total-customer">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.07677 5.92307C5.65215 5.92307 6.53831 5.03692 6.53831 3.46154C6.53831 1.88615 5.65215 1 4.07677 1C2.50139 1 1.61523 1.88615 1.61523 3.46154C1.61523 5.03692 2.50139 5.92307 4.07677 5.92307Z" fill="white" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M13.9232 5.92307C15.4986 5.92307 16.3847 5.03692 16.3847 3.46154C16.3847 1.88615 15.4986 1 13.9232 1C12.3478 1 11.4617 1.88615 11.4617 3.46154C11.4617 5.03692 12.3478 5.92307 13.9232 5.92307Z" fill="white" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M4.07692 17.0001C1 17.0001 1 12.2001 1 8.38468C3.45768 7.64416 4.80285 7.67437 7.15384 8.38468C7.15384 12.2001 7.15384 17.0001 4.07692 17.0001Z" fill="#D7E0FF" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M13.9231 8.38456C10.8462 8.38456 10.8462 12.7049 10.8462 16.5202C13.2496 17.1225 14.5968 17.1356 17 16.5202C17 12.7049 17 8.38456 13.9231 8.38456Z" fill="#D7E0FF" stroke="#A6A6A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <p>{{ $item['current_guests'] }} khách</p>
                                            </div>
                                            <div class="status">
                                                @if(isset($colors))
                                                    @foreach($colors as $color)
                                                        <a 
                                                            href="" 
                                                            class="st {{ $item['color_id'] == $color['id'] ? 'active' : '' }}" 
                                                            data-color="{{ $color['id'] }}"
                                                            style="background: {{ $color['code'] }}"
                                                        >
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lower">
                                        <a href="#modal-{{ $item['id'] }}" class="btn-open" uk-toggle>
                                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M19.0755 10.8302C19.0755 10.8302 16.0566 16.6415 10.7736 16.6415C5.49055 16.6415 2.47168 10.8302 2.47168 10.8302C2.47168 10.8302 5.49055 5.01887 10.7736 5.01887C13.1627 5.01887 15.0888 6.20738 16.4821 7.50943M8.283 10.8302C8.283 12.2057 9.39806 13.3208 10.7736 13.3208C12.1491 13.3208 13.2641 12.2057 13.2641 10.8302C13.2641 9.45469 12.1491 8.33962 10.7736 8.33962" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Open
                                        </a>
                                        <a href="" class="btn-reset">
                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.0345 7.14146C10.6965 8.09923 10.0826 8.93552 9.27004 9.54492C8.45751 10.1543 7.48277 10.5096 6.46866 10.5659C5.53123 10.566 4.61646 10.2776 3.84861 9.73987C3.08076 9.2021 2.49705 8.44102 2.17676 7.55999" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M1.90283 4.85856C2.54205 3.10831 4.50537 1.43417 6.46869 1.43417C7.41069 1.43681 8.32882 1.73076 9.0972 2.27571C9.86558 2.82066 10.4466 3.58994 10.7606 4.47807" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M11.5671 8.81903C11.4214 8.12972 11.3049 7.76267 11.0356 7.1447C10.3754 7.28118 10.0084 7.39775 9.36123 7.67627" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M1.50293 3.15481C1.59731 3.85302 1.68632 4.22768 1.90915 4.86389C2.57759 4.77662 2.95222 4.68754 3.61823 4.45766" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Reset
                                        </a>
                                        <a href="" class="btn-delete">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.679199 3.46774H11.0566" stroke="white" stroke-width="1.24528" stroke-linecap="round"/>
                                                <path d="M9.59593 3.46772H2.13617L2.08278 4.43294C1.9805 6.28226 2.06741 8.13719 2.34216 9.96885C2.46197 10.7676 3.14811 11.3585 3.95579 11.3585H7.77632C8.58399 11.3585 9.27014 10.7676 9.38995 9.96885C9.6647 8.1372 9.75161 6.28226 9.64932 4.43294L9.59593 3.46772Z" fill="#717171"/>
                                                <path d="M9.59593 3.46772H2.13617L2.08278 4.43294C1.9805 6.28226 2.06741 8.13719 2.34216 9.96885C2.46197 10.7676 3.14811 11.3585 3.95579 11.3585H7.77632C8.58399 11.3585 9.27014 10.7676 9.38995 9.96885C9.6647 8.1372 9.75161 6.28226 9.64932 4.43294L9.59593 3.46772Z" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M3.79419 3.46772V3.05329C3.79419 2.50372 4.01251 1.97666 4.40111 1.58805C4.78971 1.19945 5.31678 0.981133 5.86635 0.981133C6.41592 0.981133 6.94298 1.19945 7.33158 1.58805C7.72019 1.97666 7.9385 2.50372 7.9385 3.05329V3.46772" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4.6228 5.68719V9.12242" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M7.10962 5.68719V9.12242" stroke="white" stroke-width="1.24528" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <div id="modal-{{ $item['id'] }}" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body">
                                    <button class="uk-modal-close-default" type="button" uk-close></button>
                                    <h2 class="uk-modal-title">Thông tin chi tiết HomeStay</h2>
                                    <div class="form-row mb15">
                                        <label for="">Tiêu đề :</label>
                                        <input type="text" value="{{ $item['name'] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Địa chỉ :</label>
                                        <input type="text" value="{{ $item['address'] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Giờ mở cửa :</label>
                                        <input type="text" value="{{ __('messages.open_hours')[$item['open_hours']] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Số phòng :</label>
                                        <input type="text" value="{{ __('messages.total_rooms')[$item['total_rooms']] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Số khách hiện tại :</label>
                                        <input type="text" value="{{ __('messages.current_guests')[$item['current_guests']] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Vĩ độ :</label>
                                        <input type="text" value="{{ $item['lat'] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Kinh độ :</label>
                                        <input type="text" value="{{ $item['long'] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Tỉnh / thành phố :</label>
                                        <input type="text" value="{{ $item['name_city'] }}" class="form-control">
                                    </div>
                                    <div class="form-row mb15">
                                        <label for="">Tình trạng :</label>
                                        <input type="text" value="{{ $item['description'] }}" class="form-control">
                                    </div>
                                    <p class="uk-text-right">
                                        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <script>
        var homeStay = @json($homeStay);
        var open_hours = @json(__('messages.open_hours'));
        var total_rooms = @json(__('messages.total_rooms'));
        var current_guests = @json(__('messages.current_guests'));
    </script>
@endsection

