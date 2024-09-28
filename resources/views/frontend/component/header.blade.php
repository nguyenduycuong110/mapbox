<div id="header" class="pc-header uk-visible-large uk-position-relative">
	<div class="header-middle">
		<div class="uk-container uk-container-center">
			@include('frontend.component.navigation')
		</div>
	</div>
    <div class="header-upper">
		<div class="uk-container uk-container-center">
			<div class="uk-flex uk-flex-middle uk-flex-space-between">
				@if(!is_null($customerAuth))
					<div class="upper-right">
						<div class="profile">
							<a href="{{ route('customer.profile') }}" class="image img-cover">
								<img src="https://scontent.fhan14-5.fna.fbcdn.net/v/t1.30497-1/453178253_471506465671661_2781666950760530985_n.png?stp=cp0_dst-png_s40x40&_nc_cat=1&ccb=1-7&_nc_sid=136b72&_nc_eui2=AeFFT0qB5mVWaFSgmAE4mYPOWt9TLzuBU1Ba31MvO4FTUCuPXpJt5ztyGLak94OdIDdjsCSwktwj2t2dtRU6Uvw8&_nc_ohc=rNanvdXoqvgQ7kNvgHndQoM&_nc_ht=scontent.fhan14-5.fna&oh=00_AYB1LM3SxwjzAEyRR5-SnDoV8WvO9N4sy12fbCyrC6KqAQ&oe=6708AF7A" alt="">
							</a>
						</div>
						<div class="item">
							<a href="" class="notification" data-alert="{{ $customerAuth->alert }}" data-customer="{{ $customerAuth->id }}">
								@if($total_read != 0)
									<span 
										class="count" 
										data-count="{{ $total_read }}"
									>
										{{ $total_read }}
									</span>
								@endif
								<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" class="x19dipnz x1lliihq x1tzjh5l x1k90msu x2h7rmj x1qfuztq" style="--color: var(--primary-icon);"><path d="M3 9.5a9 9 0 1 1 18 0v2.927c0 1.69.475 3.345 1.37 4.778a1.5 1.5 0 0 1-1.272 2.295h-4.625a4.5 4.5 0 0 1-8.946 0H2.902a1.5 1.5 0 0 1-1.272-2.295A9.01 9.01 0 0 0 3 12.43V9.5zm6.55 10a2.5 2.5 0 0 0 4.9 0h-4.9z"></path></svg>
							</a>
							@if(!is_null($notifications) && $customerAuth->alert == 1)
								@php
									$customer_id = $customerAuth->id;
									$time = date('Y-m-d H:i:s', time());  
									$countEvent = \App\Models\CustomerEvent::join('events', 'customer_event.event_id', '=', 'events.id')  
										->where('customer_event.customer_id', $customer_id) 
										->where('events.startDate', '<=', $time)
										->where('events.endDate', '>=', $time)  
										->get();
								@endphp
								<ul class="notification-list">
									<h3 class="heading-2">Thông báo</h3>
									@if(!is_null($countEvent))
										@foreach($countEvent as $key => $val)
										    <li>
												<a href="{{ write_url('event/'.$val->id.'/canonical') }}" class="btn-success">
													<div class="title">
														<p class="name">{{ $val->name }}</p>
													</div>
												</a>
											</li>
										@endforeach
									@endif
									@foreach($notifications as $key => $val)
										<li>
											<a href="{{ write_url($val->canonical)  }}" class="l1" >
												<div class="thumb image img-cover">
													<img src="{{ $val->image }}" alt="">
												</div>
												<div class="title">
													<p class="name">{{ $val->name }}</p>
													<p data-time="{{ $val->created_at }}" class="time">{{ $val->created_at->diffForHumans() }}</p>
												</div>
											</a>
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>

</div>
<div id="mobileCanvas" class="uk-offcanvas offcanvas" >
    <div class="uk-offcanvas-bar" >
        @if(isset($menu['mobile']))
		<ul class="l1 uk-nav uk-nav-offcanvas uk-nav uk-nav-parent-icon" data-uk-nav>
			@foreach ($menu['mobile'] as $key => $val)
            @php
                $name = $val['item']->languages->first()->pivot->name;
                $canonical = write_url($val['item']->languages->first()->pivot->canonical, true, true);
            @endphp
			<li class="l1 {{ (count($val['children']))?'uk-parent uk-position-relative':'' }}">
                <?php echo (isset($val['children']) && is_array($val['children']) && count($val['children']))?'<a href="#" title="" class="dropicon"></a>':''; ?>
				<a href="{{ $canonical }}" title="{{ $name }}" class="l1">{{ $name }}</a>
				@if(count($val['children']))
				<ul class="l2 uk-nav-sub">
					@foreach ($val['children'] as $keyItem => $valItem)
                    @php
                        $name_2 = $valItem['item']->languages->first()->pivot->name;
                        $canonical_2 = write_url($valItem['item']->languages->first()->pivot->canonical, true, true);
                    @endphp
					<li class="l2">
                        <a href="{{ $canonical_2 }}" title="{{ $name_2 }}" class="l2">{{ $name_2 }}</a>
                    </li>
					@endforeach
				</ul>
				@endif
			</li>
			@endforeach
		</ul>
		@endif
	</div>
</div>