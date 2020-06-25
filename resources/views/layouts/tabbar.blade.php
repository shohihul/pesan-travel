
<!-- Tabbar -->
<div class="tabbar tabbar tabbar--material">
    <label class="tabbar__item tabbar--material__item" @if ($pageSlug == 'home') id="active" @endif>
        <a class="tabbar__button tabbar--material__button" href="{{route('customer.home')}}">
            <i class="tabbar__icon tabbar--material__icon zmdi zmdi-home"></i>
        </a>
    </label>

    <label class="tabbar__item tabbar--material__item">
        <a class="tabbar__button tabbar--material__button">
            <i class="tabbar__icon tabbar--material__icon zmdi zmdi-calendar-note"></i>
        </a>
    </label>

    <label class="tabbar__item tabbar--material__item" @if ($pageSlug == 'profile') id="active" @endif>
        <a class="tabbar__button tabbar--material__button" href="{{route('customer.profile')}}">
            <i class="tabbar__icon tabbar--material__icon zmdi zmdi-account"></i>
        </a>
    </label>
</div>
<!-- Tabbar -->