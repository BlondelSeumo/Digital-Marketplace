@if ($testimonialsSection && $testimonials->count() > 0)
    <section class="section">
        <div class="container container-custom">
            <div class="section-inner">
                <div class="section-header text-center text-lg-start">
                    <div class="row align-items-center justify-content-between g-3">
                        <div class="col-12 col-lg-8 col-xl-7 col-xxl-6">
                            <h2 class="section-title" data-aos="fade-down" data-aos-duration="1000">
                                {{ $testimonialsSection->name }}
                            </h2>
                            @if ($testimonialsSection->description)
                                <p class="section-text" data-aos="fade-down" data-aos-duration="1000"
                                    data-aos-delay="200">
                                    {{ $testimonialsSection->description }}
                                </p>
                            @endif
                        </div>
                        <div class="col-12 col-lg-auto d-flex justify-content-center" data-aos="fade-left"
                            data-aos-duration="1000" data-aos-delay="600">
                            <div class="swiper-actions d-flex gap-2">
                                <div id="testimonials-swiper-prev" class="swiper-button-prev position-static">
                                    <i class="fa fa-chevron-left"></i>
                                </div>
                                <div id="testimonials-swiper-next" class="swiper-button-next position-static">
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="swiper testimonials-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide" data-aos="zoom-in" data-aos-duration="1000">
                                    <div class="testimonial" data-aos="zoom-in" data-aos-duration="1000">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="testimonial-avatar">
                                                <img src="{{ $testimonial->getAvatar() }}"
                                                    alt="{{ $testimonial->name }}" />
                                            </div>
                                            <div class="testimonial-info">
                                                <h6 class="testimonial-title mb-1">{{ $testimonial->name }}</h6>
                                                <p class="testimonial-jobtitle">{{ $testimonial->title }}</p>
                                            </div>
                                        </div>
                                        <p class="testimonial-message">
                                            {{ $testimonial->body }}
                                        </p>
                                        <div class="testimonial-ratings mt-auto">
                                            @include('themes.basic.partials.rating-stars', [
                                                'stars' => $testimonial->stars,
                                                'ratings_classes' => 'ratings-lg',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
