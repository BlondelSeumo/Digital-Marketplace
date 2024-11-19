@if ($faqsSection && $faqs->count() > 0)
    <section class="section">
        <div class="container container-custom">
            <div class="section-inner">
                <div class="section-header text-center">
                    <h2 class="section-title" data-aos="fade-down" data-aos-duration="1000">
                        {{ $faqsSection->name }}
                    </h2>
                    @if ($faqsSection->description)
                        <p class="section-text col-lg-6 mx-auto" data-aos="fade-down" data-aos-duration="1000"
                            data-aos-delay="200">
                            {{ $faqsSection->description }}
                        </p>
                    @endif
                </div>
                <div class="section-body">
                    <div class="accordion accordion-custom" id="accordion">
                        <div class="row row-cols-1 row-cols-xl-2 g-3">
                            @foreach ($faqs as $faq)
                                <div class="col" data-aos="zoom-in-up"
                                    data-aos-duration="{{ ($loop->index + 1) * 100 }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
                                                <span> {{ $faq->title }}</span>
                                                <div class="accordion-button-icon">
                                                    <i class="fa fa-chevron-down"></i>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                            <div class="accordion-body">
                                                {!! $faq->body !!}
                                            </div>
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
