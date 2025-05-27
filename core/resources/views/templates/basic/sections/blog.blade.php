@php
    $blogContent = getContent('blog.content', true);
    $blogElements = getContent('blog.element', false, 3);
@endphp
<div class="section--sm section--top">
    <div class="section__head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="text-md-center">
                        <h3 class="mt-0 mb-4 text-md-center">
                            {{ __(@$blogContent->data_values->heading) }}
                        </h3>
                        <p class="mb-0 text-md-center section__para mx-md-auto">
                            {{ __(@$blogContent->data_values->description) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 g-lg-3 g-xxl-4 justify-content-center">
            @foreach (@$blogElements ?? [] as $blogElement)
                <div class="col-md-6 col-lg-4">
                    <div class="blog-post">
                        <div class="blog-post__img">
                            <img src="{{ frontendImage('blog', 'thumb_' . @$blogElement->data_values->image, '415x280') }}"
                                alt="blog image" class="blog-post__img-is">
                            <a href="{{ route('blog.details', $blogElement->slug) }}"
                                class="t-link blog-post__img-link">
                                <span class="d-inline-block">
                                    <i class="las la-plus"></i>
                                </span>
                            </a>
                        </div>
                        <div class="blog-post__body">
                            <ul class="list list--row">
                                <li class="list--row__item">
                                    <div class="blog-post__meta">
                                        <span class="t-link t-link--base blog-post__meta-text">
                                            {{ $blogElement->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </li>
                            </ul>
                            <h5 class="mt-3">
                                <a href="{{ route('blog.details', $blogElement->slug) }}"
                                    class="t-link blog-post__link">
                                    {{ __($blogElement->data_values->title) }}
                                </a>
                            </h5>
                            <p>
                                @php
                                    echo strLimit(strip_tags($blogElement->data_values->description), 120);
                                @endphp
                            </p>
                            <a href="{{ route('blog.details', $blogElement->slug) }}" class="t-link blog-post__btn">
                                @lang('Read More')
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
