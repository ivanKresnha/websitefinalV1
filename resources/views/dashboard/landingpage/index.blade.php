@extends('layout.landingpage.index')

@section('title', 'LANDINGPAGE | RFF')

@section('container')

    <!-- Banner Part Start -->
    <section id="home" class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner_text">
                        <div class="banner_text_iner">
                            <h5>Segar, Praktis, Lezat</h5>
                            <h1>Rida Frozen Food - Nuget Terbaik untuk Keluarga</h1>
                            <p>
                                Rasakan nuget premium dengan rasa istimewa yang membuat
                                keluarga tersenyum. Solusi mudah untuk sajian cepat dan lezat
                                setiap hari! Dibuat dari bahan berkualitas tinggi, nuget kami
                                hadir dengan tekstur renyah di luar, lembut di dalam, dan rasa
                                yang tak terlupakan. Cocok untuk bekal anak, camilan santai,
                                atau lauk makan keluarga. Pilih Rida Frozen Food, dan jadikan
                                setiap momen makan lebih spesial!
                            </p>

                            <div class="banner_btn">
                                <div class="banner_btn_iner">
                                    <a href="{{ route('login') }}" class="btn_2">Pesan Sekarang
                                        <img src="{{ asset('assets_landingpage/img/icon/left_2.svg') }}"
                                            alt="" /></a>
                                </div>
                                {{-- <a href="https://www.youtube.com/watch?v=pBFQdxA-apI" class="popup-youtube video_popup">
                                    <span><img src="{{ asset('assets_landingpage/img/icon/left_2.svg') }}" alt="" /></span> Lihat
                                    Video Kami</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Part End -->

    <!-- Produk Terbaik -->
    <section id="rekomendasi" class="exclusive_item_part blog_item_section">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <div class="section_tittle">
                        <p>Produk Terbaik</p>
                        <h2>Rekomendasi dari Rida Frozen Food</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($produkTerbaik as $produk)
                    <div class="col-sm-6 col-lg-4">
                        <div class="single_blog_item">
                            <div class="single_blog_img">
                                <img src="{{ asset('storage/uploads/produk/' . $produk->gambar_produk) }}"
                                    alt="{{ $produk->nama }}"
                                    style="width: 100%; height: 250px; object-fit: cover; border-radius: 8px;" />
                            </div>
                            <div class="single_blog_text">
                                <h3>{{ $produk->nama }}</h3>
                                {{-- Menambahkan stok terjual --}}
                                <p>Stok Terjual: {{ $produk->stok_terjual }}</p>
                                <p>{{ $produk->deskripsi }}</p>
                                <a href="{{ route('login') }}" class="btn_3">Read More <img
                                        src="{{ asset('assets_landingpage/img/icon/left_2.svg') }}" alt="" /></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>



        </div>
    </section>
    <!--::exclusive_item_part end::-->

    <!-- about part start-->
    <section id="tentang_kami" class="about_part">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-4 col-lg-5 offset-lg-1">
                    <div class="about_img">
                        <img src="{{ asset('assets_landingpage/img/about.png') }}" alt="Tentang Kami" />
                        {{-- src="{{ asset('assets_landingpage/img/icon/left_2.svg') }}" --}}
                    </div>
                </div>
                <div class="col-sm-8 col-lg-4">
                    <div class="about_text">
                        <h5>Tentang Kami</h5>
                        <h2>Partner Resmi Anda dalam Produk Frozen Food Berkualitas</h2>
                        <h4>Menyediakan Berbagai Makanan Beku dengan Harga Terjangkau</h4>
                        <p>
                            Rida Frozen Food adalah reseller terpercaya yang menyediakan
                            produk frozen food berkualitas tinggi langsung dari produsen
                            terbaik. Kami menawarkan berbagai pilihan seperti nugget, sosis,
                            kentang, dan banyak lagi, yang cocok untuk kebutuhan bisnis
                            kuliner Anda atau untuk keperluan pribadi. Dengan harga
                            kompetitif dan pengiriman cepat, kami siap memenuhi permintaan
                            Anda dengan kualitas terjamin.
                        </p>
                        <a href="#" class="btn_3">Selengkapnya
                            <img src="{{ 'assets_landingpage/img/icon/left_2.svg' }}" alt="" />

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about part end-->

    <!--::owner_and_developer_part start-->
    <section id="owner_developer" class="owner_and_developer_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Left: Owner (Purwiyani) -->
                <div class="col-sm-6 col-lg-4"
                    style="display: flex; justify-content: center; align-items: center; height: 100%; padding: 20px;">
                    <div class="single_blog_item"
                        style="max-width: 300px; text-align: center; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        <div class="single_blog_img">
                            <img src="{{ asset('assets_landingpage/asset_tambahan/owner_developer/owner.jpg') }}"
                                alt="Purwiyani"
                                style="width: 100%; height: 250px; object-fit: cover; border-radius: 50%; margin-bottom: 15px;" />
                        </div>
                        <div class="single_blog_text">
                            <h3>Purwiyani</h3>
                            <p>Owner & Founder</p>
                            <p style="font-size: 16px; color: #555">
                                Sebagai pendiri dan pemilik **Rida Frozen Food**, saya
                                berkomitmen untuk menyediakan produk frozen food berkualitas
                                tinggi bagi masyarakat Indonesia. Dengan pengalaman di
                                industri makanan, saya terus mengembangkan dan memperkenalkan
                                produk yang dapat memenuhi kebutuhan konsumen di seluruh
                                Indonesia.
                            </p>
                            <div class="social_icon" style="display: flex; justify-content: center; gap: 10px"></div>
                        </div>
                    </div>
                </div>

                <!-- Right: Developer (Individual Work) -->
                <div class="col-sm-6 col-lg-4"
                    style="display: flex; justify-content: center; align-items: center; height: 100%; padding: 20px;">
                    <div class="single_blog_item"
                        style="max-width: 300px; text-align: center; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        <div class="single_blog_img">
                            <img src="{{ asset('assets_landingpage/asset_tambahan/owner_developer/developer.jpg') }}"
                                alt="Developer"
                                style="width: 100%; height: 250px; object-fit: cover; border-radius: 50%; margin-bottom: 15px;" />
                        </div>
                        <div class="single_blog_text">
                            <h3>Developer</h3>
                            <p>Web Developer</p>
                            <p style="font-size: 16px; color: #555">
                                Sebagai pengembang dan pengelola **Rida Frozen Food** secara
                                pribadi, saya bertanggung jawab untuk membangun dan mengelola
                                website dan aplikasi. Fokus saya adalah memberikan pengalaman
                                pengguna terbaik dengan teknologi terkini, serta memastikan
                                sistem operasional berjalan dengan lancar dan efisien.
                            </p>
                            <div class="social_icon" style="display: flex; justify-content: center; gap: 10px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::owner_and_developer_part end-->

    {{-- section produk --}}
    <section id="produk" class="food_menu gray_bg">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="section_tittle">
                        <p>Produk Populer</p>
                        <h2>Produk Lezat Kami</h2>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="nav nav-tabs food_menu_nav" id="myTab" role="tablist">
                        <a class="prev-tab disabled" id="prev-tab" data-toggle="tab" href="#Prev" role="tab"
                            aria-controls="Prev" aria-selected="false">Prev
                            <img src="{{ asset('assets_landingpage/img/icon/play.svg') }}" alt="play" />
                        </a>

                        @foreach ($categories as $category)
                            <a class="{{ $loop->first ? 'active' : '' }}" id="tab-{{ Str::slug($category->nama) }}"
                                data-toggle="tab" href="#{{ Str::slug($category->nama) }}" role="tab"
                                aria-controls="{{ Str::slug($category->nama) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $category->nama }}
                                <img src="{{ asset('assets_landingpage/img/icon/play.svg') }}" alt="play" />
                            </a>
                        @endforeach

                        <a class="next-tab" id="next-tab" data-toggle="tab" href="#Next" role="tab"
                            aria-controls="Next" aria-selected="false">Next
                            <img src="{{ asset('assets_landingpage/img/icon/play.svg') }}" alt="play" />
                        </a>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="tab-content" id="myTabContent">
                        @foreach ($categories as $category)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="{{ Str::slug($category->nama) }}" role="tabpanel"
                                aria-labelledby="tab-{{ Str::slug($category->nama) }}">
                                <div class="row">
                                    @forelse ($category->products as $product)
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="single_food_item media"
                                                style="border: 1px solid #f0f0f0; padding: 15px; border-radius: 10px;">
                                                <img src="{{ asset('storage/uploads/produk/' . $product->gambar_produk) }}"
                                                    class="mr-3" alt="{{ $product->nama }}"
                                                    style="width: auto; height: 100%; max-height: 150px; object-fit: cover; border-radius: 8px;" />
                                                <div class="media-body align-self-center">
                                                    <h3>{{ $product->nama }}</h3>
                                                    <p>{{ $product->deskripsi }}</p>
                                                    <div class="btn-wrap" style="margin-top: 15px;">
                                                        <h5>Rp{{ number_format($product->harga, 0, ',', '.') }}</h5>
                                                        <a href="#" class="genric-btn primary circle"
                                                            style="margin-top: 10px;">Pesan Sekarang
                                                            <span class="lnr lnr-arrow-right"></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center w-100">Tidak ada produk dalam kategori ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- end section produk --}}



    <!--::lokasi_part start::-->
    <section id="kontak_kami" style="padding: 50px 0; background-color: #f9f9f9;">
        <div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 15px;">
            <!-- Title Section -->
            <div style="display: flex; justify-content: center; flex-wrap: wrap; margin-bottom: 30px;">
                <div style="flex: 1 1 100%; text-align: center;">
                    <p style="font-size: 18px; color: #666; margin: 0;">Lokasi</p>
                    <h2 style="font-size: 36px; color: #333; margin: 10px 0;">Visit Our Store</h2>
                </div>
            </div>

            <!-- Kontak dan Map dalam 1 Card -->
            <div
                style="background-color: #fff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px;">
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <!-- Kontak -->
                    <div style="flex: 1 1 100%; max-width: 48%; box-sizing: border-box;">
                        <div style="padding: 20px;">
                            <h3 style="font-size: 24px; color: #333; margin-bottom: 20px; text-align: center;">Contact
                                Us</h3>

                            <!-- WhatsApp Section -->
                            <div
                                style="margin-bottom: 20px; padding: 15px; border: 1px solid #eaeaea; border-radius: 8px;">
                                <h5 style="font-size: 18px; color: #666; margin-bottom: 5px;">WhatsApp</h5>
                                <p style="font-size: 16px; color: #555; margin-bottom: 10px;">
                                    Contact us via WhatsApp for fast response.
                                </p>

                                <a href="https://wa.me/6285211053507?text=Halo%20saya%20tertarik%20dengan%20produk%20Anda"
                                    target="_blank"
                                    style="display: block; text-align: center; background-color: #28a745; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
                                    Chat on WhatsApp
                                </a>

                                <!-- <a href="https://wa.me/6285211053507" target="_blank"
                                            style="display: block; text-align: center; background-color: #28a745; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
                                            Chat on WhatsApp
                                        </a> -->
                            </div>

                            <!-- Address Section -->
                            <div
                                style="margin-bottom: 20px; padding: 15px; border: 1px solid #eaeaea; border-radius: 8px;">
                                <h5 style="font-size: 18px; color: #666; margin-bottom: 5px;">Store Address</h5>
                                <p style="font-size: 16px; color: #555;">Jl. Puri Cendana No.137, Sumberjaya, Kec. Tambun
                                    Sel., Kabupaten Bekasi, Jawa Barat 17510</p>
                            </div>

                            <!-- Email Section -->
                            <div style="padding: 15px; border: 1px solid #eaeaea; border-radius: 8px;">
                                <h5 style="font-size: 18px; color: #666; margin-bottom: 5px;">Email</h5>
                                <p style="font-size: 16px; color: #555; margin-bottom: 10px;">For inquiries, email us
                                    at: Rivandutakresnha1@gmail.com</p>
                                <a href="mailto:Rivandutakresnha1@gmail.com"
                                    style="display: block; text-align: center; background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 4px; text-decoration: none;">
                                    Send Email
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div style="flex: 1 1 100%; max-width: 48%; box-sizing: border-box;">
                        <div style="padding: 20px;">
                            <h3 style="font-size: 24px; color: #333; margin-bottom: 20px; text-align: center;">Find Us
                                on Map</h3>
                            <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!4v1736757992551!6m8!1m7!1sWjuW0wNG3WV4yVDK1XvwGA!2m2!1d-6.234770181087271!2d107.0678619280391!3f241.9163465782868!4f-8.870141784933395!5f0.7820865974627469"
                                    frameborder="0" style="width: 100%; height: 400px; border: 0;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::lokasi_part end::-->

    <!--::review_part start::-->
    <section id="testimoni" class="review_part gray_bg section_padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <div class="section_tittle">
                        <p>Testimonials</p>
                        <h2>Ulasan Customers</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-11 mx-auto">
                    <div class="client_review_part owl-carousel">
                        @foreach ($produkTerbaik as $product)
                            <!-- Loop through the products -->
                            @foreach ($product->reviews as $review)
                                <!-- Loop through the reviews for each product -->
                                <div class="client_review_single media p-3">
                                    <div class="client_img align-self-center mr-4">
                                        <img src="{{ asset('storage/uploads/ulasan/' . $review->gambar_ulasan) }}"
                                            class="rounded-circle"
                                            style="width: 80px; height: 80px; object-fit: cover;" />
                                    </div>
                                    <div class="client_review_text media-body">
                                        <p class="mb-3" style="font-size: 1rem; line-height: 1.5;">
                                            "{{ $review->ulasan }}"
                                        </p>
                                        <p class="mb-3" style="font-size: 1rem; line-height: 1.5;">
                                            Rating: {{ $review->rating }} / 5
                                        </p>
                                        <h4 class="mb-0" style="font-size: 1.2rem; font-weight: 600;">
                                            {{ $review->user->name }},
                                            <span style="font-size: 0.9rem; color: gray;">
                                                <!-- Menampilkan jabatan berdasarkan role_id -->
                                                @if ($review->user->role_id == 1)
                                                    Admin
                                                @elseif ($review->user->role_id == 2)
                                                    Customer
                                                @else
                                                    User
                                                @endif
                                                | {{ $review->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::review_part end::-->




@endsection
