<div id="index-slider" class="owl-carousel">
    @if($latestSliders->count() > 0)
    @foreach($latestSliders as $slider)
    <section style="background: url({{$slider->getPhotoUrl()}}); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1 style="height:100px">{{$slider->name}}</h1>
                    <a href="{{$slider->getButtonUrl()}}" alt='{{$slider->name}}' class="hero-link">{{$slider->button_title}}</a>
                </div>
            </div>
        </div>
    </section>
    @endforeach
    @endif
</div>
