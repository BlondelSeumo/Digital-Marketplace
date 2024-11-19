<div class="plan">
    @if ($plan->isFeatured())
        <div class="plan-pro">
            {{ translate('Featured') }}
        </div>
    @endif
    <h5 class="plan-title">{{ $plan->name }}</h5>
    <div class="plan-price active mb-2">
        @if (!$plan->isFree())
            {{ $plan->getFormatPrice() }} <span>/{{ strtolower($plan->getIntervalName()) }}</span>
        @else
            {{ translate('Free') }}
        @endif
    </div>
    <p class="plan-text">{{ $plan->description }}</p>
    <form action="{{ route('premium.subscribe', $plan->id) }}" method="POST">
        @csrf
        @auth
            @if (authUser()->subscribedToPlan($plan->id))
                @if (authUser()->subscription->isAboutToExpire() && !authUser()->subscription->plan->isFree())
                    <button
                        class="btn {{ $plan->isFeatured() ? 'btn-warning' : 'btn-outline-warning' }} btn-lg action-confirm w-100">
                        {{ translate('Renew') }}
                    </button>
                @elseif(authUser()->subscription->isExpired() && !authUser()->subscription->plan->isFree())
                    <button
                        class="btn {{ $plan->isFeatured() ? 'btn-danger' : 'btn-outline-danger' }} btn-lg action-confirm w-100">
                        {{ translate('Renew') }}
                    </button>
                @elseif(authUser()->subscription->isExpired() && authUser()->subscription->plan->isFree())
                    <button class="btn btn-danger btn-lg w-100" disabled>
                        {{ translate('Expired') }}
                    </button>
                @else
                    <button class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100"
                        disabled>
                        {{ translate('Subscribed') }}
                    </button>
                @endif
            @else
                <button
                    class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg action-confirm w-100">
                    {{ translate('Start Now') }}
                </button>
            @endif
        @else
            <a href="{{ route('login') }}"
                class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100">
                {{ translate('Start Now') }}
            </a>
        @endauth
    </form>
    <div class="plan-features">
        <div class="plan-feat">
            <div class="plan-feat-icon">
                <i class="fa fa-check"></i>
            </div>
            @if ($plan->hasUnlimitedDownloads())
                <span>{{ translate('Unlimited downloads') }}</span>
            @else
                <span>{{ translate(':count downloads per day', ['count' => number_format($plan->downloads)]) }}</span>
            @endif
        </div>
        @if ($plan->custom_features)
            @foreach ($plan->custom_features as $customFeature)
                <div class="plan-feat">
                    <div class="plan-feat-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <span>{{ $customFeature }}</span>
                </div>
            @endforeach
        @endif
    </div>
</div>
