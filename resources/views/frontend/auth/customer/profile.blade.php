@extends('frontend.homepage.layout')
@section('content')
    <div class="profile-container pt20 pb20">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4">
                    @include('frontend.auth.customer.components.sidebar')
                </div>
                <div class="uk-width-large-2-4">
                    <div class="panel-profile">
                        <div class="panel-head mb20">
                            <h2 class="heading-2"><span>Hồ sơ của tôi</span></h2>
                            <div class="description">
                                Quản lý thông tin hồ sơ để bảo mật tài khoản
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('backend/dashboard/component/formError')
                            <form action="{{ route('customer.profile.update') }}" method="post" class="uk-form uk-form-horizontal login-form profile-form">
                                @csrf
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Tài khoản đăng nhập</label>
                                    <div class="uk-form-controls">
                                        {{ $customer->email }} <span class="text-danger">({{ $customer->customer_catalogues->name }})</span>
                                    </div>
                                </div>
                                
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Họ Tên</label>
                                    <div class="uk-form-controls">
                                        <input 
                                            type="text" 
                                            class="input-text"
                                            placeholder="Họ Tên"
                                            name="name"
                                            value="{{ old('name', $customer->name) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Email</label>
                                    <div class="uk-form-controls">
                                        <input 
                                            type="text" 
                                            class="input-text"
                                            placeholder="Email"
                                            name="email"
                                            value="{{ old('email', $customer->email) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Số điện thoại</label>
                                    <div class="uk-form-controls">
                                        <input 
                                            type="text" 
                                            class="input-text"
                                            placeholder="Số điện thoại"
                                            name="phone"
                                            value="{{ old('phone', $customer->phone) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Địa chỉ</label>
                                    <div class="uk-form-controls">
                                        <input 
                                            type="text" 
                                            class="input-text"
                                            placeholder="Địa chỉ"
                                            name="address"
                                            value="{{ old('address', $customer->address) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Nhập mã Code</label>
                                    <div class="uk-form-controls">
                                        <input 
                                            type="text" 
                                            class="input-text"
                                            placeholder=""
                                            name="code_premium"
                                            value=""
                                            {{ $customer->customer_catalogues->id == 5 ? 'disabled' : '' }}
                                        >
                                    </div>
                                </div>
                                <input type="hidden" data-id="{{  $customer->id }}" class="customerId ">
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Đăng ký nhận thông báo</label>
                                    <div class="uk-form-controls">
                                        <a href="" class="notification {{ $customer->alert == 1 ? 'active' : '' }}" data-alert="{{ $customer->alert }}">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="x19dipnz x1lliihq x1tzjh5l x1k90msu x2h7rmj x1qfuztq" style="--color: var(--primary-icon);"><path d="M3 9.5a9 9 0 1 1 18 0v2.927c0 1.69.475 3.345 1.37 4.778a1.5 1.5 0 0 1-1.272 2.295h-4.625a4.5 4.5 0 0 1-8.946 0H2.902a1.5 1.5 0 0 1-1.272-2.295A9.01 9.01 0 0 0 3 12.43V9.5zm6.55 10a2.5 2.5 0 0 0 4.9 0h-4.9z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                                <button type="submit" name="send" value="create">Lưu thông tin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



